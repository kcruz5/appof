<?php
	if(isset($_POST['nombre']) && isset($_POST['puesto']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];
        $puesto = $_POST['puesto'];

		$query = "INSERT INTO in_empleado(nombre,puesto,estado) VALUES('$nombre','$puesto', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantempleado','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$puesto.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!".$query;
	}
?>