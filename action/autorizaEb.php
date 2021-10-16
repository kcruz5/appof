<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");

    $id = $_POST['id'];
        
    $query = "update in_ebod_enc set estado=2, fechaFinaliza=NOW(), usrFinaliza='".$_SESSION["nombre"]."' where idinEbodEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('autorizaEb','A','".$_SESSION["nombre"]."','Autoriza EBOD ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
    
        exit(mysqli_error($con));
    }
}
?>