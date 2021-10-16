function readRecords() {
    $.get("action/readmantproveedor.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var correo = $("#correo").val();

    $.post("action/addmantproveedor.php", {
        nombre: nombre,
        direccion: direccion,
        telefono: telefono,
        correo: correo
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#direccion").val("");
        $("#telefono").val("");
        $("#correo").val("");
    });
}

function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockmantproveedor.php", {
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
        $.post("action/lockmantproveedor.php", {
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
    $.post("action/readmantproveedordata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
            $("#update_direccion").val(dato.direccion);
            $("#update_telefono").val(dato.telefono);
            $("#update_correo").val(dato.correo);
        }
        );
                // Open modal popup
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var telefono = $("#update_telefono").val();
    var correo = $("#update_correo").val();
    var id = $("#hidden_id").val();

    $.post("action/updatemantproveedor.php", {
        id: id,
        nombre: nombre,
        direccion: direccion,
        telefono: telefono,
        correo: correo
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
    var correo = $("#correo").val();
    var regex= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
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

     if ($.trim(correo) == "") {
        toastr.error("No ha ingresado correo", "Aviso!");
        $('#correo').focus();
        return false;
    }
    if (regex.test(correo))
      {
          addRecord();
      } else {
        toastr.error("Correo Inválido", "Aviso!");
        $('#correo').focus();
        return false;
      } 
}


function updateValida() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var telefono = $("#update_telefono").val();
    var correo = $("#update_correo").val();
    var regex= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
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

     if ($.trim(correo) == "") {
        toastr.error("No ha ingresado correo", "Aviso!");
        $('#update_correo').focus();
        return false;
    }
    if (regex.test(correo))
      {
            UpdateDetail();
      } else {
        toastr.error("Correo Inválido", "Aviso!");
        $('#update_correo').focus();
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