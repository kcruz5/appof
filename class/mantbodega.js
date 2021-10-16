function readRecords() {
    $.get("action/readmantbodega.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val(),
        direccion = $("#direccion").val(),
        encargado = $("#encargado").val(),
        telefono = $("#telefono").val(),
        correo = $("#correo").val(),
        pais = $("#pais").val(),
        depto = $("#depto").val(),
        muni = $("#muni").val();

    $.post("action/addmantbodega.php", {
        nombre: nombre,
        direccion: direccion,
        encargado: encargado,
        telefono: telefono,
        correo: correo,
        pais: pais,
        depto: depto,
        muni: muni
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#direccion").val("");
        $("#encargado").val("");
        $("#telefono").val("");
        $("#correo").val("");
    });
}

function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockmantbodega.php", {
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
        $.post("action/lockmantbodega.php", {
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
    $.post("action/readmantbodegadata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            var iddepto = dato.idinDepto;
            $.post("action/muni.php", {
                id: iddepto
            },
                function (datas, status) {
                    $("#update_muni").html(datas);
                    $("#update_muni").val(dato.idinmunicipio);
                }
                );
        
            $("#update_nombre").val(dato.nombre);
            $("#update_direccion").val(dato.direccion);
            $("#update_encargado").val(dato.encargado);
            $("#update_telefono").val(dato.telefono);
            $("#update_correo").val(dato.correo);
            $("#update_pais").val(dato.idinPais);
            $("#update_depto").val(dato.idinDepto);

        }
        );
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var nombre = $("#update_nombre").val(),
        direccion = $("#update_direccion").val(),
        encargado = $("#update_encargado").val(),
        telefono = $("#update_telefono").val(),
        correo = $("#update_correo").val(),
        pais = $("#update_pais").val(),
        depto = $("#update_depto").val(),
        muni = $("#update_muni").val(),
        id = $("#hidden_id").val();

    $.post("action/updatemantbodega.php", {
        id: id,
        nombre: nombre,
        direccion: direccion,
        encargado: encargado,
        telefono: telefono,
        correo: correo,
        pais: pais,
        depto: depto,
        muni: muni
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
    var encargado = $("#encargado").val();
    var telefono = $("#telefono").val();    
    var correo = $("#correo").val();   
    var muni = $("#muni").val();
    var regex= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    if ($.trim(direccion) == "") {
        toastr.error("No ha ingresado direccion", "Aviso!");
        $('#direccion').focus();
        return false;
    }
    if ($.trim(encargado) == "") {
        toastr.error("No ha ingresado encargado", "Aviso!");
        $('#encargado').focus();
        return false;
    }
    if ($.trim(telefono) == "") {
        toastr.error("No ha ingresado telefono", "Aviso!");
        $('#telefono').focus();
        return false;
    }   
     if ($.trim(correo) == "") {
        toastr.error("No ha ingresado correo", "Aviso!");
        $('#correo').focus();
        return false;
    }
    if (!regex.test(correo))
      {
        toastr.error("Correo Inválido", "Aviso!");
        $('#correo').focus();
        return false;
      } 
    if ($.trim(muni) == "") {
        toastr.error("No ha seleccionado un municipio", "Aviso!");
        $('#muni').focus();
        return false;
    }
    addRecord();
}

function updateValida() {
    var nombre = $("#update_nombre").val(),
        direccion = $("#update_direccion").val(),
        encargado = $("#update_encargado").val(),
        telefono = $("#update_telefono").val(),
        correo = $("#update_correo").val(),
        muni = $("#update_muni").val(),
        regex= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    
     if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#update_nombre').focus();
        return false;
    }
    if ($.trim(direccion) == "") {
        toastr.error("No ha ingresado direccion", "Aviso!");
        $('#update_direccion').focus();
        return false;
    }
    if ($.trim(encargado) == "") {
        toastr.error("No ha ingresado encargado", "Aviso!");
        $('#update_encargado').focus();
        return false;
    }
    if ($.trim(telefono) == "") {
        toastr.error("No ha ingresado telefono", "Aviso!");
        $('#update_telefono').focus();
        return false;
    }   
     if ($.trim(correo) == "") {
        toastr.error("No ha ingresado correo", "Aviso!");
        $('#update_correo').focus();
        return false;
    }
    if (!regex.test(correo))
      {
        toastr.error("Correo Inválido", "Aviso!");
        $('#update_correo').focus();
        return false;
      } 
    if ($.trim(muni) == "") {
        toastr.error("No ha seleccionado un municipio", "Aviso!");
        $('#update_muni').focus();
        return false;
    }
    UpdateDetail();
}

function cargaMuni() {
    var id = $("#depto").val();
    $.post("action/muni.php", {
        id: id
    },
        function (data, status) {
            $("#muni").html(data);
        }
        );
}

function cargaMuniUpdate() {
    var id = $("#update_depto").val();
    $.post("action/muni.php", {
        id: id
    },
        function (data, status) {
            $("#update_muni").html(data);
        }
        );
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

