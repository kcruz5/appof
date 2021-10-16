<?php
  session_start();

    include("keyaction.php");
            
    $id= $_POST['id'];
    $tipo = $_POST['tipo'];
    $banco = $_POST['banco'];
    $notran = $_POST['notran'];
    $empleado = $_POST['empleado'];
    $monto = $_POST['monto'];
    $nota = $_POST['nota'];

  $str= "select (total - descuento) - abonado as saldo from in_oc_enc where idinOCEnc='$id'";
    $resultset2 = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
	while (	$row = mysqli_fetch_array($resultset2, MYSQLI_ASSOC)) {
        if($row["saldo"]>=$monto){
            $query="insert into in_oc_abono (idinOCEnc,idinTipoPago,fecha,banco,noTransac,monto,empleadoRecibe,fechaIngreso,usrIngreso,nota) values ('$id','$tipo',NOW(),'$banco','$notran','$monto','$empleado',NOW(),'".$_SESSION["nombre"]."','".$nota."')";

            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }

            if(($row["saldo"]-$monto)>0){
                $query="update in_oc_enc set abonado= abonado+'$monto', estado=2 where idinOCEnc= '$id'";
            }else{
                $query="update in_oc_enc set abonado= abonado+'$monto', estado=3 where idinOCEnc= '$id'"; 
            }
            
            if (!$result = mysqli_query($con, $query)) {
                echo $query;
                exit(mysqli_error($con));
            }


            $query= "select (total-descuento) - abonado as saldo from in_oc_enc where idinOCEnc='$id'";
            $resultset = mysqli_query($con, $query) or die("Error de base de datos:". mysqli_error($con));
            while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
                echo "Se abonó a la orden de compra ".$id." Saldo: Q.".$row["saldo"] ;
            } 
        }else{
            echo "No fue posible abonar la orden de compra ".$id." ya que el monto sobrepasa el saldo";
        }
    } 

?>         