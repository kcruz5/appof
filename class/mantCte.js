function readRecords() {
    $.get("action/readmantCte.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var contacto = $("#contacto").val();
    var tipo = $("#tipo").val();
    var limite = $("#limite").val();

    $.post("action/addmantCte.php", {
        nombre: nombre,
        direccion: direccion,
        telefono: telefono,
        contacto: contacto,
        tipo: tipo,
        limite: limite
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#direccion").val("");
        $("#telefono").val("");
        $("#contacto").val("");
        $("#limite").val("0.00");
    });
}

function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockmantCte.php", {
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
        $.post("action/lockmantCte.php", {
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
    $.post("action/readmantCtedata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
            $("#update_direccion").val(dato.direccion);
            $("#update_telefono").val(dato.telefono);
            $("#update_contacto").val(dato.contacto);
            $("#update_limite").val(dato.limite);
            $("#update_tipo").val(dato.tipo);
        }
        );
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var telefono = $("#update_telefono").val();
    var contacto = $("#update_contacto").val();
    var tipo = $("#update_tipo").val();
    var limite = $("#update_limite").val();
    var id = $("#hidden_id").val();

    $.post("action/updatemantCte.php", {
        id: id,
        nombre: nombre,
        direccion: direccion,
        telefono: telefono,
        contacto: contacto,
        tipo: tipo,
        limite: limite
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}

function validaCampos() {
    var nombre = $("#nombre").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var contacto = $("#contacto").val();
    var limite = $("#limite").val();
    var regex = /^(\d{1,7})(?:.\d{1,2})?$/;
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    if ($.trim(direccion) == "") {
        toastr.error("No ha ingresado dirección", "Aviso!");
        $('#direccion').focus();
        return false;
    }
        
    if ($.trim(telefono) == "") {
        toastr.error("No ha ingresado teléfono", "Aviso!");
        $('#telefono').focus();
        return false;
    }

    if ($.trim(contacto) == "") {
        toastr.error("No ha ingresado contacto", "Aviso!");
        $('#contacto').focus();
        return false;
    }
    if (regex.test(limite)) {
        addRecord();
    } else {
        toastr.error("Límite de crédito inválido", "Aviso!");
        $('#limite').focus();
        return false;
    }
}


function updateValida() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var telefono = $("#update_telefono").val();
    var contacto = $("#update_contacto").val();
    var limite = $("#update_limite").val();
    var regex = /^(\d{1,7})(?:.\d{1,2})?$/;
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#update_nombre').focus();
        return false;
    }
    if ($.trim(direccion) == "") {
        toastr.error("No ha ingresado dirección", "Aviso!");
        $('#update_direccion').focus();
        return false;
    }
        
    if ($.trim(telefono) == "") {
        toastr.error("No ha ingresado teléfono", "Aviso!");
        $('#update_telefono').focus();
        return false;
    }

    if ($.trim(contacto) == "") {
        toastr.error("No ha ingresado contacto", "Aviso!");
        $('#update_contacto').focus();
        return false;
    }
    if (regex.test(limite)) {
        UpdateDetail();
    } else {
        toastr.error("Límite de crédito inválido", "Aviso!");
        $('#update_limite').focus();
        return false;
    }
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