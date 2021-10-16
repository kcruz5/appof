<?php
	if(isset($_POST['descripcion']) && isset($_POST['tipo']))
	{
		include("keyaction.php");
        session_start();
		$descripcion = $_POST['descripcion'];
		$tipo = $_POST['tipo'];


		$query = "INSERT INTO in_tipo_mov(descripcion, tipo, estado) VALUES('$descripcion', '$tipo', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoEs','I','".$_SESSION["nombre"]."','VALUES(".$descripcion.",".$tipo.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>