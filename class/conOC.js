var idGen = 0,
    total = 0,
    bodega = 0,
    idEst = 1,
    fechagen = "",
    descuento = 0.00;

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
        descto: descuento
    }, function (data, status) {
        toastr.success("Se actualizó la orden de compra No." + data + " Monto total: Q." + total, "Aviso!");
        $("#confirm").hide();
        $("#exit").hide();
        $("#data tr").remove();
        readRecords(fechagen);
        return true;
    });
}
function exit() {
    total = 0;
    $("#confirm").hide();
    $("#exit").hide();
    $("#descto").hide();
    $("#total").hide();
    $("#descto").val("");
    $("#total").val("0.00");
    $("#data tr").remove();
    return true;
}
function Abono(id) {
    $("#hidden_id").val(id);
    
    $.post("action/getSaldo.php", {
        oc: id
    },
        function (data, status) {
            $("#saldo").html(data);
        }
        );

    $("#abono_modal").modal("show");
}
function readRecords(fecha) {
    $.post("action/readconOC.php", {
        fecha: fecha
        
    },
        function (data, status) {
            $("#records_content").html(data);
        }
        );
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
        readRecords(fechagen);
        $("#tipopago").val("");
        $("#banco").val("");
        $("#numero").val("");
        $("#nota").val("");
        $("#abono_modal").modal("hide");
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
function detail(id, bod, estado,descto) {
    total = 0;
    bodega = bod;
    idGen = id;
    idEst = estado;
    var   totdesc;
    
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
        
        $('#data tr').each(function (row, tr) {
            if (row != 0) {   
                total = total + parseFloat($(tr).find('td:eq(7)').text());
            }
        });
           totdesc = total - descto;                      
        $("#exit").show();
        $("#descto").val(descto);
        $("#total").html(   "<h5> Total: Q. " + totdesc + "</h5>");
        $("#descto").show();
        $("#total").show();
        if (idEst < 4) {
            $("#confirm").show();
        }
    });

}
function reporte() {
    var fecha = $("#mes").val(),
        bodega = $("#bodega").val();
    
    if (fecha == "") {
        var today = new Date(),
            dd = today.getDate(),
            mm = today.getMonth() + 1,
            yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        today = yyyy + mm + dd;
        fecha = today;
    } else {
        var lastday = function (y, m) {
            return new Date(y, m + 1, 0).getDate();
        },
            y = fecha.substring(3, 7),
            m = fecha.substring(0, 2) - 1;
        fecha = y + fecha.substring(0, 2) + lastday(y, m);
    }
    fechagen = fecha;
    readRecords(fecha);
}
$(document).ready(function () {
    $("#confirm").hide();
    $("#descto").hide();
    $("#exit").hide();
});