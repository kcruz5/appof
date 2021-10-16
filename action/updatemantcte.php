<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$contacto = $_POST['contacto'];
	$tipo = $_POST['tipo'];
	$limite = $_POST['limite'];
    
    $query = "UPDATE in_cliente SET nombre='$nombre', direccion='$direccion', telefono='$telefono', contacto='$contacto', idintipocte='$tipo', credito='$limite ' WHERE idinCte = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantcte','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>