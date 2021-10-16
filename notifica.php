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
    function tipopago(){
        include("action/keyaction.php");
        $str= "select idinTipoPago, descripcion from in_tipo_pago where estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            echo "<option value='".$row["idinTipoPago"]."'>".$row["descripcion"]."</option>";
	    } 
    }
    function empleado(){
        include("action/keyaction.php");
        $str= "select idinEmpleado,nombre from in_empleado where estado=1";
		$resultset = mysqli_query($con, $str) or die("Error de base de datos:". mysqli_error($con));
		while (	$row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
            echo "<option value='".$row["idinEmpleado"]."'>".$row["nombre"]."</option>";
	    } 
    }
}
?>
<!DOCTYPE html>
<html>

  <head> 
<style type="text/css">
	.search-box {position: relative;float: right;}
	.search-box .input-group {min-width: 300px;position: absolute;right: 0;}
	.search-box .input-group-addon, .search-box input {border-color: #ddd;border-radius: 0;}	
    .search-box input {height: 34px;padding-right: 35px;background: #f4fcfd;border: none;border-radius: 2px !important;}
	.search-box input:focus {background: #fff;}
	.search-box input::placeholder {font-style: italic;}
	.search-box .input-group-addon {min-width: 35px;border: none;background: transparent;position: absolute;right: 0;z-index: 9;padding: 6px 0;}
    .search-box i {color: #a0a5b1;position: relative;top: 2px;}
	table.table td a.unlock{color: #03A9F4;}
    table.table td a.edit {color: #FFC107;}
    table.table td a.lock{color: #E34724;}
    table.table td a.pay{color: #39AD1B;}
    table {border-collapse: collapse;table-layout: fixed; width: 100%;}
    table td, th {text-align: center;border: 1px solid #ddd;padding: 2px 5px;font-size: 16px;height: 40px;}
    table th { background-color: #f4f4f4; }
    table th.title { }
    table tr {width: 100%;background-color: #fff;}
    table td { text-overflow: ellipsis; }
    table td.edit {cursor: pointer;}
    
    td.edit input.editcell {font-size: 16px;font-weight: normal;text-align: center;background: white;border: 1px solid #DDD;border-radius: 5px;box-shadow: 0 0 5px #DDD inset;color: #666;outline: none; width: 82%;height: 40px;line-height: 40px;margin: 5px;padding: 2px 5px;}
    td.edit input.editcell::-webkit-input-placeholder { /* WebKit browsers */ color: #eee;}
    td.edit input.editcell:-moz-placeholder { /* Mozilla Firefox 4 to 18 */ color: #eee; opacity: 1;}
    td.edit input.editcell::-moz-placeholder { /* Mozilla Firefox 19+ */ color: #eee; opacity: 1;}
    td.edit input.editcell:-ms-input-placeholder { /* Internet Explorer 10+ */ color: #eee;}
    td.visible { display:none; }
    td.edit input.error { border: 1px solid red; }
    table td.money { /*min-width: 330px;*/}
    table td.money:before { content: 'Q. '; }
    table td.remove { width: 30px; }
    table td.remove button {font-size: 9px;  font-weight: bold; color: red;height: 26px; width: 26px;}        
</style>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Inventario</title>
    <link href="components/dash/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="components/dash/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="components/dash/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="components/dash/css/sb-admin.css" rel="stylesheet">
    <link href="components/dist/jquery.bootgrid.css" rel="stylesheet">
      
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
              <a href="main.php">Notificaciones</a>
            </li>
          </ol>
             
            
        <!--crud-->
            <div class="da">
 <div class="row">
    <div class="col-md-12">
<table id="data"  class="table table-striped table-responsive">
        </table>
  </div>
</div>                 
               <div class="col-sm-4"><div id="titulo"></div></div>   <div class="col-sm-2">
      <div class="pull-right">
           <button id="confirm" name="confirm" class="btn btn-success btn-sm" title="Actualizar Orden de Compra" onclick="ConfirmRecords()"><i class="fas fa-clipboard-check"></i></button>
          <button id="confirmIn" name="confirmIn" class="btn btn-success btn-sm" title="Actualizar Inventario" onclick="ConfirmRecordsIn()"><i class="fas fa-clipboard-check"></i></button>
          <button id="confirmEb" name="confirmEb" class="btn btn-success btn-sm" title="Actualizar Entrada a Bodega" onclick="ConfirmRecordsEb()"><i class="fas fa-clipboard-check"></i></button>
          <button id="confirmDe" name="confirmDe" class="btn btn-success btn-sm" title="Actualizar Salida por Desperdicio" onclick="ConfirmRecordsDe()"><i class="fas fa-clipboard-check"></i></button>
          <button id="confirmTr" name="confirmTr" class="btn btn-success btn-sm" title="Actualizar Salida por Traslado" onclick="ConfirmRecordsTr()"><i class="fas fa-clipboard-check"></i></button>
           <button id="confirmAj" name="confirmAj" class="btn btn-success btn-sm" title="Actualizar Ajuste de Inventario" onclick="ConfirmRecordsAj()"><i class="fas fa-clipboard-check"></i></button>
          <button id="exit" name="exit" class="btn btn-danger btn-sm" title="Salir" onclick="exit()"><i class="fas fa-door-open"></i></button>
      </div>
    </div>             
  <div class="row">
    <div class="col-md-12">	
      <div id="records_content">
    </div>
  </div>
</div>
            		

        
        </div>
            <!--crud-->
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

    <!-- Modals -->
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
    <div class="modal" id="abono_modal" tabindex="-1" role="dialog">
		   <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title">Abono a orden de Compra</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">×</span>
            </button>
            </div>
         
            <div class="modal-body">
                <div class="form-group">							 
				    <select class="form-control"  id="tipopago" name="tipopago" title="Tipo Pago">
                            <?php $db = new clsMenu(); $db->tipopago();?>
                    </select>
				</div>
                  <div class="form-group">
                    <label for="monto" class="control-label">Monto:</label>
                    <input type="text" value="" class="form-control" id="monto" name="monto"/>
                  </div>     
                 <div class="form-group">
                    <label for="banco" class="control-label">Banco:</label>
                    <input type="text" value="" class="form-control" id="banco" name="banco"/>
                  </div>  
                 <div class="form-group">
                    <label for="numero" class="control-label">No. Transacción / Depósito:</label>
                    <input type="text" value="" class="form-control" id="numero" name="numero"/>
                  </div>  
                 <div class="form-group">
                    <label for="empleado" class="control-label">Empleado:</label>
                     <select class="form-control"  id="empleado" name="empleado">
                            <?php $db = new clsMenu(); $db->empleado();?>
                    </select>
                  </div>   <div class="form-group">
                        <label for="nota" class="control-label">Nota:</label>
                        <input type="text" value="" class="form-control" id="nota" name="nota"/>
                      </div>  
            </div>
            <div class="modal-footer">
                <div id="saldo"> </div>
                    <br>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_add" class="btn btn-primary" onclick="return pay();">Guardar</button>
                            <input type="hidden" id="hidden_id">
            </div>
        </div>
    </div>
	</div>  
      
    <script src="components/dash/jquery/jquery.min.js"></script>
    <script src="components/dash/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="components/dash/jquery-easing/jquery.easing.min.js"></script>
    <script src="components/js/sb-admin.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" >
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript"  src="class/table.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="class/notifica.js"></script>
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
    
//importamos configuraciones de toastr
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