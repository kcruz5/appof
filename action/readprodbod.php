<?php
	
    include("keyaction.php");

    $bodega= $_POST['id'];

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Cod. Prod.</th>
							<th>Producto</th>
							<th>Categoría</th>
							<th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "select ipb.idinbodega, ipb.idinProd,ip.nombre as producto, ipc.nombre as categoria, case when ipb.estado=1 then 'Activo' else 'Inactivo' end as estado  from in_prod_bodega ipb
inner join in_producto ip on ipb.idinProd = ip.idinProd
inner join in_prod_categoria ipc on ip.idinprodcat= ipc.idinprodcat 
where ipb.idinbodega='$bodega' order by ipb.idinProd";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinProd'].'</td>
				<td>'.$row['producto'].'</td>
				<td>'.$row['categoria'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="Unlock('.$row['idinProd'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idinProd'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Cod. Prod.</th>
							<th>Producto</th>
							<th>Categoría</th>
							<th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	$data .= '<tr><td colspan="5">No hay productos asignados!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>