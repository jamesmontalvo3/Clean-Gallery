<?php

class PDO_Connection {

	private $conn;
	private $host;
	private $dbname;
	private $username;
	private $password;
	private $driver;
	private $error_mode;

	public function __construct ( $conn_params ) {

		$this->driver   = $conn_params['driver'];
		$this->host     = $conn_params['host'];
		$this->dbname   = $conn_params['dbname'];
		$this->username = $conn_params['username'];
		$this->password = $conn_params['password'];

		$this->setErrorMode();
	}

	public function setErrorMode ($mode=false) {
		if ( ! $mode )
			$mode = PDO::ERRMODE_EXCEPTION;
		$this->error_mode = $mode;
	}

	private function getErrorMode () {
		return $this->error_mode;
	}

	public function connect () {

		try {
			$conn = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, $this->getErrorMode() );

			$this->conn = $conn;

		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}

	}

	public function conn() {
		return $this->conn;
	}

	public function closeConnection () {
		$this->conn = null;
	}


	/*public function prepare () {

		$stmt = $conn->prepare('SELECT * FROM myTable WHERE id = :id');
		$stmt->execute(array('id' => $id));
	 
		while($row = $stmt->fetch()) {
			print_r($row);
		}

	}
	*/

}