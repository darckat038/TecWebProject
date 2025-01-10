<?php
namespace DB;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DBConnection {
	#private const HOST_DB = "tecweb.studenti.math.unipd.it";
	private const HOST = "db";
	private const NAME = "LuzzAutoDB";
	private const USER = "root";
	private const PASS = "root";

	private $connection;

	public function __construct() {
		try {
			$this->connection = mysqli_connect(self::HOST, self::USER, self::PASS, self::NAME);
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function getConnection() {
		if (!$this->connection->connect_errno)
			return $this->connection;
	}

	public function closeConnection() {
		if (!$this->connection->connect_errno)
			$this->connection->close();
	}



	// FUNZIONE PER RICAVARE I VEICOLI CON FILTRI APPLICATI PRESENTI NEL DB
	public function getFilteredVehicles() {
		$result = array();
		//DA INSERIRE FILTRI
		return $result;
	}

	//FUNZIONE PER RICAVARE TUTTI I VEICOLI PRESENTI NEL DB
	public function getAllVehicles() {
		$query = "SELECT * FROM Veicolo ORDER BY ID ASC;";
		
		$queryRes = mysqli_query($this->connection, $query); //or die("Errore in openDBConnection: " . mysqli_error($this->connection));

		if(mysqli_num_rows($queryRes) == 0) {
			return null;
		} else {
			$result = array();
			while($row = mysqli_fetch_assoc($queryRes)) {
				array_push($result, $row);
			}

			$queryRes->free();
			return $result;
		}
	}

	//FUNZIONE PER INSERIRE NUOVO VEICOLO IN VEICOLI NEL DB
	public function insertNewVehicle($marca, $modello, $anno, $colore, $alimentazione, $cambio, $trazione, $CVpotenza, $KGpeso, $neoP, $nPosti, $condizione, $chilometraggio) {
		
		$queryInsert = "INSERT INTO Veicolo(marca ,modello, anno, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, condizione, chilometraggio) 
						VALUES (\"$marca\", \"$modello\", \"$anno\", \"$colore\", \"$alimentazione\", \"$cambio\", \"$trazione\", \"$CVpotenza\", \"$KGpeso\", 
						\"$neoP\", \"$nPosti\", \"$condizione\", \"$chilometraggio\")";
						
		$queryRes = mysqli_query($this->connection, $queryInsert) or die(mysqli_error($this->connection));

		if(mysqli_affected_rows($this->connection) > 0) {
			$queryRes->free();
		}
		
	}

	
}


?>