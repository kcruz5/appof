<?php
   session_start();
    include("keyaction.php");

    $bodega= $_POST['bodega'];
    $tabla= $_POST['TableData'];
    $query="CALL sp_crea_ingbodega ('$bodega','".$_SESSION["nombre"]."')";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $id=$row[0];
    } 
    mysqli_next_result($con); //Prepara el siguiente juego de resultados de una llamada 
  //  mysqli_free_result($con); //Libera la memoria asociada al resultado.

    $reemplaza= "CALL sp_crea_inbodegadet(".$id.",";
    $datos=str_replace("(",$reemplaza,$tabla);

    $datos=str_replace("),",");; ",$datos);

    $data=explode("; ",$datos);
   
    for ($i=0; $i<sizeof($data); $i++){
	    $query=$data[$i];

        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        mysqli_next_result($con); //Prepara el siguiente juego de resultados de una llamada 
	}

    echo $id;
?>            