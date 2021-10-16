<?php
include("keyaction.php");

if(isset($_POST))
{
    session_start();
    $id = $_POST['id'];
	$nombre= $_POST['nombre'];
	$puesto= $_POST['puesto'];

    $query = "UPDATE in_empleado SET nombre='$nombre', puesto='$puesto' WHERE idinempleado = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantempleado','U','".$_SESSION["nombre"]."','SET ".$nombre.",".$puesto."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>