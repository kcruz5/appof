<?php
include("keyaction.php");

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $id = $_POST['id'];

    $query = "select cu.idcUsuario, nombre,usuario, password as contrasenia, cupe.idcPerfil as perfil, cu.estado from c_usuario cu
inner join c_usr_perfil_empresa cupe on cu.idcUsuario=cupe.idcUsuario
where cu.idcUsuario= '$id'";
    
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    
    $response = array();
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Datos no encontrados!";
    }
    // display JSON data
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Solicitud inválida!";
}
?>