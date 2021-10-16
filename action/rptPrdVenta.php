<?php
	include("keyaction.php");
    $bodega = $_POST['bodega'];
    $fecha = $_POST['fecha'];
    $costo = 0.00;
    $venta = 0.00;
    $utilidad=0.00;
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Bodega</th>
							<th>Categoria</th>
							<th>Producto</th>
                            <th>Cantidad</th>
						</tr></thead>';

$query="SELECT * 
FROM (
SELECT 1 AS orden, iod.idinBodega,ib.nombre as bodega,producto,categoria, sum(cantidad) AS cantidad FROM in_oc_det iod
INNER JOIN in_oc_enc ioe ON iod.idinOCEnc = ioe.idinOCEnc
 inner join in_bodega ib on ioe.idinBodega = ib.idinBodega
WHERE ioe.estado=4 AND iod.cantidad<>0
AND ioe.idinBodega = case when '$bodega' = 0 then ioe.idinBodega else '$bodega' end 
and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end
GROUP BY iod.idinBodega,ib.nombre,producto,categoria
union
SELECT 2 AS orden, iod.idinBodega,ib.nombre as bodega,'TOTAL',categoria, sum(cantidad) AS cantidad FROM in_oc_det iod
INNER JOIN in_oc_enc ioe ON iod.idinOCEnc = ioe.idinOCEnc
 inner join in_bodega ib on ioe.idinBodega = ib.idinBodega
WHERE ioe.estado=4 AND iod.cantidad<>0
AND ioe.idinBodega = case when '$bodega' = 0 then ioe.idinBodega else '$bodega' end 
and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end

GROUP BY  iod.idinBodega,ib.nombre,categoria
) AS x
ORDER BY idinBodega, x.categoria, orden";
	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
            <td>'.$row['bodega'].'</td>
				<td>'.$row['categoria'].'</td>
				<td>'.$row['producto'].'</td>
                <td>'.$row['cantidad'].'</td>
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="4">No hay movimientos para el mes seleccionado!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>