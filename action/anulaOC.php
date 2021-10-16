<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");
    $id = $_POST['id'];

    $str= "select estado from in_oc_enc where idinOCEnc='$id'";
    $resultset2 = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
	while (	$row2 = mysqli_fetch_array($resultset2, MYSQLI_ASSOC)) {
        if($row2["estado"]==1){           
            $query = "update in_oc_enc set estado=5 where idinOCEnc='$id';";
            $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('anulaOC','A','".$_SESSION["nombre"]."','idinOCEnc=".$id.", 1)',NOW());";

            if (!$result = mysqli_multi_query($con, $query)) {
                exit(mysqli_error($con));
            }
    
            echo "Se eliminó la OC No. ". $id;
        }else {
            echo "No se puede eliminar la OC No. ". $id . " ya que cuenta con un abono.";
        }
    }
}
?>