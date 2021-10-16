function readRecords() {
    $.get("action/readcatTipoOC.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var descripcion = $("#descripcion").val();
    var precio = $("#precio").val();

    $.post("action/addcatTipoOC.php", {
        descripcion: descripcion,
        precio: precio
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#descripcion").val("");
    });
}

function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockcatTipoOC.php", {
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
        $.post("action/lockcatTipoOC.php", {
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
    $.post("action/readcatTipoOCdata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_descripcion").val(dato.descripcion);
            $("#update_precio").val(dato.precio);
        }
        );
                // Open modal popup
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var descripcion = $("#update_descripcion").val();
    var precio = $("#update_precio").val();
    var id = $("#hidden_id").val();

    $.post("action/updatecatTipoOC.php", {
        id: id,
        descripcion: descripcion,
        precio: precio
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}

function validaCampos() {
    var descripcion = $("#descripcion").val();

    if ($.trim(descripcion) == "") {
        toastr.error("No ha ingresado descripcion", "Aviso!");
        $('#descripcion').focus();
        return false;
    }
    addRecord();
}

function updateValida() {
    var descripcion = $("#update_descripcion").val();

    if ($.trim(descripcion) == "") {
        toastr.error("No ha ingresado descripcion", "Aviso!");
        $('#update_descripcion').focus();
        return false;
    }
    UpdateDetail();
}

$(document).ready(function () {
    readRecords(); // Lee registros
    $("#search").on("keyup", function () { //busca registro por campo descripcion
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