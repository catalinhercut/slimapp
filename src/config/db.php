<?php 
class db {
	//Properties
	private $dbhost = '127.0.0.1';
	private $dbuser = 'root';
	private $dbpass = '123456';
	private $dbname = 'rent';
	// private $dbtable = 'customers';

	//Connect
	public function connect(){
		$mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname;";
		$dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $dbConnection;
	}

	//Check if table exists
	public function checkTable($dbTable){
		if ($result = $mysqli->query("SHOW TABLES LIKE '".$dbTable."'")) {
		    if($result->num_rows == 1) {
		        echo "Table exists";
		    }
		}
		else {
		    echo "Table does not exist";
		}
	}
}