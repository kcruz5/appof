<?php
	if(isset($_POST['nombre']) && isset($_POST['proveedor'])&& isset($_POST['categoria'])&& isset($_POST['um'])&& isset($_POST['precompra'])&& isset($_POST['preventa']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];
		$proveedor = $_POST['proveedor'];
		$categoria = $_POST['categoria'];
		$um = $_POST['um'];
        $precompra = $_POST['precompra'];
        $preventa = $_POST['preventa'];
        $presp1 = $_POST['presp1'];
        $presp2 = $_POST['presp2'];
        $presp3 = $_POST['presp3'];

        $query = "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantProducto','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$categoria.",".$precompra.",".$preventa.")',NOW());";
		
		$query .= "CALL sp_crea_producto('$nombre', '$proveedor', '$categoria', '$um','$precompra','$preventa','$presp1','$presp2','$presp3');";

        if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
        mysqli_close($con);
	    echo "1 Record Added!";
	}
?>