<?php
session_start();
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");

    $id = $_POST['id'];
        
    $query = "update in_ajuste_enc set estado=2, fechaFinaliza=NOW(), usrFinaliza='".$_SESSION["nombre"]."' where idinAjusteEnc='$id';";
    
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>