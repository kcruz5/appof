<?php
    include("keyaction.php");

    $id= $_POST['id'];
    $total = $_POST['total'];
    $bodega = $_POST['bodega'];
    $tabla= $_POST['TableData'];
    $descto = $_POST['descto'];

    $query="CALL sp_actualiza_ocenc ('$total','$id','$bodega','$descto')";
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    mysqli_next_result($con);

    $reemplaza= "CALL sp_actualiza_ocdet(";
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