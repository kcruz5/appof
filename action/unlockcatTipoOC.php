<?php
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    session_start();
    $id = $_POST['id'];

    $query = "UPDATE in_tipo_oc SET estado=1 WHERE idinTipoOC = '$id';";
    $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoOc','A','".$_SESSION["nombre"]."','Activo ".$id."',NOW());";
    
    if (!$result = mysqli_multi_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
?>
