<?php
include("keyaction.php");

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $id = $_POST['id'];

    $query = "SELECT idinProd, precio_compra as precompra,precio_venta as preventa, precioEspecial1 as presp1, precioEspecial2 as presp2, precioEspecial3 as presp3  FROM in_producto_precio where idinProd='$id' and fecha_fin IS NULL";
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    $response = array();
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Datos no encontrados!";
    }
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Solicitud inválida!";
}
?>