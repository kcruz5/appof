<?php
include("keyaction.php");
        session_start();
if(isset($_POST))
{
    $id = $_POST['id'];
	$nombre=$_POST['nombre'];
	$direccion=$_POST['direccion'];
    $pais = $_POST['pais'];
	$depto=$_POST['depto'];
	$muni=$_POST['muni'];

    $query = "UPDATE in_sucursal SET nombre='$nombre', direccion='$direccion', idinPais='$pais', idinDepto='$depto', idinMunicipio='$muni' WHERE idinSucursal = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catSucursal','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>