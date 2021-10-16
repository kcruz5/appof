<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistema de Inventario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="components/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/stack-interface.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/socicon.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/flickity.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/jquery.steps.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="components/css/custom.css" rel="stylesheet" type="text/css" media="all" />        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <script type="text/javascript" charset="utf8" src="components/js/jquery-2.0.3.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="components/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="components/js/login.js"></script> 
    </head>
<body class=" " style="background-color:#22008A;" onload="nobackbutton();">
   
     
        <div class="main-container">
            <section class="height-100 imagebg text-center" >
                <div class="container pos-vertical-center">
                    <div classe="row">
                    <div class="col-md-7 col-lg-5">
                        <img src="components/img/logo.jpg" class="img-thumbnail">
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-lg-5">
                            <h2>Sistema de Inventario Outlet Fitness</h2>
                            <p class="lead">
                                Por favor ingresa tus credenciales para continuar.
                            </p>
                            <div class="alert alert-danger" role="alert" id="error" style="display: none;">Alerta</div>
                            <form id="login-form" name="login_form" role="form" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="" required autofocus>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña">
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn--primary type--uppercase" type="submit" name="login-submit" id="login-submit"><span class="spinner"><i class="icon-spin icon-refresh" id="spinner"></i></span>Ingresar</button>
                                    </div>
                                </div>
                                <!--end of row-->
                            </form>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </section>
        </div>
        <!--<div class="loader"></div>-->

        <script src="components/js/scripts.js"></script>
    </body>
</html>

<script type="text/javascript">    	
function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}
</script>