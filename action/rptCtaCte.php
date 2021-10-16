<?php
	include("keyaction.php");
    $cliente = $_POST['cliente'];
    $fecha = $_POST['fecha'];
	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
                            <th>Total</th>
                            <th>Monto Abonado</th>
							<th>Saldo</th>
                            <th></th>
						</tr></thead>';

	$query = "select ic.idinCte, ic.nombre as cliente , sum(total) as total, sum(abonado) as abonado, sum(total) -sum(abonado) saldo from in_cliente ic inner join in_oc_enc ioe on ic.idinCte= ioe.idinCliente 
    where ic.idinCte = case when '$cliente' = 0 then ic.idinCte else '$cliente' end 
     AND ioe.estado=4
    and fechaIngreso between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."'
    group by ic.idinCte,ic.nombre";

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
                				<td>          
                    <a onclick="detail('.$row['idinCte'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>
				</td>
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="6">No hay clientes con saldo!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>