<?php
	
if(isset($_POST['bodega']) && isset($_POST['bodega']) != "")
{
    include("keyaction.php");
    $bodega = $_POST['bodega'];
    $tipo = $_POST['tipo'];
    
     $query="CALL sp_tmp_ing_oc ('$bodega','$tipo')";
	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
        $datos=array();
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$datos[] = array('Codigo' => $row['idinProd'],
                             'CategoriaCod' => $row['idinprodcat'],
                             'Categoria' => $row['categoria'],
                             'Producto' => $row['producto'],
                             'Cantidad' => $row['cantidad'],                             
                             'Unidad' => $row['unidad'],
                             'Precio' => $row['precio'],
                             'Total' => $row['total'],
                             'Nota' => $row['nota'],
                            'Existencia' => $row['existencia']);
    	}

    }

    echo json_encode($datos);
}
?>