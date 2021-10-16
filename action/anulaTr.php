<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    $id = $_POST['id'];
        
    $query = "update in_traslado_enc set estado=3 where idinTrasladoEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('anulaTr','A','".$_SESSION["nombre"]."','idinTrasladoEnc=".$id.", 1)',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
    
    echo "Se eliminó el traslado entre bodegas No. ". $id;
}
?>