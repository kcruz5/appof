<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
                            <th>Total</th>
                            <th>Monto Abonado</th>
							<th>Saldo</th>
						</tr></thead>';

	$query = "select ic.idinCte, ic.nombre as cliente , sum(total) as total, sum(abonado) as abonado, sum(total) -sum(abonado) saldo from in_cliente ic inner join in_oc_enc ioe on ic.idinCte= ioe.idinCliente group by ic.idinCte,ic.nombre";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinCte'].'</td>
				<td>'.$row['cliente'].'</td>
				<td>Q. '.$row['total'].'</td>
                <td>Q. '.$row['abonado'].'</td>
				<td>Q. '.$row['saldo'].'</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>
                            <th>Total</th>
                            <th>Monto Abonado</th>
							<th>Saldo</th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay clientes con saldo!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>