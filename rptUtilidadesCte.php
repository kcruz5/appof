<?php
    session_start();

    class clsMenu{
        function menubar() {
            include("action/keyaction.php");
        $str= " select cupe.idcPerfil, cpm.idcMenu, cm.descripcion,cm.ruta,cm.sub_sn,cm.fa_icon from c_usr_perfil_empresa cupe 
                inner join c_usuario cu on cu.idcUsuario= cupe.idcUsuario
                inner join c_perfil_menu cpm on cpm.idcPerfil= cupe.idcPerfil
                inner join c_menu cm on cm.idcMenu = cpm.idcMenu
                where cu.usuario='".$_SESSION['usuario'] ."'
                and cu.estado=1
                and cpm.estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            if ($row["sub_sn"]==0){
                echo "<li class='nav-item '>
                    <a class='nav-link' href='".$row["ruta"]."'>
                    <i class='".$row["fa_icon"]."'></i>
                    <span>".$row["descripcion"]."</span>
                    </a></li>";
	       } else {
                echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='".$row["ruta"]."' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='".$row["fa_icon"]."'></i>
                    <span>".$row["descripcion"]."</span>
                    </a>
                    <div class='dropdown-menu' aria-labelledby='pagesDropdown'> ";
                
                $str2=" select co.descripcion, co.ruta from c_opcion co
                        inner join c_menu_opcion cmp on cmp.idcOpcion=co.idcOpcion
                        where cmp.idcMenu=".$row["idcMenu"]." and cmp.estado= 1 and co.estado=1";
                    
                $resultset2=mysqli_query($con, $str2) or die("Error de base de datos:". mysqli_error($con));
		      
                while (	$row2 = mysqli_fetch_array($resultset2, MYSQLI_ASSOC)) {
                    echo "<a class='dropdown-item' href='".$row2["ruta"]."'>".$row2["descripcion"]."</a>";
                }
          
                echo"</div></li>";
            }
        }
    }
        function notificacion(){
        include("action/keyaction.php");
        $str= "select cupe.idcPerfil  from c_usr_perfil_empresa cupe 
                inner join c_usuario cu on cu.idcUsuario= cupe.idcUsuario
                where cu.usuario='".$_SESSION['usuario'] ."'
                and cu.estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            if ($row["idcPerfil"]==1){
                // notifica
                $str2="select (select count(*) from in_desperdicio_enc ide where ide.estado = 1)+(select count(*) from in_ebod_enc iee where iee.estado = 1)
+(select count(*) from in_traslado_enc ite where ite.estado = 1) +(select count(*) from in_inventario_enc iie where iie.estado = 1)
+ (SELECT count(*) FROM in_oc_enc ioe where ioe.estado < 4)+
(select count(*) from in_ajuste_enc where estado=1) as notificacion";
                $resultset2=mysqli_query($con, $str2) or die("Error de base de datos:". mysqli_error($con));
		      
                while (	$row2 = mysqli_fetch_array($resultset2, MYSQLI_ASSOC)) {
                    echo "<li class='nav-item dropdown no-arrow mx-1'>
          <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-bell fa-fw'></i>
            <span class='badge badge-danger'>".$row2['notificacion']."</span></a><div class='dropdown-menu dropdown-menu-right' aria-labelledby='alertsDropdown'><a class='dropdown-item' href='notifica.php'>Notificaciones</a></div></li>";
                }
	       }
        }
    }       
        function bodega(){
        include("action/keyaction.php");
        $str= "select idinbodega, nombre from in_bodega where estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            echo "<option value='".$row["idinbodega"]."'>".$row["nombre"]."</option>";
	    } 
             
    }    
        function cliente(){
        include("action/keyaction.php");
        $str= "select idinCte, nombre from in_cliente where estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            echo "<option value='".$row["idinCte"]."'>".$row["nombre"]."</option>";
	       }
        }
    }

?>
<!DOCTYPE html>
<html>

  <head>
