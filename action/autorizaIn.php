<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");

    $id = $_POST['id'];
        
     $query = "update in_inventario_enc set estado=2, fechaFinaliza=NOW(), usrFinaliza='".$_SESSION["nombre"]."' where idinInventarioEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('autorizaIn','A','".$_SESSION["nombre"]."','Autoriza Inventario ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
    
        exit(mysqli_error($con));
    }
    
    echo "Se autorizó el Inventario No. ". $id;
}
?>