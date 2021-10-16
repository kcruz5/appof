<?php
	include("keyaction.php");
$filas =0;
	$data = '<table class="table table-striped table-responsive"><thead>
						<tr>
                            <th>Operacion</th>
							<th>No.</th>
							<th>Bodega</th>
							<th>Tipo</th>
							<th>Cliente</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Descuento</th>
                            <th>Saldo</th>
							<th></th>
						</tr></thead>';

	$query = "SELECT 'OC' as tipop, ioe.idinOCEnc as numoc, ib.nombre as bodega, ito.descripcion as tipo,
ic.nombre as cliente, ioe.fechaIngreso, ieo.descripcion as estado, total, descuento,(total-descuento)-abonado as saldo,ioe.idinBodega,ioe.estado as idEst FROM in_oc_enc ioe
inner join in_bodega ib on ib.idinBodega = ioe.idinBodega
inner join in_tipo_oc ito on ito.idinTipoOc = ioe.idinTipoOC
inner join in_cliente ic on ic.idinCte = ioe.idinCliente
inner join in_estado_oc ieo on ieo.idinEstadoOC = ioe.estado
where ioe.estado < 4";

	if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result) > 0)
    {
        $filas = 1;
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['numoc'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>          
                    <a onclick="detail('.$row['numoc'].','.$row['idinBodega'].','.$row['idEst'].','.$row['descuento'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>&nbsp;
                    <a onclick="Abono('.$row['numoc'].')" class="pay" title="Abonar"><i class="fas fa-hand-holding-usd"></i>  </a> &nbsp;            
                    <a onclick="Autoriza('.$row['numoc'].')" class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaOC('.$row['numoc'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }

    ///// Inventario

$query = "select 'Inventario' as tipop,iie.idinInventarioEnc as num, ib.nombre as bodega, '' as tipo, '' as cliente, iie.fechaIngreso, ieo.descripcion as estado,'' as total, '' as descuento, '' as saldo, iie.idinBodega, iie.estado as idEst from in_inventario_enc iie
inner join in_bodega ib on ib.idinBodega = iie.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp = iie.estado
where iie.estado = 1";

	if (!$result2 = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result2) > 0)
    {
        $filas = 2;
    	while($row = mysqli_fetch_assoc($result2))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>                
                <td>'.$row['saldo'].'</td>
				<td>            
                    <a onclick="detailIn('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>  &nbsp;
                    <a onclick="AutorizaIn('.$row['num'].')" class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaIn('.$row['num'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }
    //// Inventario

 ///// traslado

$query = "select 'Traslado' as tipop,ite.idinTrasladoEnc as num, ib.nombre as bodega,  CONCAT('A:', ' ', ibt.nombre)  as tipo, '' as cliente, 
ite.fechaIngreso, ieo.descripcion as estado,'' as total,'' as descuento, '' as saldo, ite.idinBodega, ite.estado as idEst from in_traslado_enc ite
inner join in_bodega ib on ib.idinBodega = ite.idinBodega
inner join in_bodega ibt on ibt.idinBodega = ite.idinBodegaDest
inner join in_estado_op ieo on ieo.idinEstadoOp = ite.estado
where ite.estado = 1
";

	if (!$result3 = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result3) > 0)
    {
        $filas =3;
    	while($row = mysqli_fetch_assoc($result3))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>            
                    <a onclick="detailTr('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>  &nbsp;
                    <a onclick="AutorizaTr('.$row['num'].','.$row['idinBodega'].')" class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaTr('.$row['num'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }
    //// traslado


 ///// entrada

$query = "select 'Entrada' as tipop,iee.idinEbodEnc as num, ib.nombre as bodega,  ''  as tipo, '' as cliente, 
iee.fechaIngreso, ieo.descripcion as estado,'' as total,'' as descuento, '' as saldo, iee.idinBodega, iee.estado as idEst from in_ebod_enc iee
inner join in_bodega ib on ib.idinBodega = iee.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp = iee.estado
where iee.estado = 1
";

	if (!$result4 = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result4) > 0)
    {
        $filas = 4;
    	while($row = mysqli_fetch_assoc($result4))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                  <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>            
                    <a onclick="detailEb('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>  &nbsp;
                    <a onclick="AutorizaEb('.$row['num'].','.$row['idinBodega'].')" class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaEb('.$row['num'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }
    //// entrada

 ///// desperdicio

$query = "select 'Desperdicio' as tipop,ide.idinDespEnc as num, ib.nombre as bodega,  ''  as tipo, '' as cliente, 
ide.fechaIngreso, ieo.descripcion as estado,'' as total,'' as descuento, '' as saldo, ide.idinBodega, ide.estado as idEst from in_desperdicio_enc ide
inner join in_bodega ib on ib.idinBodega = ide.idinBodega
inner join in_estado_op ieo on ieo.idinEstadoOp = ide.estado
where ide.estado = 1
";

	if (!$result5 = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result5) > 0)
    {
        $filas = 5;
    	while($row = mysqli_fetch_assoc($result5))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>            
                    <a onclick="detailDe('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>  &nbsp;
                    <a onclick="AutorizaDe('.$row['num'].','.$row['idinBodega'].')"  class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaDe('.$row['num'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }
    //// desperdicio

 ///// ajuste

$query = "SELECT CONCAT('Ajuste ',ita.descripcion) AS tipop, iae.idinAjusteEnc AS num, ib.nombre AS bodega,
'' AS tipo, '' AS cliente, iae.fechaIngreso, ieo.descripcion AS estado, '' AS total,'' AS descuento,
'' AS saldo, iae.idinBodega, iae.estado AS idEst, iae.idinTipoAjuste as tipoa FROM in_ajuste_enc iae
INNER JOIN in_tipo_ajuste ita ON iae.idinTipoAjuste = ita.idinTipoAjuste
INNER JOIN in_bodega ib ON iae.idinBodega= ib.idinBodega
INNER JOIN in_estado_op ieo ON iae.estado=  ieo.idinEstadoOp
where iae.estado = 1
";

	if (!$result3 = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
  
    if(mysqli_num_rows($result3) > 0)
    {
        $filas =3;
    	while($row = mysqli_fetch_assoc($result3))
    	{
    		$data .= '<tr>
                <td>'.$row['tipop'].'</td>
				<td>'.$row['num'].'</td>
				<td>'.$row['bodega'].'</td>
				<td>'.$row['tipo'].'</td>
                <td>'.$row['cliente'].'</td>
                <td>'.$row['fechaIngreso'].'</td>
				<td>'.$row['estado'].'</td>
				<td>'.$row['total'].'</td>
                <td>'.$row['descuento'].'</td>
                <td>'.$row['saldo'].'</td>
				<td>            
                    <a onclick="detailAj('.$row['num'].','.$row['idinBodega'].','.$row['idEst'].')" class="detail" title="Detalle"><i class="fas fa-list-ul"></i> </a>  &nbsp;
                    <a onclick="AutorizaAj('.$row['num'].','.$row['idinBodega'].','.$row['tipoa'].')" class="unlock" title="Autorizar"><i class="fas fa-check-circle"></i></a>  &nbsp;
                    <a onclick="AnulaAj('.$row['num'].')" class="lock" title="Anular"><i class="fas fa-trash-alt"></i></a>  
				</td>
    		</tr>';
    	}

    }
    //// ajuste

    if ($filas !=0){
                $data .='<tfoot><tr>
                <th>Operacion</th>
				        <th>No.</th>
						<th>Bodega</th>
						<th>Tipo</th>
						<th>Cliente</th>
                        <th>Fecha Ingreso</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Descuento</th>
                        <th>Saldo</th>
						<th></th>
						</tr></tfoot>';
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="10">No hay operaciones pendientes!</td></tr>';
    }
    
    $data .= '</table>';

    echo $data;
?>