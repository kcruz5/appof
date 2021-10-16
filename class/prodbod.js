function cargaProducto() {
    var id = $("#cbbod").val();
    $.post("action/readprodbod.php", {
        id: id
    },
        function (data, status) {
            $("#records_content").html(data);
        }
        );
}

function addRecord() {
    var bodega = $("#cbbod").val(),
        producto = $("#producto").val();

    $.post("action/addprodbod.php", {
        bodega: bodega,
        producto: producto
    }, function (data, status) {
        $("#add_modal").modal("hide");
        cargaProducto();
    });
}
function Unlock(id) {
    var bodega = $("#cbbod").val(); 
    
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockprodbod.php", {
            id: id,
            bodega: bodega
        },
            function (data, status) {
                cargaProducto();
            }
            );
    }
}

function Lock(id) {
    var bodega = $("#cbbod").val();
    
    var conf = confirm("¿Está seguro, realmente desea desactivar el registro seleccionado?");
    if (conf == true) {
        $.post("action/lockprodbod.php", {
            id: id,
            bodega: bodega
        },
            function (data, status) {
                cargaProducto();
            }
            );
    }
}
$(document).ready(function () {
    cargaProducto(); // Lee registros
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