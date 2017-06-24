<?php 
class db {
	//Properties
	private $dbhost = '0.0.0.0';
	private $dbuser = 'root';
	private $dbpass = '123456';
	private $dbname = 'slimapp';
	private $dbtable = 'customers';

	//Connect
	public function connect(){
		$mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname;";
		$dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $dbConnection;
	}
}