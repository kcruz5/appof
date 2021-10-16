function readRecords() {
    $.get("action/readmantusuario.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}
function addRecord() {
    var nombre = $("#nombre").val(),
        usuario = $("#usuario").val(),
        password = $("#password").val(),
        perfil = $("#perfil").val();

    $.post("action/addmantusuario.php", {
        nombre: nombre,
        usuario: usuario,
        password: password,
        perfil: perfil
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#usuario").val("");
        $("#password").val("");
        $("#confirm").val("");
    });
}
function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockmantusuario.php", {
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
        $.post("action/lockmantusuario.php", {
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
    $.post("action/readmantusuariodata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
            $("#update_usuario").val(dato.usuario);
            $("#update_perfil").val(dato.perfil);
            $("#update_password").val(dato.contrasenia);
            $("#update_confirm").val(dato.contrasenia);
        }
        );
    $("#update_modal").modal("show");
}
function UpdateDetail() {
    var nombre = $("#update_nombre").val(),
        usuario = $("#update_usuario").val(),
        perfil = $("#update_perfil").val(),
        password = $("#update_password").val(),
        id = $("#hidden_id").val();

    $.post("action/updatemantusuario.php", {
        id: id,
        nombre: nombre,
        usuario: usuario,
        perfil: perfil,
        password: password
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}
function validaCampos() {
    var nombre = $("#nombre").val(),
        usuario = $("#usuario").val(),
        password = $("#password").val(),
        confirm = $("#confirm").val();
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    if ($.trim(usuario) == "") {
        toastr.error("No ha ingresado usuario", "Aviso!");
        $('#usuario').focus();
        return false;
    }
    if ($.trim(password) == "") {
        toastr.error("No ha ingresado contrase&#xF1;a", "Aviso!");
        $('#password').focus();
        return false;
    }
    if ($.trim(confirm) == "") {
        toastr.error("No ha ingresado confirmación de contrase&#xF1;a", "Aviso!");
        $('#confirm').focus();
        return false;
    }
    if (password != confirm) {
        toastr.error("Las contrase&#xF1;as no coinciden", "Aviso!");
        $('#confirm').focus();
        return false;
    }
    addRecord();
}
function updateValida() {
    var nombre = $("#update_nombre").val(),
        usuario = $("#update_usuario").val(),
        password = $("#update_password").val(),
        confirm = $("#update_confirm").val();
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#update_nombre').focus();
        return false;
    }
    if ($.trim(usuario) == "") {
        toastr.error("No ha ingresado usuario", "Aviso!");
        $('#update_usuario').focus();
        return false;
    }
    if ($.trim(password) == "") {
        toastr.error("No ha ingresado contrase&#xF1;a", "Aviso!");
        $('#update_password').focus();
        return false;
    }
    if ($.trim(confirm) == "") {
        toastr.error("No ha ingresado confirmación de contrase&#xF1;a", "Aviso!");
        $('#update_confirm').focus();
        return false;
    }
    if (password != confirm) {
        toastr.error("Las contrase&#xF1;as no coinciden", "Aviso!");
        $('#update_confirm').focus();
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