var idGen = 0,
    total = 0,
    bodega = 0,
    descto = 0,
    idEst = 1;

function readRecords() {
    $.get("action/readnotifica.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}
function hideCol() {
    var tbl = document.getElementById("data"),
        i = 0,
        j = 0;
    if (tbl != null) {
        for (i = 0; i < tbl.rows.length; i++) {
            for (j = 0; j < tbl.rows[i].cells.length; j++) {
                        
                if (j == 0) {
                    tbl.rows[i].cells[j].style.display = "none";
                }
                if (j == 1) {
                    tbl.rows[i].cells[j].style.display = "none";
                }
            }
        }
    }
}
function exit() {
    total = 0;
    idEst = 1;
    $("#confirm").hide();
    $("#confirmIn").hide();
    $("#confirmEb").hide();
    $("#confirmTr").hide();
    $("#confirmDe").hide();
    $("#confirmAj").hide();
    $("#exit").hide();
    $("#data tr").remove();
    $("#titulo").html('');
    return true;
}

//OC
function updateTblValues() {
    var TableData = "",
        cantidad = 0;
    
    total = 0;
    
    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            
            total = total + parseFloat($(tr).find('td:eq(7)').text());
            TableData += "(" + idGen + "," + cantidad + "," + $(tr).find('td:eq(0)').text() + ",'" + $(tr).find('td:eq(8)').text() + "')";
        }
    });
    return TableData;
}
function ConfirmRecords() {
    var TableData = updateTblValues(),
        id = idGen,
        tot = "<h5> Total: Q. " + total + "</h5>";

    $.post("action/ingOCUpdate.php", {
        id: id,
        TableData: TableData,
        bodega: bodega,
        total: total,
        descto: descto
    }, function (data, status) {
        toastr.success("Se actualizó la orden de compra No." + data + " Monto total: Q." + total, "Aviso!");
        $("#confirm").hide();
        $("#exit").hide();
        $("#titulo").html('');
        $("#data tr").remove();
        readRecords();
        return true;
    });
}
function detail(id, bod, estado, desct) {
    total = 0;
    bodega = bod;
    idGen = id;
    idEst = estado;
    descto = desct;
    $("#titulo").html('Orden de Compra No:' + idGen);
    $.ajax({
        url: 'action/readdetalleOC.php',
        method: 'POST',
        data: {id: id}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad  <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                },
                "Precio": {
                    "type": "money"
                },
                "Total": {
                    "type": "calc",
                    "class": "money",
                    "formula": [{ "multiply": [{ "c": -3 }, {"c": -1  }] }]
                },
                "Nota  <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "desc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#exit").show();
        if (idEst < 3) {
            $("#confirm").show();
        }
    });

}
function Autoriza(id) {
    var conf = confirm("¿Está seguro, realmente desea autorizar la OC seleccionada?");
    if (conf == true) {
        $.post("action/autorizanotifica.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function payoc() {
    var id = $("#hidden_id").val(),
        tipo = $("#tipopago").val(),
        banco = $("#banco").val(),
        notran = $("#numero").val(),
        monto =  $("#monto").val(),
        nota = $("#nota").val(),
        empleado = $("#empleado option:selected").text();

    $.post("action/ingOCAbono.php", {
        id: id,
        tipo: tipo,
        banco: banco,
        notran: notran,
        monto: monto,
        empleado: empleado,
        nota: nota
    }, function (data, status) {
        toastr.info(data, "Aviso!");
        readRecords();
        $("#abono_modal").modal("hide");
        $("#banco").val("");
        $("#numero").val("");
        $("#monto").val("");
        $("#nota").val("");
        return true;
    });
}
function pay() {
    var monto = $("#monto").val(),
        tipo =  $("#tipopago").val(),
        banco = $("#banco").val(),
        numero =  $("#numero").val(),
        regex = /^(\d{1,7})(?:.\d{1,2})?$/;
    
    if (regex.test(monto)) {
        if (tipo != 1) {
            if ($.trim(banco) == "") {
                toastr.error("No ha ingresado banco", "Aviso!");
                $('#banco').focus();
                return false;
            }
            
            if ($.trim(numero) == "") {
                toastr.error("No ha ingresado numero de cheque o depósito", "Aviso!");
                $('#numero').focus();
                return false;
            }
        }
        payoc();
    } else {
        toastr.error("Debe ingresar un monto válido", "Aviso!");
        $('#monto').focus();
        return false;
    }
}
function Abono(id) {
    $("#hidden_id").val(id);
    
    $.post("action/getSaldo.php", {
        oc: id
    },
        function (data, status) {
            $("#saldo").html(data);
        });
    $("#abono_modal").modal("show");
}
function AnulaOC(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar la OC seleccionada?");
    if (conf == true) {
        $.post("action/anulaOC.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}

//Inventario
function AnulaIn(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar el inventario seleccionado?");
    if (conf == true) {
        $.post("action/anulaIn.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function updateTblValuesIn() {
    var TableData = "",
        cantidad = 0;

    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            TableData += "(" + idGen + "," + bodega + "," + $(tr).find('td:eq(0)').text() + "," + cantidad + ")";
        }   
    });
    return TableData;
}
function ConfirmRecordsIn() {
    var TableData = updateTblValuesIn(),
        id = idGen;

    $.post("action/ingInventarioUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó el inventario No. "+ data, "Aviso!");
        $("#confirmIn").hide();
        $("#exit").hide();
        $("#data tr").remove(); 
             $("#titulo").html('')
        return true;
    });
}  
function detailIn(id, bod, estado) {
bodega=bod;
idGen = id;
idEst= estado;
       $("#titulo").html('Inventario No:'+ idGen) 
  $.ajax({
        url: 'action/readdetalleIn.php',
        method: 'POST',
        data: {id: idGen}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "asc",
            debug: true
        });
        t.render();
        hideCol();
        $("#exit").show();
    });
      if (idEst == 1) {
          $("#confirmIn").show();
      }        

}
function AutorizaIn(id) {
    var conf = confirm("¿Está seguro, realmente desea autorizar el inventario seleccionado?");
    if (conf == true) {
        $.post("action/autorizaIn.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}

//Entrada
function AnulaEb(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar la entrada a bodega seleccionada?");
    if (conf == true) {
        $.post("action/anulaEb.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function detailEb(id, bod,estado) {
bodega=bod;
idGen = id;
        $("#titulo").html('Entrada a bodega No:'+ idGen) 
    $.ajax({
        url: 'action/readdetalleEb.php',
        method: 'POST',
        data: {id: idGen}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "asc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#confirmEb").show();
        $("#exit").show();
    });
}
function updateTblValuesEb() {
    var TableData = "",
        cantidad = 0;

    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            TableData += "(" + idGen + "," + bodega + "," + $(tr).find('td:eq(0)').text() + "," + cantidad + ")";
        }   
    });
    return TableData;
}
function ConfirmRecordsEb() {
    var TableData = updateTblValuesEb(),
        id = idGen;

    $.post("action/ingBodegaUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó la entrada a bodega No."+ data, "Aviso!");
        $("#confirmEb").hide();
        $("#exit").hide();
        $("#data tr").remove(); 
        $("#titulo").html('')
        return true;
    });
}
function AutorizaEb(id,bod) {
    var conf = confirm("¿Está seguro, realmente desea autorizar la entrada a bodega seleccionada?");
    if (conf == true) {
        $.post("action/autorizaEb.php", {
            id: id
        },
            function (data, status) {
                creaMovimientoEb(id,bod)
            }
            );
    }
}
function creaMovimientoEb(id, bod){
       var idEb = id,
        bodega =bod;

    $.post("action/ingBodegaMov.php", {
        bodega: bodega,
        id: idEb
    }, function (data, status) {
        toastr.info("Se creo movimiento de inventario No."+ data, "Aviso!");
        $("#confirmEb").hide();
        $("#data tr").remove(); 
        readRecords();
        return true;
    }); 
}

