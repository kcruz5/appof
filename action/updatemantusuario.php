<?php
	if(isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['password']))
	{
		include("keyaction.php");
        session_start();
        $id = $_POST['id'];
		$nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
		$password = $_POST['password'];
        $perfil = $_POST['perfil'];        
        $query = "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantusuario','U','".$_SESSION["nombre"]."','SET ".$id.",".$nombre.",".$usuario."',NOW());";

		$query .= "CALL sp_actualiza_usuario('$id','$nombre', '$usuario', '$password', '$perfil');";       
        if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
       
	    echo "1 Record Added!";
	}
?>