<?php
include("keyaction.php");

if(isset($_POST))
{
    session_start();
    $id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$proveedor = $_POST['proveedor'];
	$categoria = $_POST['categoria'];
    
    $query = "UPDATE in_producto SET nombre='$nombre', idinProveedor='$proveedor', idinProdCat='$categoria' WHERE idinProd = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantproducto','U','".$_SESSION["nombre"]."','Actualiza id=".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>