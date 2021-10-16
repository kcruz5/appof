function reporte() {
    var fecha = $("#mes").val(),
        bodega = $("#bodega").val();
    
    if (fecha ==""){
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

        today = yyyy +mm + dd;
        fecha= today;
    }else {
        var lastday = function(y,m){
            return  new Date(y, m +1, 0).getDate();
        },
        y= fecha.substring(3, 7),
        m= fecha.substring(0, 2) - 1;
        fecha = y+fecha.substring(0, 2)+lastday(y,m);
    }
    
    
    $.post("action/rptMov.php", {
        fecha: fecha,
        bodega: bodega
        
    },
        function (data, status) {
            $("#records_content").html(data);
        }
        );
}

$(document).ready(function () {

});