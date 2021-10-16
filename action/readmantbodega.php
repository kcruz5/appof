<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>  
                            <th>Dirección</th>
                            <th>Encargado</th> 
                            <th>Teléfono</th> 
                            <th>Correo</th> 
							<th>País</th>
							<th>Departamento</th>
							<th>Municipio</th>
                            <th>Estado</th>  
							<th></th>
						</tr></thead>';

	$query = "select inb.idinbodega,inb.nombre,inb.direccion,inb.encargado,inb.telefono,inb.correo,
cp.descripcion as pais, cd.descripcion as depto, cm.descripcion as muni,
case when inb.estado=1 then 'Activo' else 'Inactivo' end as estado from in_bodega inb
inner join c_pais cp on inb.idinpais= cp.idcpais
inner join c_departamento cd on inb.idindepto = cd.idcdepto
inner join c_municipio cm on inb.idinmunicipio= cm.idcmunicipio";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idinbodega'].'</td>
				<td>'.$row['nombre'].'</td>
                <td>'.$row['direccion'].'</td>
                <td>'.$row['encargado'].'</td>
                <td>'.$row['telefono'].'</td>
                <td>'.$row['correo'].'</td>
                <td>'.$row['pais'].'</td>
                <td>'.$row['depto'].'</td>
                <td>'.$row['muni'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="Update('.$row['idinbodega'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idinbodega'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idinbodega'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>  
                            <th>Dirección</th>
                            <th>Encargado</th> 
                            <th>Teléfono</th> 
                            <th>Correo</th> 
							<th>País</th>
							<th>Departamento</th>
							<th>Municipio</th>
                            <th>Estado</th>  
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="11">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>