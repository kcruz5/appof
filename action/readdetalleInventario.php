<?php
	include("keyaction.php");
    $id = $_POST['id'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Categoria</th>
							<th>Producto</th>
							<th>C. Ingresada</th>
							<th>C. Sistema</th>
                            <th>Diferencia</th>
							<th>U.M.</th>
						</tr></thead>';

	$query = "select categoria,producto,cantidad as ingresado,IFNULL(cant_sistema,0) as sistema, cantidad - IFNULL(cant_sistema,0) as diferencia, um from in_inventario_det where idinInventarioEnc='$id'";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$row['categoria'].'</td>
				<td>'.$row['producto'].'</td>
				<td>'.$row['ingresado'].'</td>
                <td>'.$row['sistema'].'</td>
                <td>'.$row['diferencia'].'</td>
                <td>'.$row['um'].'</td>
    		</tr>';
    	}
    }

    $data .= '</table>';

    echo $data;
?>