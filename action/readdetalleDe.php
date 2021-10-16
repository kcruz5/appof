<?php
	include("keyaction.php");
    $id = $_POST['id'];


	$query = "select idinProducto, idinProdCat,categoria,producto,IFNULL(cantidad,0) as cantidad,  um as unidad from in_desperdicio_det where idinDespEnc='$id'";

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
                             'Unidad' =>$row['unidad']);
    	}

    }

    echo json_encode($datos);

?>