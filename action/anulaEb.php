<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    $id = $_POST['id'];
        
    $query = "update in_ebod_enc set estado=3 where idinEbodEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('anulaEb','A','".$_SESSION["nombre"]."','idinEbodEnc=".$id.", 1)',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
    
    echo "Se eliminó la entrada a bodega No. ". $id;
}
?>