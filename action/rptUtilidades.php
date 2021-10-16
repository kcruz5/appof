<?php
	include("keyaction.php");
    $bodega = $_POST['bodega'];
    $fecha = $_POST['fecha'];
    $oc = 0.00;
    $descuento = 0.00;
    $costo = 0.00;
    $venta = 0.00;
    $utilidad=0.00;
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>Bodega</th>
							<th>Tipo Mov.</th>
							<th>Cliente</th>
                            <th>Fecha</th>
							<th>Total OC.</th>
							<th>Total Descto. OC</th>
                            <th>P. Costo</th>
                            <th>P. Venta</th>
                                 <th>Utilidad</th>
						</tr></thead>';

$query="Select * from (SELECT 
    ioe.idinBodega,
    ib.nombre as bodega,
    CONCAT('Orden de Compra No.', ' ', x.idinOCEnc) as tipo,
    ic.idinCte,
    ic.nombre as cliente,
    ioe.fechaIngreso,
    ioe.total AS total,
    ioe.descuento AS descuento,
    x.costo AS costo,
    x.venta - ioe.descuento AS venta,
   -- x.venta - x.costo as utilidad
   (x.venta - ioe.descuento) - x.costo as utilidad
FROM
    in_cliente ic
        INNER JOIN
    in_oc_enc ioe ON ic.idinCte = ioe.idinCliente
        INNER JOIN
    in_oc_mov iom ON ioe.idinOCEnc = iom.idinOCEnc
    inner join in_bodega ib on ioe.idinBodega = ib.idinBodega
        INNER JOIN
    (SELECT 
        ioe.idinBodega,
            ic.idinCte,
            ioe.idinOCEnc,
            ioe.fechaIngreso,
            SUM(iod.cantidad * ipp.precio_compra) AS costo,
         --   SUM(iod.cantidad * (CASE
         --       WHEN ioe.idinTipoOC = 2 THEN ipp.precioEspecial1
         --       WHEN ioe.idinTipoOC = 4 THEN ipp.precioEspecial2
         --       WHEN ioe.idinTipoOC = 5 THEN ipp.precioEspecial3
         --       WHEN ioe.idinTipoOC = 3 THEN 0
         --       ELSE ipp.precio_venta
         --   END)) AS venta
            
            SUM(iod.cantidad * IFNULL((CASE
             	WHEN (fecha_inicio <=ioe.fechaIngreso AND fecha_fin>ioe.fechaIngreso ) OR 
             		 (fecha_inicio<=ioe.fechaIngreso  AND fecha_fin IS NULL) THEN
               			(CASE WHEN ioe.idinTipoOC = 2 THEN ipp.precioEspecial1
                			  WHEN ioe.idinTipoOC = 4 THEN ipp.precioEspecial2
                			  WHEN ioe.idinTipoOC = 5 THEN ipp.precioEspecial3
                			  WHEN ioe.idinTipoOC = 3 THEN 0
                		 ELSE ipp.precio_venta
            			 END
            			) END
            		),iod.precio) ) as venta
    FROM
        in_cliente ic
    INNER JOIN in_oc_enc ioe ON ic.idinCte = ioe.idinCliente
    INNER JOIN in_oc_det iod ON iod.idinOCEnc = ioe.idinOCEnc
    INNER JOIN in_producto_precio ipp ON iod.idinProducto = ipp.idinProd
    INNER JOIN in_oc_mov iom ON ioe.idinOCEnc = iom.idinOCEnc
    WHERE ioe.idinBodega = case when '$bodega' = 0 then ioe.idinBodega else '$bodega' end 
and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end
and
        ipp.fecha_fin IS NULL
            AND iod.cantidad <> 0
            AND ioe.estado = 4
            AND ioe.idinTipoOC <>3 
    GROUP BY ioe.idinBodega , ic.idinCte , ioe.idinOCEnc,ioe.fechaIngreso) AS x ON ioe.idinBodega = x.idinBodega
        AND ioe.idinCliente = x.idinCte
        and ioe.idinOCEnc = x.idinOCEnc
        AND ioe.fechaIngreso = x.fechaIngreso
 WHERE ib.idinBodega = case when '$bodega' = 0 then ib.idinBodega else '$bodega' end
and case when '$fecha'='' then ioe.fechaIngreso =  ioe.fechaIngreso else ioe.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end     
union
SELECT ib.idinBodega,ib.nombre AS bodega, 'Salida por Desperdicio' AS tipo,0 as idinCte,'' as cliente, 
ime.fechaIngreso,0 as total, 0 as descuento, sum(imd.cantidad*ipp.precio_compra) AS costo,0 as venta, (-1)*sum(imd.cantidad*ipp.precio_compra)  as utidildad
FROM in_mov_enc ime
INNER JOIN in_mov_det imd ON ime.idinMovEnc = imd.idinMovEnc
INNER JOIN in_producto ip ON imd.idinProducto = ip.idinProd
INNER JOIN in_producto_precio ipp ON ip.idinProd= ipp.idinProd
INNER JOIN in_tipo_mov itm ON ime.idinTipoMov= itm.idinTipoMov
INNER JOIN in_bodega ib ON ime.idinBodega = ib.idinBodega
WHERE ib.idinBodega = case when '$bodega' = 0 then ib.idinBodega else '$bodega' end
and case when '$fecha'='' then ime.fechaIngreso =  ime.fechaIngreso else ime.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' end
and  ifnull(ipp.fecha_fin,'')='' 
AND ime.idinTipoMov IN (5)
GROUP BY ime.idinBodega, ime.fechaIngreso) as x ORDER BY x.fechaIngreso desc";
	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
            $oc = $oc + $row['total'];
            $descuento = $descuento + $row['descuento']; 
            $costo = $costo + $row['costo'];
            $venta = $venta + $row['venta'];
            $utilidad = $utilidad + $row['utilidad'];
            
    		$data .= '<tr>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
				<td>'.$row['fechaIngreso'].'</td>                
                <td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['costo'].'</td>
                <td>'.$row['venta'].'</td>
                <td>'.$row['utilidad'].'</td>
    		</tr>';
    	}
        $data .='<tfoot><td>Totales:</td>
        <td></td><td></td><td></td><td>Q. '.number_format($oc,2).'</td><td>Q. '.number_format($descuento,2).'</td><td>Q. '.number_format($costo,2).'</td><td>Q. '.number_format($venta,2).'</td><td>Q. '.number_format($utilidad,2).'</td></tr>
        </tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="9">No hay movimientos para el mes seleccionado!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>