<?php
	if(isset($_POST['nombre']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];

		$query = "INSERT INTO in_prod_categoria(nombre,estado) VALUES('$nombre', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catProdCat','I','".$_SESSION["nombre"]."','VALUES(".$nombre.", 1)',NOW());";
        
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>