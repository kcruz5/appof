<?php
	if(isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['password']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
		$password = $_POST['password'];
        $perfil = $_POST['perfil'];        

		$query = "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantUsuario','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$usuario.",".$perfil.")',NOW());";
		
		$query .= "CALL sp_crea_usuario('$nombre', '$usuario', '$password', '$perfil');";

		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
       
	    echo "1 Record Added!";
	}
?>