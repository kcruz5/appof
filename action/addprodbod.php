<?php
	if(isset($_POST['bodega']) && isset($_POST['producto']))
	{
		include("keyaction.php");
        session_start();
		$bodega = $_POST['bodega'];
        $producto = $_POST['producto'];

        if($producto != 0 ){
            $query = "INSERT INTO in_prod_bodega(idinbodega,idinProd,fecha_asigna,estado) VALUES('$bodega','$producto',NOW(), 1);";
            $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES     ('prodbod','I','".$_SESSION["nombre"]."','VALUES(".$bodega.",".$producto."',NOW());";
        } else {
            $query="INSERT INTO in_prod_bodega(idinbodega,idinProd,fecha_asigna,estado)  select '$bodega', idinProd, NOW(), 1 from in_producto where idinProd not in (select idinProd from in_prod_bodega where idinbodega='$bodega') and estado=1;";
            $query .= "INSERT INTO in_log (pantalla, tipo, usuario, descripcion,fecha) VALUES ('prodbod','I','".$_SESSION["nombre"]."','Todos a bodega".$bodega."',NOW());";
        }
        
 		if (!$result = mysqli_multi_query($con, $query)) {
            exit(mysqli_error($con));
        }
        
	    echo "1 Record Added!";
	}
?>