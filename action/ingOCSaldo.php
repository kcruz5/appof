<?php

    include("keyaction.php");
            
    $id= $_POST['id'];

    $query= "select (total-descuento) - abonado as saldo from in_oc_enc where idinOCEnc='$id'";
    $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
	while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
        $saldo =$row["saldo"] ;
    } 
echo $saldo;
?>         