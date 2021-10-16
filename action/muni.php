<?php
include("keyaction.php");

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    $id = $_POST['id'];
	$query = "select idcMunicipio, RTRIM(descripcion) as descripcion from c_municipio where idcdepto= '$id'";
    $data='';
    
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .="<option value='".$row['idcMunicipio']."'>".$row['descripcion']."</option>";
				
    	}
    echo $data;
}

?>