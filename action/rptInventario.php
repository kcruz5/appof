<?php
	include("keyaction.php");
    $bodega = $_POST['bodega'];
    $fecha = $_POST['fecha'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No.</th>
							<th>Bodega</th>
							<th>Fecha</th>
							<th>Usuario</th>
							<th></th>
						</tr></thead>';

	$query = "select idinInventarioEnc as codigo, ib.nombre as bodega, iie.fechaIngreso as fecha, iie.usrIngreso as usuario from in_inventario_enc iie
inner join in_bodega ib on ib.idinBodega = iie.idinBodega
where  iie.estado<> 3 and iie.idinBodega = case when '$bodega'=0 then iie.idinBodega else '$bodega' end
and fechaIngreso between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."'";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['codigo'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['fecha'].'</td>
                <td>'.$row['usuario'].'</td>
				<td>          
                    <a onclick="detail('.$row['codigo'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>
				</td>
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay inventario registrado en el mes!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>