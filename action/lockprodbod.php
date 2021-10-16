<?php
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    session_start();
    $id = $_POST['id'];
    $bodega = $_POST['bodega'];

    $query = "UPDATE in_prod_bodega SET estado=0 WHERE idinbodega = '$bodega' and idinprod='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('prodbod','D','".$_SESSION["nombre"]."','Desactivo ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>
