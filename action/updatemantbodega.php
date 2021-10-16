<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$encargado = $_POST['encargado'];    
	$telefono = $_POST['telefono'];
	$correo = $_POST['correo'];
	$pais = $_POST['pais'];
	$depto = $_POST['depto'];
    $muni = $_POST['muni'];
    
    $query = "UPDATE in_bodega SET nombre='$nombre', direccion='$direccion', telefono='$telefono', encargado='$encargado', correo='$correo', idinPais='$pais', idinDepto='$depto', idinMunicipio='$muni ' WHERE idinBodega = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantbodega','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>