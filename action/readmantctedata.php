<?php
include("keyaction.php");

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $id = $_POST['id'];
	$query = "select idinCte, nombre, direccion,telefono,contacto,idintipocte as tipo,credito as limite,estado from in_cliente where idinCte= '$id'";

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