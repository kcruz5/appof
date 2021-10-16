<?php
	if(isset($_POST['nombre']) && isset($_POST['direccion'])&& isset($_POST['telefono'])&& isset($_POST['contacto'])&& isset($_POST['tipo'])&& isset($_POST['limite']))
	{
		// include Database connection file 
		include("keyaction.php");
        session_start();
		// get values 
		$nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
		$telefono = $_POST['telefono'];
		$contacto = $_POST['contacto'];
		$tipo = $_POST['tipo'];
		$limite = $_POST['limite'];
        
		$query = "INSERT INTO in_cliente(nombre,direccion,telefono,contacto,idintipocte,credito,estado) VALUES('$nombre', '$direccion', '$telefono', '$contacto', '$tipo', '$limite', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('manCte','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$direccion.",".$tipo.",".$limite.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>