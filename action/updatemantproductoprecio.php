<?php
	if(isset($_POST['precompra']) && isset($_POST['preventa']))
	{
		include("keyaction.php");
        session_start();        
        $id = $_POST['id'];
		$precompra = $_POST['precompra'];
        $preventa = $_POST['preventa']; 
        $presp1 = $_POST['presp1'];
        $presp2 = $_POST['presp2'];
        $presp3 = $_POST['presp3'];

        $query = "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantproductoprecio','U','".$_SESSION["nombre"]."','SET ".$id.",".$nombre.",".$usuario."',NOW());";
		$query .="CALL sp_actualiza_producto_precio('$id','$precompra', '$preventa', '$presp1', '$presp2', '$presp3');";

        if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
       
	    echo "1 Record Added!";
	}
?>