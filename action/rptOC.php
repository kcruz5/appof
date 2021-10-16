<?php
	include("keyaction.php");
    $cliente = $_POST['cliente'];
    $estado = $_POST['estado'];
    $oc = $_POST['oc'];
    $fecha = $_POST['fecha'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No.</th>
                            <th>Tipo OC</th>
							<th>Bodega</th>
							<th>Cliente</th>
							<th>F. Ingreso</th>
                            <th>Monto</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Estado</th>
						</tr></thead>';

	$query = "select ioe.idinOCEnc as oc, ib.nombre as bodega, 
ic.nombre as cliente, ioe.fechaIngreso as ingreso, (ioe.total) as monto, IFNULL(ioe.descuento,0.00) as descuento, 
IFNULL(ioe.total-ioe.descuento,0.00) as total,
ieo.descripcion as estado, ito.descripcion as tipo from in_oc_enc ioe
inner join in_bodega ib on ioe.idinBodega= ib.idinBodega
inner join in_cliente ic on ioe.idinCliente=ic.idinCte
inner join in_estado_oc ieo on ioe.estado = ieo.idinEstadoOC
INNER JOIN in_tipo_oc ito ON ioe.idinTipoOC = ito.idinTipoOc
where idinOCEnc = case when '$oc' ='' then idinOCEnc else '$oc' end
and ioe.idinCliente = case when '$cliente'=0 then ioe.idinCliente else '$cliente' end
and ioe.estado = case when '$estado' = 0 then ioe.estado else '$estado' end
and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end
order by ioe.estado asc, ioe.fechaIngreso asc, ioe.idinOCEnc";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['oc'].'</td>
                <td>'.$row['tipo'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['cliente'].'</td>
                <td>'.$row['ingreso'].'</td>
				<td>'.$row['monto'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['total'].'</td>
                <td>'.$row['estado'].'</td>                
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="9">No hay ordenes de compra!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>