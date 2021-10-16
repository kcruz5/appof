<?php
session_start();

class dbObj{

    var $servername = "appinventarioof-server.mysql.database.azure.com";
	var $username = "tktxtqgbdd";
	var $password = "XYQDC65J585ZQ5N0$";
    var $dbname = "db_a44c8c_dbiof";
    
	var $conn;
	function getConnstring() {
		$con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Error de conexión: " . mysqli_connect_error());

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Error de conexión: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
        
		return $this->conn;
	}
}
?>