<style type="text/css">
    table.table td a.detail{color: #0000FF;}
</style>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Inventario</title>

    <link href="components/dash/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="components/dash/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="components/dash/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="components/dash/css/sb-admin.css" rel="stylesheet">
  </head>

  <body id="page-top" onload="nobackbutton();">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <a class="navbar-brand mr-1" href="main.php">Sistema de Inventario</a>
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
      <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        </div>
      <ul class="navbar-nav ml-auto ml-md-0">
        <?php
          $db = new clsMenu();
          $db->notificacion();
?>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw" ></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#"> <?php echo $_SESSION["nombre"]; ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Cerrar Sesión</a>
          </div>
        </li>
      </ul>
    </nav>

    <div id="wrapper">
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="main.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel Principal</span>
          </a>
        </li>
          
<?php
          $db = new clsMenu();
          $db->menubar();
?>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Reporte Utilidades Cliente</a>
            </li>
          </ol>

            <div class="da">
          <div class="row">
              <div class="col-sm-3">
              <div class="pull-right"><div class="input-group">
                <label for="fecha">Mes/Año:&nbsp;</label><input type="text" id="fecha" >
                  </div></div>
            </div><br><br>   
  <div class="col-sm-3">
      <div class="pull-right">
          <div class="input-group">							 
								<select class="form-control"  id="bodega" name="bodega" title="Bodega">
                                <option value='0'>Todas las bodegas</option>
                                    <?php $db = new clsMenu(); $db->bodega();?>
                                </select>
							</div>
      </div> </div>              <br><br>  
                       <div class="col-sm-3">
              <div class="pull-right">
          <div class="input-group">							 
								<select class="form-control"  id="cliente" name="cliente" title="Cliente">
                                <option value='0'>Todos los clientes</option>
                                    <?php $db = new clsMenu(); $db->cliente();?>
                                </select>
							</div>
              </div>
            </div><br><br>  
                       <div class="col-sm-3">
              <div class="pull-right">
                  <div class="search-box">
                      <div class="input-group">								
                          <button class="btn btn-success" onclick="reporte()" title="Generar Reporte"><i class="fas fa-chart-line"></i></button>	&nbsp;						
                          <button type="button" class="btn btn-warning" onclick="HTMLtoPDF()" title="Imprimir"><i class="fas fa-print"></i></button>
                      </div>
                 </div>
              </div>
            </div>
          </div>
          <br>
          <div id="HTMLtoPDF">
              <div class="row">
                <div class="col-md-12">	
                    <div id="records_content"></div>
                </div></div>
            </div>
            
        </div>
            
        </div>

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
               <!--<span>Copyright © <a href:"www.sycigt.com">SYCI</a> <?php echo date("Y"); ?></span> -->
            </div>
          </div>
        </footer>

      </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sistema de Inventario</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Deseas cerrar la sesión actual?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="index.php">Cerrar Sesión</a>
          </div>
        </div>
      </div>
    </div>
          
    <script src="components/dash/jquery/jquery.min.js"></script>
    <script src="components/dash/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="components/dash/jquery-easing/jquery.easing.min.js"></script>
    <script src="components/dash/chart.js/Chart.min.js"></script>
    <script src="components/dash/datatables/jquery.dataTables.js"></script>
    <script src="components/dash/datatables/dataTables.bootstrap4.js"></script>
    <script src="components/js/sb-admin.min.js"></script>
    <script src="components/js/demo/datatables-demo.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" >
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>      
    <script src="components/js/jquery.mtz.monthpicker.js"></script>
    <script src="class/rptUtilidadesCte.js"></script>
	<script src="components/js/jspdf.js"></script>

	<script src="components/js/pdfFromHTML.js"></script>      
  </body>

</html>

<script type="text/javascript">    	
function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}
</script>
<script>
    toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
</script>    
<script>
$('#fecha').monthpicker({pattern: 'mm/yyyy', 
    selectedYear: 2020,
    startYear: 2019,
    finalYear: 2050,});
	var options = {
    selectedYear: 2020,
    startYear: 2019,
    finalYear: 2050,
    openOnFocus: false // Let's now use a button to show the widget
};

</script>