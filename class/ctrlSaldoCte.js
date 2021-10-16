function readRecords() {
    $.get("action/readctrlSaldoCte.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
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