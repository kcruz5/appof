<?php
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    session_start();
    $id = $_POST['id'];

    $query = "UPDATE in_proveedor SET estado=0 WHERE idinProveedor = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantProveedor','D','".$_SESSION["nombre"]."','Desactivo ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>
