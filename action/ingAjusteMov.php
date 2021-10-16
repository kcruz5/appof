<?php
   session_start();
    include("keyaction.php");

    $bodega= $_POST['bodega'];
    $idEn= $_POST['id'];
    $tipoa= $_POST['tipoa'];

    $query="SELECT CASE WHEN '$tipoa' = 1 THEN 
(select idinTipoMov from in_tipo_mov where tipo='E' and descripcion like '%ajuste%' and estado=1) ELSE 
(select idinTipoMov from in_tipo_mov where tipo='S' and descripcion like '%ajuste%' and estado=1)
END AS tipo
";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $tipo=$row[0];
    } 

    $query="CALL sp_crea_movenc ('$bodega','$tipo','".$_SESSION["nombre"]."')";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $id=$row[0];
    } 
    mysqli_next_result($con); //Prepara el siguiente juego de resultados de una llamada 

  
    $query="CALL sp_crea_movajdet (".$id.",'$idEn')";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $id=$row[0];
    } 
    mysqli_next_result($con); //Prepara el siguiente juego de resultados de una llamada 

    echo $id;


?>         