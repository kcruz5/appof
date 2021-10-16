<?php
	if(isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['encargado'])&& isset($_POST['telefono'])&& isset($_POST['correo'])&& isset($_POST['pais'])&& isset($_POST['depto'])&& isset($_POST['muni']))
	{
		include("keyaction.php");
        session_start();
		$nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
		$encargado = $_POST['encargado'];
		$telefono = $_POST['telefono'];
		$correo = $_POST['correo'];        
		$pais = $_POST['pais'];
		$depto = $_POST['depto'];
        $muni = $_POST['muni'];

		$query = "INSERT INTO in_bodega (idcEmpresa,nombre,direccion,encargado,telefono,correo,idinpais,idindepto,idinmunicipio,estado) VALUES(1,'$nombre', '$direccion', '$encargado', '$telefono', '$correo', '$pais', '$depto', '$muni', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('mantBodega','I','".$_SESSION["nombre"]."','VALUES(".$nombre.",".$direccion.",".$depto.",".$muni.", 1)',NOW());";
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>