function readRecords() {
    $.get("action/readcatSucursal.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var nombre = $("#nombre").val();
    var direccion = $("#direccion").val();
    var pais = $("#pais").val();
    var depto = $("#depto").val();
    var muni = $("#muni").val();

    $.post("action/addcatSucursal.php", {
        nombre: nombre,
        direccion: direccion,
        pais: pais,
        depto: depto,
        muni: muni
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#direccion").val("");
    });
}

function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockcatSucursal.php", {
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
        $.post("action/lockcatSucursal.php", {
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
    $.post("action/readcatSucursaldata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            var iddepto = dato.idindepto;
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
            $("#update_pais").val(dato.idinpais);
            $("#update_depto").val(dato.idindepto);

        }
        );
    $("#update_modal").modal("show");
}

function UpdateDetail() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var pais = $("#update_pais").val();
    var depto = $("#update_depto").val();
    var muni = $("#update_muni").val();
    var id = $("#hidden_id").val();

    $.post("action/updatecatSucursal.php", {
        id: id,
        nombre: nombre,
        direccion: direccion,
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
    var muni = $("#muni").val();
    
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
    if ($.trim(muni) == "") {
        toastr.error("No ha seleccionado un municipio", "Aviso!");
        $('#muni').focus();
        return false;
    }
    addRecord();
}

function updateValida() {
    var nombre = $("#update_nombre").val();
    var direccion = $("#update_direccion").val();
    var muni = $("#update_muni").val();
    
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
