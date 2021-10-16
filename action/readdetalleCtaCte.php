<?php
	include("keyaction.php");
    $id = $_POST['id'];
$fecha  = $_POST['fecha'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No. OC.</th>
							<th>Bodega</th>
							<th>F. Ingreso</th>
							<th>Total</th>
                            <th>Saldo</th>
							<th>Estado</th>
						</tr></thead>';

	$query = "select idinOCEnc, ib.nombre as bodega ,fechaIngreso,total,total-abonado as saldo, ieo.descripcion  from in_oc_enc ioe
inner join in_bodega ib on ioe.idinBodega = ib.idinBodega
inner join in_estado_oc ieo on ieo.idinEstadoOC = ioe.estado
where idinCliente= '$id' and ioe.estado<>5
and fechaIngreso between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."'";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinOCEnc'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['fechaIngreso'].'</td>
                <td>'.$row['total'].'</td>
                <td>'.$row['saldo'].'</td>
                <td>'.$row['descripcion'].'</td>
    		</tr>';
    	}
    }

    $data .= '</table>';

    echo $data;
?>