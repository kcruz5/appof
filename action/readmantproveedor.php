<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "SELECT idinProveedor, nombre, direccion,telefono,correo, case when estado=1 then 'Activo' else 'Inactivo' end as estado FROM in_proveedor";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinProveedor'].'</td>
				<td>'.$row['nombre'].'</td>
                <td>'.$row['direccion'].'</td>
                <td>'.$row['telefono'].'</td>
				<td>'.$row['correo'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="Update('.$row['idinProveedor'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idinProveedor'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;           
                    <a onclick="Lock('.$row['idinProveedor'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="7">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>