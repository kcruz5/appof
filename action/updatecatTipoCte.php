<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$descripcion=$_POST['descripcion'];

    $query = "UPDATE in_tipo_cte SET descripcion='$descripcion'  WHERE idinTipoCte = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoCte','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>