<?php
   session_start();
    include("keyaction.php");

    $id= $_POST['id'];
    $tabla= $_POST['TableData'];
    $query="CALL sp_actualiza_desperdicio ('".$_SESSION["nombre"]."','".$id."')";
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    mysqli_next_result($con);

    $reemplaza= "CALL sp_actualiza_desperdiciodet(";
    $datos=str_replace("(",$reemplaza,$tabla);

    $datos=str_replace("),",");; ",$datos);

    $data=explode("; ",$datos);
   
    for ($i=0; $i<sizeof($data); $i++){
	    $query=$data[$i];
        
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        mysqli_next_result($con); 
	}
    echo $id;

?>         