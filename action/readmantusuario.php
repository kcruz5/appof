<?php
	include("keyaction.php");

	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>  
                            <th>Usuario</th>
                            <th>Perfil</th> 
                            <th>Estado</th>   
							<th></th>
						</tr></thead>';

	$query = "select cu.idcUsuario, nombre,usuario,cp.descripcion as perfil, case when cu.estado=1 then 'Activo' else 'Inactivo' end as estado from c_usuario cu
inner join c_usr_perfil_empresa cupe on cu.idcUsuario=cupe.idcUsuario
inner join c_perfil cp on cp.idcPerfil = cupe.idcPerfil
";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }

    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['idcUsuario'].'</td>
				<td>'.$row['nombre'].'</td>
                <td>'.$row['usuario'].'</td>
                <td>'.$row['perfil'].'</td>
                <td>'.$row['estado'].'</td>
				<td>          
                    <a onclick="Update('.$row['idcUsuario'].')" class="edit" title="Editar"><i class="fas fa-pencil-alt"></i></a>&nbsp;
                    <a onclick="Unlock('.$row['idcUsuario'].')" class="unlock" title="Activar"><i class="fas fa-unlock-alt"></i></a>    &nbsp;            
                    <a onclick="Lock('.$row['idcUsuario'].')" class="lock" title="Desactivar"><i class="fas fa-lock"></i></a>  
				</td>
    		</tr>';
    	}
        $data .='<tfoot><tr>
							<th>Código</th>
							<th>Nombre</th>  
                            <th>Usuario</th>
                            <th>Perfil</th> 
                            <th>Estado</th>   
							<th></th>
						</tr></tfoot>';
    }
    else
    {
    	$data .= '<tr><td colspan="6">No hay registros!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>