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

	$query = "select 'Entrada' as tipop,iee.idinEbodEnc as num, ib.nombre as bodega,  ''  as tipo, '' as cliente, 
iee.fechaIngreso as fecha, iee.usrIngreso as usuario, ieo.descripcion as estado,'' as total, '' as saldo, iee.idinBodega, iee.estado as idEst from in_ebod_enc iee
inner join in_bodega ib on ib.idinBodega = iee.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp = iee.estado
where case when '$fecha'='' then iee.fechaIngreso =  iee.fechaIngreso else iee.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End";

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