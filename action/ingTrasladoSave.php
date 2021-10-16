<?php
   session_start();
    include("keyaction.php");

    $bodega= $_POST['bodega'];
    $tabla= $_POST['TableData'];
    $destino= $_POST['destino'];
    $query="CALL sp_crea_traslado ('$bodega','$destino','".$_SESSION["nombre"]."')";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $id=$row[0];
    } 
    mysqli_next_result($con); 

    $reemplaza= "CALL sp_crea_trasladodet(".$id.",";
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
