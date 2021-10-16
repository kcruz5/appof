<?php
	include("keyaction.php");
    $cliente = $_POST['cliente'];
    $fecha = $_POST['fecha'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Cliente</th>
                            <th>Tipo OC</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
						</tr></thead>';

	$query = "select ic.idinCte, ic.nombre, ito.descripcion, iod.idinProducto, precio as precio_venta, iod.producto, sum(cantidad) as cantidad from in_oc_enc ioe
inner join in_oc_det iod on iod.idinOCEnc=ioe.idinOCEnc
inner join in_cliente ic on ic.idinCte = ioe.idinCliente 
inner join in_tipo_oc ito on ioe.idinTipoOC = ito.idinTipoOC
where ioe.estado=4
and ioe.idinCliente= case when '$cliente'=0 then ioe.idinCliente else 1 end
/*and ioe.fechaIngreso between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."'*/
and iod.cantidad <>0
group by  ic.idinCte,ic.nombre, ito.descripcion,iod.idinProducto, precio, iod.producto
order by ic.idinCte,ioe.idinTipoOC, iod.idinProducto";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['nombre'].'</td>
                <td>'.$row['descripcion'].'</td>
				<td>'.$row['producto'].'</td>
				<td>'.$row['cantidad'].'</td>
                <td>'.$row['precio_venta'].'</td>             
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay ordenes de compra!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>