<?php
namespace DB;

use Exception;

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

	//FUNZIONE DI REGISTRAZIONE DI UN UTENTE NEL DB
	public function registerUser($username, $password, $nome, $cognome, $dataNascita) {

		$queryControllo = "SELECT * FROM Utente WHERE username = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("s", $username);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$numRows = count($rows);

		if($numRows != 0){
			return -1;
		}

		// Preparazione della query SQL con placeholder
		$query = "INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES (?, ?, ?, ?, ?)";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri ("sssss" = 5 stringhe)
		$stmt->bind_param("sssss", $username, $password, $nome, $cognome, $dataNascita);

		// Esecuzione della query
		$result = $stmt->execute();

		// Controllo del risultato
		if ($result) {
			return 1;
		} else {
			return 0;
		}
			
	}

	//FUNZIONE DI LOGIN DI UN UTENTE
	public function loginUser($username, $password) {

		$queryControllo = "SELECT username, password FROM Utente WHERE username = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("s", $username);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$numRows = count($rows);

		if($numRows == 0){
			return -1;
		}
		else{
			if(password_verify($password, $rows[0]['password'])){
				return 1;
			}
			else{
				return 0;
			}
		}
			
	}

	// FUNZIONE PER RICAVARE I VEICOLI CON FILTRI APPLICATI PRESENTI NEL DB
	/*
	* Uso array associativo params dove metto i vari valori. Se valore vuoto, non lo setto in params
	*/
	public function getFilteredVehicles($params) {

		$query = "SELECT * FROM Veicolo";

		$result = array();
		//DA INSERIRE FILTRI

		// Se params non è vuoto, aggiungo clausola WHERE
		if(!empty($params)) {
			$query .= " WHERE";

			// Faccio controllo per ogni parametro auto

			if(isset($params["marca"])) {
				$query .= " marca LIKE %?% AND";
			}

			if(isset($params["modello"])) {
				$query .= " modello LIKE %?% AND";
			}

			if(isset($params["anno"])) {
				$query .= " anno = %?% AND";
			}

			if(isset($params["colore"])) {
				$query .= " colore LIKE %?% AND";
			}

			if(isset($params["alimentazione"])) {
				$query .= " alimentazione LIKE %?% AND";
			}

			if(isset($params["cambio"])) {
				$query .= " cambio LIKE %?% AND";
			}

			if(isset($params["trazione"])) {
				$query .= " trazione LIKE %?% AND";
			}

			if(isset($params["potenzaMin"])) {
				$query .= " potenza >= ? AND";
			}

			if(isset($params["potenzaMax"])) {
				$query .= " potenza <= ? AND";
			}

			if(isset($params["pesoMin"])) {
				$query .= " peso >= ? AND";
			}

			if(isset($params["pesoMax"])) {
				$query .= " peso <= ? AND";
			}

			if(isset($params["neopatentati"])) {
				$query .= " neopatentati = ? AND";
			}

			if(isset($params["posti"])) {
				$query .= " posti = ? AND";
			}

			if(isset($params["condizione"])) {
				$query .= " condizione LIKE %?% AND";
			}

			if(isset($params["prezzoMax"])) {
				$query .= " prezzo <= ? AND";
			}

			if(isset($params["chilometraggio"])) {
				$query .= " posti <= ? AND";
			}

			//rimuovo ULTIMO AND dalla stringa
			$query = substr($query, 0, -4);
		}

		$query .= " ORDER BY ID ASC";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		if(!empty($params)) {
			// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
			$stmt->bind_param("ssissssiiiiiisdi", $params["marca"], $params["modello"], $params["anno"], $params["colore"], 
										$params["alimentazione"], $params["cambio"], $params["trazione"], 
										$params["potenzaMin"], $params["potenzaMax"], $params["pesoMin"], $params["pesoMax"], 
										$params["neopatentati"], $params["posti"], $params["condizione"], $params["prezzoMax"], $params["chilometraggio"]);
		}

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		return $rows;
	}

	//FUNZIONE PER RICAVARE TUTTI I VEICOLI PRESENTI NEL DB
	public function getAllVehicles() {
		$query = "SELECT * FROM Veicolo ORDER BY ID ASC;";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		return $rows;
	}

	//FUNZIONE PER INSERIRE NUOVO VEICOLO IN VEICOLI NEL DB
	public function insertNewVehicle($marca, $modello, $anno, $colore, $alimentazione, $cambio, $trazione, $CVpotenza, $KGpeso, $neoP, $nPosti, $condizione, $chilometraggio, $prezzo) {
		
		$query = "INSERT INTO Veicolo (marca ,modello, anno, colore, alimentazione, cambio, trazione, potenza, 
							peso, neopatentati, numeroPosti, condizione, chilometraggio, prezzo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
		$stmt->bind_param("ssissssiiiisid", $marca, $modello, $anno, $colore, $alimentazione, $cambio, $trazione, $CVpotenza, 
						$KGpeso, $neoP, $nPosti, $condizione, $chilometraggio, $prezzo);

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		$result = $stmt->get_result();

		// Controllo del risultato
		if ($result) {
			return true;
		} else {
			return false;
		}
		
	}

	
}


?>