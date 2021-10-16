function readRecords() {
    $.get("action/readcatEmpleado.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val();
    var puesto = $("#puesto").val();

    $.post("action/addcatEmpleado.php", {
        nombre: nombre,
        puesto: puesto
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#puesto").val("");
    });
}

function Unlock(id) {
    
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockcatEmpleado.php", {
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
        $.post("action/lockcatEmpleado.php", {
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
    $.post("action/readcatEmpleadodata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
            $("#update_puesto").val(dato.puesto);
        }
        );

    $("#update_modal").modal("show");
}
function UpdateDetail() {
    var nombre = $("#update_nombre").val();
    var puesto = $("#update_puesto").val();
    var id = $("#hidden_id").val();
    
    $.post("action/updatecatEmpleado.php", {
        id: id,
        nombre: nombre,
        puesto: puesto
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}

function validaCampos() {
    var nombre = $("#nombre").val();
    var puesto = $("#puesto").val();
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    if ($.trim(puesto) == "") {
        toastr.error("No ha ingresado puesto", "Aviso!");
        $('#puesto').focus();
        return false;
    }    
    addRecord();
}

function updateValida() {
    var nombre = $("#update_nombre").val();
    var puesto = $("#update_puesto").val();

    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#update_nombre').focus();
        return false;
    }
    if ($.trim(puesto) == "") {
        toastr.error("No ha ingresado puesto", "Aviso!");
        $('#update_puesto').focus();
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