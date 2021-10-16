<?php
	include("keyaction.php");
    $fecha = $_POST['fecha'];
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No.</th>
							<th>Bodega</th>
                            <th>Tipo</th>
							<th>Fecha</th>
							<th>Usuario</th>
                            <th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "select ib.idinBodega, iae.idinAjusteEnc as codigo, concat('Ajuste de ',ita.descripcion) AS tipoajuste, ib.nombre as bodega, iae.fechaIngreso as fecha, 
iae.usrIngreso as usuario,ieo.descripcion as estado, iae.estado as idEstado from in_ajuste_enc iae
inner join in_bodega ib on ib.idinBodega = iae.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp= iae.estado
INNER JOIN in_tipo_ajuste ita ON iae.idinTipoAjuste = ita.idinTipoAjuste
where iae.estado<>3 and case when '$fecha'='' then iae.fechaIngreso =  iae.fechaIngreso else iae.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End";

	if (!$result = mysqli_query($con, $query)) {
        echo $query;
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['codigo'].'</td>
				<td>'.$row['bodega'].'</td>
                <td>'.$row['tipoajuste'].'</td>
				<td>'.$row['fecha'].'</td>
                <td>'.$row['usuario'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="detail('.$row['codigo'].','.$row['idinBodega'].','.$row['idEstado'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>No.</th>
							<th>Bodega</th>
                            <th>Tipo</th>
							<th>Fecha</th>
							<th>Usuario</th>
                            <th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="7">No hay ajustes de inventario registrados!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>