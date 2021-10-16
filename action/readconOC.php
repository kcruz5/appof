<?php
	include("keyaction.php");
   $fecha = $_POST['fecha'];
	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No. OC</th>
							<th>Bodega</th>
							<th>Tipo</th>
							<th>Cliente</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Descuento</th>
                            <th>Saldo</th>
							<th></th>
						</tr></thead>';

	$query = "SELECT ib.idinBodega,ioe.idinOCEnc as numoc, ib.nombre as bodega, ito.descripcion as tipo,
ic.nombre as cliente, ioe.fechaIngreso, ieo.descripcion as estado, total, total- descuento -abonado as saldo, ioe.estado as idEst, ioe.descuento FROM in_oc_enc ioe
inner join in_bodega ib on ib.idinBodega = ioe.idinBodega
inner join in_tipo_oc ito on ito.idinTipoOc = ioe.idinTipoOC
inner join in_cliente ic on ic.idinCte = ioe.idinCliente
inner join in_estado_oc ieo on ieo.idinEstadoOC = ioe.estado
where ioe.estado<>5 and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End
order by ioe.estado asc, ioe.idinOCEnc";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['numoc'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>          
                    <a onclick="detail('.$row['numoc'].','.$row['idinBodega'].','.$row['idEst'].','.$row['descuento'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>&nbsp;
                   ';
            
                    if($row['idEst']<3){
            $data .='<a onclick="Abono('.$row['numoc'].')" class="unlock" title="Abonar"><i class="fas fa-hand-holding-usd"></i>  </a>' ;  
                        
                    }
                
                
			$data .= '	</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
								<th>No. OC</th>
							<th>Bodega</th>
							<th>Tipo</th>
							<th>Cliente</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Descuento</th>
                            <th>Saldo</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="9">No hay OC pendientes!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>