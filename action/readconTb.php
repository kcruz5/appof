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

	$query = "select 'Traslado' as tipop,ite.idinTrasladoEnc as num, ib.nombre as bodega,  CONCAT('A:', ' ', ibt.nombre)  as tipo, '' as cliente, 
ite.fechaIngreso as fecha, ite.usrIngreso as usuario, ieo.descripcion as estado,'' as total, '' as saldo, ite.idinBodega, ite.estado as idEst from in_traslado_enc ite
inner join in_bodega ib on ib.idinBodega = ite.idinBodega
inner join in_bodega ibt on ibt.idinBodega = ite.idinBodegaDest
inner join in_estado_op ieo on ieo.idinEstadoOp = ite.estado
where ite.estado<>3 and case when '$fecha'='' then ite.fechaIngreso =  ite.fechaIngreso else ite.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End";

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
    	$data .= '<tr><td colspan="6">No hay traslados de bodegas!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>