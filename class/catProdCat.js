function readRecords() {
    $.get("action/readcatProdCat.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val();

    $.post("action/addcatProdCat.php", {
        nombre: nombre
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
    });
}

function Unlock(id) {
    
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockcatProdCat.php", {
            id: id
        },
            function (data, status) {
                readRecords();
            }
            );
    }
}
function Lock(id) {
    var conf = confirm("¿Está seguro, realmente desea desactivar el registro seleccionado?");
    if (conf == true) {
        $.post("action/lockcatProdCat.php", {
            id: id
        },
            function (data, status) {
                readRecords();
            }
            );
    }
}
function Update(id) {
    $("#hidden_id").val(id);
    $.post("action/readcatProdCatdata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
        }
        );
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var nombre = $("#update_nombre").val();
    var id = $("#hidden_id").val();

    $.post("action/updatecatProdCat.php", {
        id: id,
        nombre: nombre
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}

function validaCampos() {
    var nombre = $("#nombre").val();

    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    addRecord();    
}

function updateValida() {
    var nombre = $("#update_nombre").val();

    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#update_nombre').focus();
        return false;
    }
    UpdateDetail();     
}

$(document).ready(function () {
    readRecords(); // Lee registros
    $("#search").on("keyup", function () { //busca registro por campo nombre
        var term = $(this).val().toLowerCase();
        $("table tbody tr").each(function () {
            $row = $(this);
            var name = $row.find("td:nth-child(2)").text().toLowerCase();
            console.log(name);
            if (name.search(term) < 0) {       
                $row.hide();
            } else {
                $row.show();
            }
        });
    });
});