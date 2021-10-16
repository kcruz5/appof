var idGen = 0,
    total = 0,
    totdesc = 0;

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
function readRecords() {
    total = 0;
    
    if ($("#tipOC").val() == "1") {
        $("#descuento").show();
    }
    
    $.ajax({
        url: 'action/ingOCread.php',
        method: 'POST',
        data: {bodega: $("#bodega").val(),
              tipo: $("#tipOC").val()}
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
                },
               // "Existencia": {
                 //   "type": "int"
                //},
            },
            data: $.parseJSON(data),
            direction: "desc",
            debug: true
        });     // Render the table
        t.render();
        hideCol();
        $("#nuevo").hide();
        $("#crea").show();
        $('#bodega').prop('disabled', 'disabled');
        $('#tipOC').prop('disabled', 'disabled');
        $('#cliente').prop('disabled', 'disabled');
        $("#descuento").val("");
    });
}
function storeTblValues() {
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
            
            total = total + parseFloat($(tr).find('td:eq(7)').text());
            
            TableData += "(" + $("#bodega").val() + "," + $(tr).find('td:eq(0)').text() + "," + $(tr).find('td:eq(1)').text() + ",'" + $(tr).find('td:eq(3)').text() + "','" + $(tr).find('td:eq(2)').text() + "'," + cantidad + ",'" + $(tr).find('td:eq(5)').text() + "'," +  $(tr).find('td:eq(6)').text() + ",'" + $(tr).find('td:eq(8)').text() + "')";
        }
    });
    return TableData;
}
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
function saveRecords() {
    var TableData = storeTblValues(),
        bodega = $("#bodega").val(),
        tipo = $("#tipOC").val(),
        cliente = $("#cliente").val(),
        descto = $("#descto").val(),
        tot = "";
    
    if (descto == "") {
        totdesc = total;
        descto = 0;
        tot = "<h1> Total a pagar: Q. " + totdesc + "</h1>";
    } else {
        totdesc = total - descto;
        tot = "<h1> Total a pagar: Q. " + totdesc + "</h1>";
    }
  
    $.post("action/ingOCSave.php", {
        bodega: bodega,
        tipo: tipo,
        TableData: TableData,
        total: total,
        cliente: cliente,
        descto: descto
    }, function (data, status) {
        toastr.success("Se creo la orden de compra No." + data + " Monto total: Q." + totdesc, "Aviso!");
        idGen = parseInt(data);
        $("#total").html(tot);
        $("#crea").hide();
        $("#confirm").show();
        $("#exit").show();
        return true;
    });
}
function ConfirmRecords() {
    var TableData = updateTblValues(),
        id = idGen,
        bodega = $("#bodega").val(),
        descto = $("#descto").val(),
        tot = "";
    
    if (descto == "") {
        totdesc = total;
        descto = 0;
        tot = "<h1> Total a pagar: Q. " + totdesc + "</h1>";
    } else {
        totdesc = total - descto;
        tot = "<h1> Total a pagar: Q. " + totdesc + "</h1>";
    }
  
    $.post("action/ingOCUpdate.php", {
        id: id,
        TableData: TableData,
        bodega: bodega,
        total: total,
        descto: descto
    }, function (data, status) {
        toastr.success("Se actualizó la orden de compra No." + data + " Monto total: Q." + totdesc, "Aviso!");
        $("#crea").hide();
        $("#confirm").hide();
        $("#nuevo").hide();
        $("#abono").show();
        $("#exit").show();
        $("#total").html(tot);
        $("#totalabono").html("<h5> Total a pagar: Q. " + totdesc + "</h5>");
        return true;
    });
}
function payoc() {
    var id = idGen,
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
        $("#abono_modal").modal("hide");        
        $("#crea").hide();
        $("#confirm").hide();
        $("#nuevo").hide();
        $("#abono").show();
        $("#exit").show();
        $("#banco").val("");
        $("#numero").val("");
        $("#monto").val("");
        $("#nota").val("");
        $("#descuento").hide();
        $("#descuento").val("");
        total = 0;
        totdesc = 0;
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
        if (monto > totdesc) {
            toastr.error("El monto es mayor al total de la OC", "Aviso!");
            $('#monto').focus();
            return false;
        }
        
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
function Abono() {
    $("#abono_modal").modal("show");
}
function exit() {
    var  tot = "";
    total = 0;
    totdesc=0;
    $("#crea").hide();
    $("#confirm").hide();
    $("#abono").hide();
    $("#exit").hide();
    $("#nuevo").show();
    $("#data tr").remove();
    $('#bodega').prop('disabled', false);
    $('#tipOC').prop('disabled', false);
    $('#cliente').prop('disabled', false);
    $("#total").html(tot);
    $("#descuento").hide();
    $("#descuento").val("");
    return true;
}
$(document).ready(function () {
    $("#crea").hide();
    $("#confirm").hide();
    $("#abono").hide();
    $("#exit").hide();
    $("#descuento").hide();
});
