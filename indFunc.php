<?php
include_once("action/key.php");
$db = new dbObj();
$connString =  $db->getConnstring();

$params = $_REQUEST;
$action = $params['action'] !='' ? $params['action'] : '';
$ingCls = new Ingreso($connString);

switch($action) {
 case 'login':
	$ingCls->login();
 break;
 case 'logout':
	$ingCls->logout();
 break;
 default:
 return;
}


class Ingreso {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	function login() {
		if(isset($_POST['login-submit'])) {
			$user = trim($_POST['usuario']);
			$user_password = trim($_POST['contrasena']);
			$sql = "SELECT * FROM c_usuario WHERE usuario='".$user."' and password='". $user_password."' and estado=1";
			$resultset = mysqli_query($this->conn, $sql) or die("Error de base de datos:". mysqli_error($this->conn));
			$row = mysqli_fetch_array($resultset);
            if ($row>0){
                if($user_password == $row['password']){
				echo "1";
				$_SESSION['usuario'] = $row['usuario'];
                $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['cnn']= $this->conn;
			     } 
            }
			else {
                echo "Usuario no válido."; 
            }
		}
	}
	function logout() {
		unset($_SESSION['usuario']);
		if(session_destroy()) {
			header("Location: index.php");
		}
	}
}
?>
	