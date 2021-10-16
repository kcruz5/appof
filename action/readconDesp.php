<?php
	include("keyaction.php");
    $fecha = $_POST['fecha'];
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No.</th>
							<th>Bodega</th>
							<th>Fecha</th>
							<th>Usuario</th>
                            <th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "select 'Desperdicio' as tipop,ide.idinDespEnc as num, ib.nombre as bodega,  
ide.fechaIngreso as fecha, usrIngreso as usuario, ieo.descripcion as estado, ide.idinBodega, ide.estado as idEst from in_desperdicio_enc ide
inner join in_bodega ib on ib.idinBodega = ide.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp = ide.estado
where ide.estado<>3 and case when '$fecha'='' then ide.fechaIngreso =  ide.fechaIngreso else ide.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['fecha'].'</td>
                <td>'.$row['usuario'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="detail('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>No.</th>
							<th>Bodega</th>
							<th>Fecha</th>
							<th>Usuario</th>
                            <th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="6">No hay salidas por desperdicio!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>