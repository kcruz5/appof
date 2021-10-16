<?php
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    session_start();
    $id = $_POST['id'];

    $query = "UPDATE in_producto SET estado=1 WHERE idinProd = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantproducto','A','".$_SESSION["nombre"]."','Activo ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>
