<?php
	if(isset($_POST['um']))
	{
		include("keyaction.php");
        session_start();        
        $id = $_POST['id'];
		$um = $_POST['um'];

        $query = "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantproductoum','U','".$_SESSION["nombre"]."','SET ".$id.",".$nombre.",".$usuario."',NOW());";

		$query .="CALL sp_actualiza_producto_um('$id','$um');";

        if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
       
	    echo "1 Record Added!";
	}
?>