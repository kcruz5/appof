<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$descripcion=$_POST['descripcion'];
	$precio=$_POST['precio'];

    $query = "UPDATE in_tipo_oc SET descripcion='$descripcion', precio_sn='$precio' WHERE idinTipoOC = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoOC','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>