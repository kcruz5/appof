<?php
	
if(isset($_POST['bodega']) && isset($_POST['bodega']) != "")
{
    include("keyaction.php");
    $bodega = $_POST['bodega'];
	$query = "select ipb.idinbodega, ipb.idinProd, ip.idinprodcat, ipc.nombre as categoria, ip.nombre as producto, '' as cantidad, ipu.um_descripcion as unidad,'' as nota  from in_prod_bodega ipb
inner join in_producto ip on ipb.idinProd = ip.idinProd
inner join in_prod_categoria ipc on ip.idinprodcat= ipc.idinprodcat 
inner join in_producto_um ipu on ipu.idinProd = ip.idinProd
where ipb.idinbodega='$bodega'
and IFNULL(ipu.fecha_fin, '')=''
order by ip.idinprodcat";

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
                             'Unidad' =>$row['unidad'],
                            'Nota' =>$row['nota']);
    	}

    }

    echo json_encode($datos);
}
?>