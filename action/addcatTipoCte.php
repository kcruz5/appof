<?php
	if(isset($_POST['descripcion']))
	{
		include("keyaction.php");
        session_start();

		$descripcion = $_POST['descripcion'];

		$query = "INSERT INTO in_tipo_cte(descripcion,estado) VALUES('$descripcion', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catTipoCte','I','".$_SESSION["nombre"]."','VALUES(".$descripcion.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>