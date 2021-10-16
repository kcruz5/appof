<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$descripcion=$_POST['descripcion'];
	$tipo=$_POST['tipo'];

    $query = "UPDATE in_tipo_mov SET descripcion='$descripcion', tipo='$tipo' WHERE idinTipoMov = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoEs','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));        
    }
}
?>