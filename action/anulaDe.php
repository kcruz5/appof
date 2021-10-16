<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    $id = $_POST['id'];
        
    $query = "update in_desperdicio_enc set estado=3 where idinDespEnc='$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('anulaDe','A','".$_SESSION["nombre"]."','idinDespEnc=".$id.", 1)',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
    
    echo "Se eliminó la Salida por Desperdicio No. ". $id;
}
?>