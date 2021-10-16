<?php
	include("keyaction.php");
    $id = $_POST['id'];
    $total=0.00;

    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Abono No.</th>
							<th>Fecha</th>
							<th>T. Pago</th>
							<th>Monto</th>
                            <th>No. Transacción</th>
                            <th>Banco</th>
							<th>Nota</th>
                            <th>Empleado Recibe</th>
						</tr></thead>';

	$query = "SELECT idinOCAbono AS no, ioa.fecha, ioa.banco,ioa.noTransac,ioa.monto, ioa.empleadoRecibe, ioa.nota,
itp.descripcion AS tipo
FROM in_oc_abono ioa
INNER JOIN in_oc_enc ioe ON ioa.idinOCEnc= ioe.idinOCEnc
INNER JOIN in_cliente ic ON ioe.idinCliente = ic.idinCte
INNER JOIN in_tipo_pago itp ON ioa.idinTipoPago = itp.idinTipoPago
WHERE ioa.idinOCEnc= '$id' and ioe.estado<>5";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
            $total = $total + $row['monto'];
    		$data .= '<tr>
				<td>'.$row['no'].'</td>
				<td>'.$row['fecha'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['monto'].'</td>
                <td>'.$row['noTransac'].'</td>
                <td>'.$row['banco'].'</td>
                <td>'.$row['nota'].'</td>
                <td>'.$row['empleadoRecibe'].'</td>
    		</tr>';
    	}
        $data .= '<tfoot><tr>
				<td>Total Pagado:</td>
				<td></td>
				<td></td>
                <td>Q. '.number_format($total,2).'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td></tr>
    		  </tfoot>';
    }

    $data .= '</table>';

    echo $data;
?>