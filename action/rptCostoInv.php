<?php
	include("keyaction.php");
    $fecha = $_POST['fecha'];
    $bodega =$_POST['bodega'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Bodega</th>
							<th>Categoría</th>
							<th>Producto</th>
							<th>Costo</th>
                            <th>P. Venta</th>
                            <th>P. Esp. 1</th>
                            <th>P. Esp. 2</th>
                            <th>P. Esp. 3</th>
                            <th>Existencia</th>
                            <th>Costo de Inventario</th>
						</tr></thead>';
    $query="CALL sp_rpt_costo_inventario ('$fecha','$bodega')";
$total=0;
	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
            $total = $total + $row['costo_inv'];
    		$data .= '<tr>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['categoria'].'</td>
				<td>'.$row['producto'].'</td>
                <td>'.$row['costo'].'</td>
				<td>'.$row['precio_venta'].'</td>
				<td>'.$row['presp1'].'</td>
				<td>'.$row['presp2'].'</td>
                <td>'.$row['presp3'].'</td>
				<td>'.$row['existencia'].'</td>
				<td>'.$row['costo_inv'].'</td>
    		</tr>';
    	}
        $data .='<tfoot><tr><th>Total Costo Inventario:</th>
        <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>Q. '.number_format($total,2).'</th></tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay inventario en esta fecha!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>