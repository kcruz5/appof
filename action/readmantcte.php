<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Dirección</th>
							<th>Teléfono</th>
                            <th>Nombre Contacto</th>
                            <th>Tipo Cliente</th>
                            <th>Límite de Crédito</th>
                            <th>Estado</th>
							<th></th>
						</tr></thead>';

	$query = "select idinCte, ic.nombre, ic.direccion,ic.telefono,ic.contacto,itc.descripcion as tipo,ic.credito,case when ic.estado=1 then 'Activo' else 'Inactivo' end as estado  from in_cliente ic inner join in_tipo_cte itc on ic.idintipocte=itc.idintipocte";

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
				<td>'.$row['nombre'].'</td>
				<td>'.$row['direccion'].'</td>
                <td>'.$row['telefono'].'</td>
				<td>'.$row['contacto'].'</td>
				<td>'.$row['tipo'].'</td>
				<td>'.$row['credito'].'</td>
                <td>'.$row['estado'].'</td>                
				<td>          
                    <a onclick="Update('.$row['idinCte'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idinCte'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idinCte'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Dirección</th>
							<th>Teléfono</th>
                            <th>Nombre Contacto</th>
                            <th>Tipo Cliente</th>
                            <th>Límite de Crédito</th>
                            <th>Estado</th>
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="9">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>