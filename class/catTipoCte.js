function readRecords() {
    $.get("action/readcatTipoCte.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}

function addRecord() {
    var descripcion = $("#descripcion").val();

    $.post("action/addcatTipoCte.php", {
        descripcion: descripcion
    }, function (data, status) {
        $("#add_modal").modal("hide");
        readRecords();
        $("#descripcion").val("");
    });
}

function Unlock(id) {
    
    var conf = confirm("¿Está seguro, realmente desea activar el registro seleccionado?");
    if (conf == true) {
        $.post("action/unlockcatTipoCte.php", {
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
        $.post("action/lockcatTipoCte.php", {
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
    $.post("action/readcatTipoCtedata.php", {
        id: id
    },
        function (data, status) {
            var dato = JSON.parse(data);
            $("#update_descripcion").val(dato.descripcion);
        }
        );

    $("#update_modal").modal("show");
}
function UpdateDetail() {
    var descripcion = $("#update_descripcion").val();
    var id = $("#hidden_id").val();
    
    $.post("action/updatecatTipoCte.php", {
        id: id,
        descripcion: descripcion
    },
        function (data, status) {
            // hide modal popup
            $("#update_modal").modal("hide");
            readRecords();
        }
        );
}

function validaCampos() {
    var descripcion = $("#descripcion").val();

    if ($.trim(descripcion) == "") {
        toastr.error("No ha ingresado descripcion", "Aviso!");
        $('#descripcion').focus();
        return false;
    }
    addRecord();
}

function updateValida() {
    var descripcion = $("#update_descripcion").val();

    if ($.trim(descripcion) == "") {
        toastr.error("No ha ingresado descripcion", "Aviso!");
        $('#update_descripcion').focus();
        return false;
    }
    UpdateDetail();
}

$(document).ready(function () {
    readRecords(); // Lee registros
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