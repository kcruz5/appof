<?php
	if(isset($_POST['nombre']) && isset($_POST['direccion'])&& isset($_POST['pais'])&& isset($_POST['depto'])&& isset($_POST['muni']))
	{
		include("keyaction.php");
        session_start();
		
        $nombre = $_POST['nombre'];
		$direccion = $_POST['direccion'];
		$pais = $_POST['pais'];
		$depto = $_POST['depto'];
        $muni = $_POST['muni'];

		$query = "INSERT INTO in_sucursal (idcEmpresa,nombre,direccion,idinpais,idindepto,idinmunicipio,estado) VALUES(1,'$nombre', '$direccion', '$pais', '$depto', '$muni', 1);";
        $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('catSucursal','I','".$_SESSION["nombre"]."','VALUES(1,".$nombre.",".$direccion.",".$pais.",".$depto.", ".$muni.", 1)',NOW());";
        
		if (!$result = mysqli_multi_query($con, $query)) {
	        exit(mysqli_error($con));
	    }
	    echo "1 Record Added!";
	}
?>