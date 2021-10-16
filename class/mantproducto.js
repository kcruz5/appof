function readRecords() {
    $.get("action/readmantproducto.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}
function addRecord() {
    var nombre = $("#nombre").val(),
        proveedor = $("#proveedor").val(),
        categoria= $("#categoria").val(),
        um = $("#um").val(),
        precompra = $("#precompra").val(),
        preventa = $("#preventa").val(),
        presp1 = $("#presp1").val(),
        presp2 = $("#presp2").val(),
        presp3 = $("#presp3").val();

    $.post("action/addmantproducto.php", {
        nombre: nombre,
        proveedor: proveedor,
        categoria: categoria,
        um: um,
        precompra: precompra,
        preventa: preventa,
        presp1: presp1,
        presp2: presp2,
        presp3: presp3
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#nombre").val("");
        $("#um").val("");
        $("#precompra").val("");
        $("#preventa").val("");
        $("#presp1").val("");
        $("#presp2").val("");
        $("#presp3").val("");
    });
}
function Unlock(id) {
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockmantproducto.php", {
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
        $.post("action/lockmantproducto.php", {
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
    $.post("action/readmantproductodata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_nombre").val(dato.nombre);
            $("#update_proveedor").val(dato.proveedor);
            $("#update_categoria").val(dato.categoria);
        }
        );
    $("#update_modal").modal("show");
}
function UpdateDetail() {
    var nombre = $("#update_nombre").val(),
        proveedor = $("#update_proveedor").val(),
        categoria = $("#update_categoria").val(),
        id = $("#hidden_id").val();

    $.post("action/updatemantproducto.php", {
        id: id,
        nombre: nombre,
        proveedor: proveedor,
        categoria: categoria
    },
        function (data, status) {
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}
function UpdatePrice(id){
    $("#hidden_id").val(id);
    $.post("action/readmantproductoprecio.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_precompra").val(dato.precompra);
            $("#update_preventa").val(dato.preventa);
            $("#update_presp1").val(dato.presp1);
            $("#update_presp2").val(dato.presp2);
            $("#update_presp3").val(dato.presp3);
        }
        );
    $("#precio_modal").modal("show");
}
function UpdateDetailPrice(){
    var precompra = $("#update_precompra").val(),
        preventa = $("#update_preventa").val(),
        presp1 = $("#update_presp1").val(),
        presp2 = $("#update_presp2").val(),
        presp3 = $("#update_presp3").val(),
        id = $("#hidden_id").val();
    
    $.post("action/updatemantproductoprecio.php", {
        id: id,
        precompra: precompra,
        preventa: preventa,
        presp1: presp1,
        presp2: presp2,
        presp3: presp3
    },
        function (data, status) {
            $("#precio_modal").modal("hide");
            $("#update_presp1").val("");
            $("#update_presp2").val("");
            $("#update_presp3").val("");
            readRecords();
        }
        );    
}
function UpdateUnit(id){
    $("#hidden_id").val(id);
    $.post("action/readmantproductoum.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_um").val(dato.um);
        }
        );
    $("#um_modal").modal("show");    
}
function UpdateDetailUnit(){
    var um = $("#update_um").val(),
        id = $("#hidden_id").val();
    
    $.post("action/updatemantproductoum.php", {
        id: id,
        um: um
    },
        function (data, status) {
            $("#um_modal").modal("hide");
            readRecords();
        }
        );    
}
function validaCampos() {
    var nombre = $("#nombre").val(),
        um = $("#um").val(),
        preventa = $("#preventa").val(),
        precompra = $("#precompra").val(),
        presp1 = $("#presp1").val(),
        presp2 = $("#presp2").val(),
        presp3 = $("#presp3").val(),
        regex = /^(\d{1,7})(?:.\d{1,2})?$/;
    
    if ($.trim(nombre) == "") {
        toastr.error("No ha ingresado nombre", "Aviso!");
        $('#nombre').focus();
        return false;
    }
    if ($.trim(um) == "") {
        toastr.error("No ha ingresado unidad de medida", "Aviso!");
        $('#um').focus();
        return false;
    }
    
    if ($.trim(precompra) == "") {
        toastr.error("No ha ingresado precio compra", "Aviso!");
        $('#precompra').focus();
        return false;
    }
    
    if ($.trim(preventa) == "") {
        toastr.error("No ha ingresado precio venta", "Aviso!");
        $('#preventa').focus();
        return false;
    } 
    
    if ($.trim(presp1) == "") {
        presp1=0.00;
    } 
    
    if ($.trim(presp2) == "") {
        presp2=0.00;
    } 
    
    if ($.trim(presp3) == "") {
        presp3=0.00;
    } 

    if (regex.test(precompra)) {
        if (regex.test(preventa)) {
            if (regex.test(presp1)) {
                if (regex.test(presp2)) {
                    if (regex.test(presp3)) {
                        addRecord();
                    } else {
                        toastr.error("Precio de Especial 3 inválido", "Aviso!");
                        $('#presp3').focus();
                        return false;
                    }
                } else {
                    toastr.error("Precio de Especial 2 inválido", "Aviso!");
                    $('#presp2').focus();
                    return false;
                }
            } else {
                toastr.error("Precio de Especial 1 inválido", "Aviso!");
                $('#presp1').focus();
                return false;
            }
        } else {
            toastr.error("Precio de Venta inválido", "Aviso!");
            $('#preventa').focus();
            return false;
        }
    } else {
        toastr.error("Precio de Compra inválido", "Aviso!");
        $('#precompra').focus();
        return false;
    }
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
function validaPrecio() {
    var preventa = $("#update_preventa").val(),
        precompra = $("#update_precompra").val(),
        presp1 = $("#update_presp1").val(),
        presp2 = $("#update_presp2").val(),
        presp3 = $("#update_presp3").val(),
        regex = /^(\d{1,7})(?:.\d{1,2})?$/;

    if ($.trim(precompra) == "") {
        toastr.error("No ha ingresado precio compra", "Aviso!");
        $('#update_precompra').focus();
        return false;
    }
    
    if ($.trim(preventa) == "") {
        toastr.error("No ha ingresado precio venta", "Aviso!");
        $('#update_preventa').focus();
        return false;
    }     
    
   if ($.trim(presp1) == "") {
        presp1=0.00;
    } 
    
    if ($.trim(presp2) == "") {
        presp2=0.00;
    } 
    
    if ($.trim(presp3) == "") {
        presp3=0.00;
    } 

    if (regex.test(precompra)) {
        
        if (regex.test(preventa)) {
            if (regex.test(presp1)) {
                if (regex.test(presp2)) {
                    if (regex.test(presp3)) {
                        UpdateDetailPrice();
                    } else {
                        toastr.error("Precio de Especial 3 inválido", "Aviso!");
                        $('#update_presp3').focus();
                        return false;
                    }
                } else {
                    toastr.error("Precio de Especial 2 inválido", "Aviso!");
                    $('#update_presp2').focus();
                    return false;
                }
            } else {
                toastr.error("Precio de Especial 1 inválido", "Aviso!");
                $('#update_presp1').focus();
                return false;
            }
        } else {
            toastr.error("Precio de Venta inválido", "Aviso!");
            $('#update_preventa').focus();
            return false;
        }
    } else {
        toastr.error("Precio de Compra inválido", "Aviso!");
        $('#update_precompra').focus();
        return false;
    }
}
function validaUM() {
    var preventa = $("#update_um").val();

    if ($.trim(um) == "") {
        toastr.error("No ha ingresado unidad de medida", "Aviso!");
        $('#update_um').focus();
        return false;
    }    
    UpdateDetailUnit();
}
function UpdateBod(id) {
    $("#hidden_id").val(id);
    $("#bodega_modal").modal("show");
}
function UpdateBodega() {
    var bodega = $("#update_bodega").val(),
        id = $("#hidden_id").val();

    $.post("action/updatemantusuariobodega.php", {
        id: id,
        bodega: bodega
    },
        function (data, status) {
            $("#bodega_modal").modal("hide");
            readRecords();
        }
        );
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