<?php
	if(isset($_POST['descripcion']) && isset($_POST['precio']))
	{
		// include Database connection file 
		include("keyaction.php");
        session_start();
		// get values 
		$descripcion = $_POST['descripcion'];
		$precio = $_POST['precio'];


		$query = "INSERT INTO in_tipo_oc(descripcion, precio_sn, estado) VALUES('$descripcion', '$precio', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoOC','I','".$_SESSION["nombre"]."','VALUES(".$descripcion.",".$precio.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>