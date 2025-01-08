<?php
namespace DB;

class DBAccess {

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "";
	private const USERNAME = "";
	private const PASSWORD = "";

	private $connection;

	public function openDBConnection() {

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}


	public function getList() {

	}

	public function insertNewElement($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti, $riconoscimenti, $note) {

		
	}

	
}


?>