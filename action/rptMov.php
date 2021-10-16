<?php
	include("keyaction.php");
    $fecha = $_POST['fecha'];
    $bodega =$_POST['bodega'];
    
    $data = '<table class="table table-striped table-responsive"><thead>
						<tr>
							<th>No. Mov</th>
							<th>Fecha</th>
							<th>Bodega</th>
							<th>Tipo Movimiento</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>C. Entrada</th>
                            <th>C. Salida </th>
                            <th>UM</th>
                            <th>P. Compra</th>
                            <th>P. Venta</th>
                            <th>P. Esp. 1</th>
                            <th>P. Esp. 2</th>
                            <th>P. Esp. 3</th>
                            <th>Total</th>
						</tr></thead>';
    $query="select ime.idinMovEnc, ime.fechaIngreso, ib.nombre as bodega,ip.nombre as producto, ipc.nombre as categoria, itm.descripcion, case when itm.tipo ='E' then imd.cantidad else 0 end as ecant,
case when itm.tipo ='S' then imd.cantidad else 0 end as scant,imd.um,itm.tipo,
(case when ime.idinTipoMov in (1,2,5) then ipp.precio_compra
else 0 end) as precio_compra, (case when ime.idinTipoMov =4 then ipp.precio_venta
else 0 end) precio_venta,(case when ime.idinTipoMov =9 then ipp.precioEspecial1
else 0 end) precioEspecial1, (case when ime.idinTipoMov =11 then ipp.precioEspecial2
else 0 end) precioEspecial2, (case when ime.idinTipoMov =12 then ipp.precioEspecial3
else 0 end) precioEspecial3, 
(case when ime.idinTipoMov in (3,6,10) then 0
when ime.idinTipoMov = 9 then imd.cantidad * ipp.precioEspecial1
when ime.idinTipoMov = 11 then imd.cantidad * ipp.precioEspecial2
when ime.idinTipoMov = 12 then imd.cantidad * ipp.precioEspecial3
when ime.idinTipoMov in (1,2,5) then imd.cantidad * ipp.precio_compra
when ime.idinTipoMov = 4 then imd.cantidad * ipp.precio_venta end  ) as total,
ib.idinBodega, ime.idinTipoMov
from in_producto ip
inner join in_prod_categoria ipc on ip.idinProdCat = ipc.idinProdCat
inner join in_mov_det imd on ip.idinProd = imd.idinProducto
inner join in_mov_enc ime on imd.idinMovEnc = ime.idinMovEnc
inner join in_bodega ib on ime.idinBodega= ib.idinBodega
inner join in_tipo_mov itm on ime.idinTipoMov = itm.idinTipoMov
inner join in_producto_precio ipp on ip.idinProd = ipp.idinProd
where ifnull(fecha_fin,'')=''
and ib.idinBodega = (case when '$bodega' =0 then ib.idinBodega else '$bodega' end)
and case when '$fecha'='' then ime.fechaIngreso =  ime.fechaIngreso else ime.fechaIngreso  between CONCAT(SUBSTRING('".$fecha."', 1, 6),'01') and '".$fecha."' End
order by ime.fechaIngreso desc;";
$total=0;
	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
            $total = $total + $row['total'];
    		$data .= '<tr>
				<td>'.$row['idinMovEnc'].'</td>
				<td>'.$row['fechaIngreso'].'</td>
                <td>'.$row['bodega'].'</td>
                <td>'.$row['descripcion'].'</td>
				<td>'.$row['producto'].'</td>
                <td>'.$row['categoria'].'</td>
				<td>'.$row['ecant'].'</td>
				<td>'.$row['scant'].'</td>
                <td>'.$row['um'].'</td>
				<td>'.$row['precio_compra'].'</td>
				<td>'.$row['precio_venta'].'</td>
				<td>'.$row['precioEspecial1'].'</td>
				<td>'.$row['precioEspecial2'].'</td>  
				<td>'.$row['precioEspecial3'].'</td>                  
                <td>'.$row['total'].'</td>  
    		</tr>';
    	}
        $data .='<tfoot>						<tr>
							<th>No. Mov</th>
							<th>Fecha</th>
							<th>Bodega</th>
							<th>Tipo Movimiento</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>C. Entrada</th>
                            <th>C. Salida </th>
                            <th>UM</th>
                            <th>P. Compra</th>
                            <th>P. Venta</th>
                            <th>P. Esp. 1</th>
                            <th>P. Esp. 2</th>
                            <th>P. Esp. 3</th>
                            <th>Total</th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="15">No hay movimientos registrados!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>