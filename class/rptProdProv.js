function reporte() {
    var producto = $("#producto").val(),
        proveedor = $("#proveedor").val();
    
    $.post("action/rptProdProv.php", {
        producto: producto,
        proveedor: proveedor
    },
        function (data, status) {
         $("#titulo").show();
            $("#records_content").html(data);
        }
        );
}

$(document).ready(function () {
 $("#titulo").hide();
});