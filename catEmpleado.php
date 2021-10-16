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
              <a href="main.php">Catálogos</a>
            </li>
            <li class="breadcrumb-item active">Empleados</li>
          </ol>
             
            
        <!--crud-->
            <div class="da">
  <div class="row">
    <div class="col-sm-6">
      <div class="pull-right">
          <div class="search-box">
							<div class="input-group">								
								<input type="text" id="search" class="form-control" placeholder="Buscar por Nombre">
                                <span class="input-group-addon"><i class="fas fa-search"></i></span>
							</div>
         </div>
      </div>
    </div>
      <br><br>
      <div class="col-sm-6">
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#add_modal">Agregar</button>
      </div>
    </div>
  </div>
  <br>
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
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title">Agregar Empleado</h4>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">×</span>
            </button>
            </div>
         
            <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre" class="control-label">Nombre:</label>
                    <input type="text" value="" class="form-control" id="nombre" name="nombre" required="true"/>
                  </div> 
                  <div class="form-group">
                    <label for="puesto" class="control-label">Puesto:</label>
                    <input type="text" value="" class="form-control" id="puesto" name="puesto" required="true"/>
                  </div>                 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_add" class="btn btn-primary" onclick="return validaCampos();">Guardar</button>
            </div>
        </div>
    </div>
</div>
    <div class="modal" id="update_modal" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title">Editar Empleado</h4>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                    <label for="nombre" class="control-label">Nombre:</label>
                    <input type="text" value="" class="form-control" id="update_nombre" name="update_nombre" required="true"/>
                  </div> 
                  <div class="form-group">
                    <label for="puesto" class="control-label">Puesto:</label>
                    <input type="text" value="" class="form-control" id="update_puesto" name="update_puesto" required="true"/>
                  </div>                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="updateValida()">Actualizar</button>
                <input type="hidden" id="hidden_id">
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
    <script src="class/catEmpleado.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" >
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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