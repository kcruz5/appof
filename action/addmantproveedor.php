<?php
	if(isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['correo']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];

        if ($correo == "") {
            $correo="";
        }
		$query = "INSERT INTO in_proveedor(nombre, direccion, telefono, correo, estado) VALUES('$nombre', '$direccion', '$telefono', '$correo',1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantProveedor','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$direccion.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>
