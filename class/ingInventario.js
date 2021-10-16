var idGen = 0;

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
    $.ajax({
        url: 'action/ingbodegaread.php',
        method: 'POST',
        data: {bodega: $("#bodega").val()}
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
        $("#nuevo").hide();
        $("#crea").show();
        $('#bodega').prop('disabled', 'disabled');
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
            TableData += "(" + $("#bodega").val() + "," + $(tr).find('td:eq(0)').text() + "," + $(tr).find('td:eq(1)').text() + ",'" + $(tr).find('td:eq(3)').text() + "','" + $(tr).find('td:eq(2)').text() + "'," + cantidad + ",'" + $(tr).find('td:eq(5)').text() + "')";
        }   
    });
    return TableData;
}
function updateTblValues() {
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
            TableData += "(" + idGen + "," + $("#bodega").val() + "," + $(tr).find('td:eq(0)').text() + "," + cantidad + ")";
        }   
    });
    return TableData;
}
function saveRecords() {
    var TableData = storeTblValues(),
        bodega = $("#bodega").val();

    $.post("action/ingInventarioSave.php", {
        bodega: bodega,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se guardó el inventario No."+ data, "Aviso!");
        idGen = parseInt(data);
        $("#crea").hide();
        $("#confirm").show();
        return true;
    });
}

function ConfirmRecords() {
    var TableData = updateTblValues(),
        id = idGen;

    $.post("action/ingInventarioUpdate.php", {
        id: id,
        TableData: TableData
    }, function (data, status) {
        toastr.success("Se actualizó el inventario No. "+ data, "Aviso!");
        $("#crea").hide();
        $("#confirm").hide();
        $("#nuevo").show();
        $("#data tr").remove(); 
        $('#bodega').prop('disabled', false);
        return true;
    });
}
$(document).ready(function () {
    $("#crea").hide();
    $("#confirm").hide();
});
