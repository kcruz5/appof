<?php
	include("keyaction.php");
    $producto = $_POST['producto'];
    $proveedor = $_POST['proveedor'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Producto</th>
							<th>Categoría</th>
							<th>Proveedor</th>
							<th>Estado</th>
						</tr></thead>';

	$query = "select iprod.idinProd as codigo, iprod.nombre as producto, ipc.nombre as categoria,  iprov.nombre as proveedor, case when iprod.estado = 1 then 'ACTIVO' else 'INACTIVO' end as estado from in_producto iprod
inner join in_proveedor iprov on iprod.idinProveedor = iprov.idinProveedor
inner join in_prod_categoria ipc on iprod.idinProdCat= ipc.idinProdCat
where (iprod.idinProd =case when '$producto'=0 then iprod.idinProd else '$producto' end )
and (iprod.idinProveedor= case when '$proveedor'=0 then iprod.idinProveedor else '$proveedor' end)
order by iprod.idinProd";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['codigo'].'</td>
				<td>'.$row['producto'].'</td>
				<td>'.$row['categoria'].'</td>
                <td>'.$row['proveedor'].'</td>
                <td>'.$row['estado'].'</td>
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay productos asignados al proveedor!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>