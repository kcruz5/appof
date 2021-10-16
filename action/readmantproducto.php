<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Categoría</th>
							<th>U.M.</th>
							<th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Precio Esp. 1</th>
                            <th>Precio Esp. 2</th>
                            <th>Precio Esp. 3</th>
                            <th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "select ip.idinprod, ip.nombre,  ipr.nombre as proveedor, ic.nombre as categoria,
ipu.um_descripcion as um, ipp.precio_compra as precompra, ipp.precio_venta as preventa,
ipp.precioEspecial1 as presp1,ipp.precioEspecial2 as presp2,ipp.precioEspecial3 as presp3,
case when ip.estado=1 then 'Activo' else 'Inactivo' end as estado 
from in_producto ip
inner join in_proveedor ipr on ip.idinproveedor= ipr.idinproveedor
inner join in_prod_categoria ic on ip.idinprodcat= ic.idinprodcat
inner join in_producto_um ipu on ip.idinprod= ipu.idinprod
inner join in_producto_precio ipp on ip.idinprod= ipp.idinprod
where ipu.fecha_fin IS NULL AND ipp.fecha_fin IS NULL
order by ip.idinprod
";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinprod'].'</td>
				<td>'.$row['nombre'].'</td>
				<td>'.$row['proveedor'].'</td>
                <td>'.$row['categoria'].'</td>
				<td>'.$row['um'].'</td>
				<td>'.$row['precompra'].'</td>
                <td>'.$row['preventa'].'</td>
                <td>'.$row['presp1'].'</td>
                <td>'.$row['presp2'].'</td>
                <td>'.$row['presp3'].'</td>
                <td>'.$row['estado'].'</td>                
				<td>          
                    <a onclick="Update('.$row['idinprod'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="UpdateUnit('.$row['idinprod'].')" class="um" title="Edita UM"><i class="fas fa-balance-scale"></i></a>&nbsp;
                    <a onclick="UpdatePrice('.$row['idinprod'].')" class="price" title="Edita Precio"><i class="fas fa-money-bill"></i></a>&nbsp;
                    <a onclick="UpdateBod('.$row['idinprod'].')" class="bodega" title="Asigna a Bodega"><i class="fas fa-building"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idinprod'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idinprod'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a> 

				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Categoría</th>
							<th>U.M.</th>
							<th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Precio Esp. 1</th>
                            <th>Precio Esp. 2</th>
                            <th>Precio Esp. 3</th>
                            <th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="12">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>