//Traslado
function AnulaTr(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar el traslado entre bodegas seleccionado?");
    if (conf == true) {
        $.post("action/anulaTr.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function detailTr(id, bod,estado) {
bodega=bod;
idGen = id;
        $("#titulo").html('Traslado entre bodega No:'+ idGen)     
    $.ajax({
        url: 'action/readdetalleTr.php',
        method: 'POST',
        data: {id: idGen}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "asc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#confirmTr").show();
        $("#exit").show();       
    });
}
function updateTblValuesTr() {
    var TableData = "",
        cantidad = 0;

    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            TableData += "(" + idGen + "," + bodega + ","  + $(tr).find('td:eq(0)').text() + "," + cantidad + ")";
        }   
    });
    return TableData;
}
function creaMovimientoTr(id, bod){
       var 
        idEb = id,
        bodega =bod;

    $.post("action/ingTrasladoMov.php", {
         bodega: bodega,
        id: idEb
    }, function (data, status) {
        toastr.success("Se creo movimiento de inventario de Entrada No. "+ data, "Aviso!");
        $("#confirmTr").hide();
        $("#data tr").remove(); 
        readRecords();
        return true;
    }); 
}
function ConfirmRecordsTr() {
    var TableData = updateTblValuesTr(),
        id = idGen;

    $.post("action/ingTrasladoUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó el traslado entre bodegas No."+ data, "Aviso!");
        $("#confirmTr").hide();
        $("#exit").hide();
        $("#data tr").remove(); 
        $("#titulo").html('')
        return true;
    });
}
function AutorizaTr(id,bod) {
    var conf = confirm("¿Está seguro, realmente desea autorizar el traslado entre bodegas seleccionado?");
    if (conf == true) {
        $.post("action/autorizaTr.php", {
            id: id
        },
            function (data, status) {
                creaMovimientoTr(id,bod)
            }
            );
    }
}

