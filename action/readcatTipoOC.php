<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Muestra Precio</th>
							<th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "SELECT idinTipoOC, descripcion, case when precio_sn=1 then 'SI' 
 else 'NO' end as precio, case when estado=1 then 'Activo' else 'Inactivo' end as estado FROM in_tipo_oc";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinTipoOC'].'</td>
				<td>'.$row['descripcion'].'</td>
				<td>'.$row['precio'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="Update('.$row['idinTipoOC'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idinTipoOC'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idinTipoOC'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Muestra Precio</th>
							<th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="5">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>