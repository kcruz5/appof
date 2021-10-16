<?php
	
    include("keyaction.php");

if(isset($_POST['oc']))
{
    $id = $_POST['oc'];
	$query = "SELECT (IFNULL(total,0)-IFNULL(descuento,0))-IFNULL(abonado,0) as saldo FROM in_oc_enc where idinOCEnc='$id'";
    
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$saldo= "El Saldo de la OC es de: ".$row['saldo']." ";
				
    	}
    echo $saldo;
}

?>