//Desperdicio
function AnulaDe(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar la salida por desperdicio seleccionada?");
    if (conf == true) {
        $.post("action/anulaDe.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function detailDe(id, bod,estado) {
idGen = id;    
bodega= bod;
     $("#titulo").html('Salida por Desperdicio No:'+ idGen) 
    $.ajax({
        url: 'action/readdetalleDe.php',
        method: 'POST',
        data: {id: idGen}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "asc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#confirmDe").show();
        $("#exit").show();
    });
}
function updateTblValuesDe() {
    var TableData = "",
        cantidad = 0;

    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            TableData += "(" + idGen + "," + bodega + "," + $(tr).find('td:eq(0)').text() + "," + cantidad + ")";
        }   
    });
    return TableData;
}
function creaMovimientoDe(id, bod) {
    var 
        idEb = id,
        bodega =bod;

    $.post("action/ingDesperdicioMov.php", {
        bodega: bodega,
        id: idEb
    }, function (data, status) {
        toastr.success("Se creo movimiento de inventario No." + data, "Aviso!");
        $("#confirmDe").hide();
        $("#data tr").remove(); 
        readRecords();
        return true;
    });
}
function ConfirmRecordsDe() {
    var TableData = updateTblValuesDe(),
        id = idGen;

    $.post("action/ingDesperdicioUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó la salida por desperdicio No."+ data, "Aviso!");
        $("#confirmDe").hide();
        $("#exit").hide();
        $("#data tr").remove(); 
        $("#titulo").html('')
        return true;
    });
}
function AutorizaDe(id,bod) {
    var conf = confirm("¿Está seguro, realmente desea autorizar la salida por desperdicio seleccionada?");
    if (conf == true) {
        $.post("action/autorizaDe.php", {
            id: id
        },
            function (data, status) {
                creaMovimientoDe(id,bod)
            }
            );
    }
}


//Ajuste
function AnulaAj(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar el ajuste de inventario seleccionada?");
    if (conf == true) {
        $.post("action/anulaAj.php", {
            id: id
        },
            function (data, status) {
                toastr.info(data, "Aviso!");
                readRecords();
            }
            );
    }
}
function detailAj(id, bod,estado,tipo) {
idGen = id;    
bodega= bod;
     $("#titulo").html('Ajuste de Inventario No:'+ idGen) 
    $.ajax({
        url: 'action/readdetalleAj.php',
        method: 'POST',
        data: {id: idGen}
    }).done(function (data) {
        var t = new Table({
            id: "data",
            fields: {
                "Codigo": {
                    "type": "int"
                },
                "CategoriaCod": {
                    "type": "int"
                },
                "Categoria": {
                    "type": "string"
                },
                "Producto": {
                    "type": "string"
                },
                "Cantidad <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "int"
                },
                "Unidad": {
                    "type": "string"
                },
                "Nota <i class='far fa-edit'></i>": {
                    "class": "edit",
                    "type": "string"
                }
            },
            data: $.parseJSON(data),
            direction: "asc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#confirmAj").show();
        $("#exit").show();
    });
}
function updateTblValuesAj() {
    var TableData = "",
        cantidad = 0;

    $('#data tr').each(function (row, tr) {
        if (TableData != "") {
            TableData += ",";
        }
        if (row != 0) {
            
            if ($(tr).find('td:eq(4)').text() == "") {
                cantidad = 0;
            } else {
                cantidad = $(tr).find('td:eq(4)').text();
            }
            TableData += "(" + idGen +","+ cantidad + "," + $(tr).find('td:eq(0)').text() +",'" + $(tr).find('td:eq(6)').text() + "')";
        }   
    });
    return TableData;
}
function creaMovimientoAj(id, bod, tipoa) {
    var 
        idEb = id,
        bodega =bod,
        tipo = tipoa;

    $.post("action/ingAjusteMov.php", {
        bodega: bodega,
        id: idEb, 
        tipoa: tipoa
    }, function (data, status) {
        toastr.success("Se creo movimiento de inventario No." + data, "Aviso!");
        $("#confirmAj").hide();
        $("#data tr").remove(); 
        readRecords();
        return true;
    });
}
function ConfirmRecordsAj() {
    var TableData = updateTblValuesAj(),
        id = idGen;

    $.post("action/inAjusteUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó el ajuste de inventario No."+ data, "Aviso!");
        $("#confirmAj").hide();
        $("#exit").hide();
        $("#data tr").remove(); 
        $("#titulo").html('')
        return true;
    });
}
function AutorizaAj(id,bod,tipoa) {
    var conf = confirm("¿Está seguro, realmente desea autorizar el ajuste de inventario seleccionado?");
    if (conf == true) {
        $.post("action/autorizaAj.php", {
            id: id
        },
            function (data, status) {
                creaMovimientoAj(id,bod,tipoa)
            }
            );
    }
}

$(document).ready(function () {
    readRecords(); // Lee registros
    $("#confirm").hide();
    $("#confirmIn").hide();
    $("#confirmEb").hide();    
    $("#confirmTr").hide();
    $("#confirmDe").hide();    
    $("#confirmAj").hide();   
    $("#exit").hide();    
});