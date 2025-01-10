<?php
namespace DB;

class DBAccess {

	private const HOST_DB = "localhost";
	#private const HOST_DB = "tecweb.studenti.math.unipd.it";
	private const DATABASE_NAME = "fbellon";
	private const USERNAME = "fbellon";
	private const PASSWORD = "lahy8Fielod8eyoo";

	private $connection;

	public function openDBConnection() {

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

		if(mysqli_connect_errno()) {               //funzione per verificare se c'e' stato un errore nella connessione
			return false;
		} else {
			return true;
		}
	}

	public function closeConnection() {
		mysqli_close($this->connection);
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