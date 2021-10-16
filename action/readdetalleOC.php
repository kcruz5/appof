<?php
	include("keyaction.php");
    $id = $_POST['id'];

	$query = "select idinProducto, idinProdCat,categoria,producto,IFNULL(cantidad,0) as cantidad,um as unidad,IFNULL(precio,0.00) as precio, IFNULL(cantidad,0) *IFNULL(precio,0.00) as total,descripcion as nota from in_oc_det where idinOCEnc='$id'";


	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
        $datos=array();
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$datos[] = array('Codigo' => $row['idinProducto'],
                             'CategoriaCod' => $row['idinProdCat'],
                             'Categoria' => $row['categoria'],
                             'Producto' => $row['producto'],
                             'Cantidad' => $row['cantidad'],                             
                             'Unidad' => $row['unidad'],
                             'Precio' => $row['precio'],
                             'Total' => $row['total'],
                             'Nota' => $row['nota']);
    	}

    }

    echo json_encode($datos);
?>