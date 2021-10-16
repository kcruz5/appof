<?php
session_start();

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    include("keyaction.php");

    $id = $_POST['id'];

    $str= "select estado from in_oc_enc where idinOCEnc='$id'";
    $resultset2 = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
	while (	$row2 = mysqli_fetch_array($resultset2, MYSQLI_ASSOC)) {
        if($row2["estado"]==3){           
            $query = "update in_oc_enc set estado=4,fechaAutoriza=NOW(), usrAutoriza='".$_SESSION["nombre"]."' where idinOCEnc='$id';";
            if (!$result = mysqli_query($con, $query)) {
    
                exit(mysqli_error($con));
            }

            $query="CALL sp_crea_movoc ('$id')";
            $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
            while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
                    $mov=$row[0];
            } 
            
            mysqli_close($con);
            echo "Se creo el movimiento de inventario No. ". $mov;
        }else {
            echo "No se puede autorizar la OC No. ". $id . " ya que no se encuentra en estado pagada.";
        }
    }
}
?>
