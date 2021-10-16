<?php
   session_start();
    include("keyaction.php");

   $bodega= $_POST['bodega'];
    $idEn= $_POST['id'];

    $query="select idinTipoMov from in_tipo_mov where tipo='S' and descripcion like '%desperdicio%' and estado=1";
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

  
    $query="CALL sp_crea_movdedet (".$id.",'$idEn')";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
    while (	$row = mysqli_fetch_array($resultset, MYSQLI_NUM)) {
            $id=$row[0];
    } 
    mysqli_next_result($con); //Prepara el siguiente juego de resultados de una llamada 

    echo $id;


?>         