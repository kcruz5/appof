var idGen = 0,
    total = 0,
    bodega = 0,
    idEst = 1;

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
    $("#exit").hide();
    $("#confirm").hide();
    $("#data tr").remove();
    return true;
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
function ConfirmRecords() {
    var TableData = updateTblValuesDe(),
        id = idGen;

    $.post("action/ingDesperdicioUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó la salida por desperdicio No." + data, "Aviso!");
        $("#confirm").hide();
        $("#exit").hide();
        $("#data tr").remove();
        $("#titulo").html('');
        return true;
    });
}
function readRecords(fecha) {
    $.post("action/readconDesp.php", {
        fecha: fecha
        
    },
        function (data, status) {
            $("#records_content").html(data);
        }
        );
}
function detail(id, bod, estado) {
    bodega = bod;
    idGen = id;
    idEst = estado;
    
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
        $("#exit").show();
    });
    if (idEst == 1) {
        $("#confirm").show();
    }

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
    readRecords(fecha);
}
$(document).ready(function () {
    //readRecords(); // Lee registros
    $("#confirm").hide();
    $("#exit").hide();
});