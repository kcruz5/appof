<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    if ($correo == "") {
        $correo="";
    }

    $query = "UPDATE in_proveedor SET nombre='$nombre', direccion='$direccion', telefono='$telefono', correo='$correo' WHERE idinProveedor = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantproveedor','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>