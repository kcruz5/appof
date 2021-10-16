<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");

    $id = $_POST['id'];
        
    $query = "update in_desperdicio_enc set estado=2, fechaFinaliza=NOW(), usrFinaliza='".$_SESSION["nombre"]."' where idinDespEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('autorizaDe','A','".$_SESSION["nombre"]."','Autoriza Desperdicio ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
    
        exit(mysqli_error($con));
    }
}
?>