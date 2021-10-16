<?php
	if(isset($_POST['bodega']) )
	{
		include("keyaction.php");
        session_start();
		$bodega = $_POST['bodega'];
        $id = $_POST['id'];

        if($bodega != 0 ){
            $query = "INSERT INTO in_prod_bodega(idinbodega,idinProd,fecha_asigna,estado) VALUES('$bodega','$id',NOW(), 1);";
            $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantempleado','U','".$_SESSION["nombre"]."','SET ".$bodega.",".$id."',NOW());";
        } else {
            $query="INSERT INTO in_prod_bodega(idinbodega,idinProd,fecha_asigna,estado)  select idinBodega, '$id', NOW(), 1 from in_bodega where idinBodega not in (select idinbodega from in_prod_bodega where idinProd='$id') and estado=1;";
            $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantUsuarioBod','U','".$_SESSION["nombre"]."','Todas las bodegas producto ".$id."',NOW());";
        }
        
        if (!$result = mysqli_multi_query($con, $query)) {
            exit(mysqli_error($con));
        }
        
	    echo "1 Record Added!";
	}
?>