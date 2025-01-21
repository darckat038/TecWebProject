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

	//FUNZIONE DI REGISTRAZIONE DI UN UTENTE NEL DB
	public function insertPrenotazione($username, $idAuto, $data) {

		$queryControllo = "SELECT * FROM Veicolo WHERE id = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("i", $idAuto);
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
			//L'AUTO NON ESISTE
		}

		$queryControllo2 = "SELECT * FROM Prenotazione WHERE username = ? AND idAuto = ? AND dataOra = ?";
		// Preparazione dello statement
		$stmt2 = $this->connection->prepare($queryControllo2);
		if ($stmt2 === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt2->bind_param("sis", $username, $idAuto, $data);
		// Esecuzione della query
		if (!$stmt2->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt2->error);
		}
		// Ottenimento del risultato
		$result2 = $stmt2->get_result();
		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
		$numRows2 = count($rows2);

		if($numRows2 != 0){
			return -2;
			//PRENOTAZIONE GIA' ESISTENTE
		}

		// Preparazione della query SQL con placeholder
		$query = "INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES (?, ?, ?, 0)";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri ("sssss" = 5 stringhe)
		$stmt->bind_param("sis", $username, $idAuto, $data);

		// Esecuzione della query
		$result = $stmt->execute();

		// Controllo del risultato
		if ($result) {
			return 1;
			//INSERITA CON SUCCESSO
		} else {
			return 0;
			//ERRORE NELL'INSERIMENTO
		}
			
	}

	// FUNZIONE PER RICAVARE I VEICOLI CON FILTRI APPLICATI PRESENTI NEL DB
	/*
	* Uso array associativo params dove metto i vari valori. Se valore vuoto, non lo setto in params
	*/
	public function getFilteredVehicles($params) {

		$query = "SELECT * FROM Veicolo";

		$result = array();

		// Se params non è vuoto, aggiungo clausola WHERE
		if(!empty($params)) {
			$query .= " WHERE";
			$paramS = "";
			$paramA = array();

			// Faccio controllo per ogni parametro auto

			if(isset($params["marca"])) {
				$query .= " marca LIKE ? AND";
				array_push($paramA, "%" . $params["marca"] . "%");
				$paramS .= "s";
			}

			if(isset($params["modello"])) {
				$query .= " modello LIKE ? AND";
				array_push($paramA, "%" . $params["modello"] . "%");
				$paramS .= "s";
			}

			if(isset($params["anno"])) {
				$query .= " anno = ? AND";
				array_push($paramA, $params["anno"]);
				$paramS .= "i";
			}

			if(isset($params["colore"])) {
				$query .= " colore LIKE ? AND";
				array_push($paramA, "%" . $params["colore"] . "%");
				$paramS .= "s";
			}

			if(isset($params["alimentazione"])) {
				$query .= " alimentazione LIKE ? AND";
				array_push($paramA, "%" . $params["alimentazione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["cambio"])) {
				$query .= " cambio LIKE ? AND";
				array_push($paramA, "%" . $params["cambio"] . "%");
				$paramS .= "s";
			}

			if(isset($params["trazione"])) {
				$query .= " trazione LIKE ? AND";
				array_push($paramA, "%" . $params["trazione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["potenzaMin"])) {
				$query .= " potenza >= ? AND";
				array_push($paramA, $params["potenzaMin"]);
				$paramS .= "i";
			}

			if(isset($params["potenzaMax"])) {
				$query .= " potenza <= ? AND";
				array_push($paramA, $params["potenzaMax"]);
				$paramS .= "i";
			}

			if(isset($params["pesoMin"])) {
				$query .= " peso >= ? AND";
				array_push($paramA, $params["pesoMin"]);
				$paramS .= "i";
			}

			if(isset($params["pesoMax"])) {
				$query .= " peso <= ? AND";
				array_push($paramA, $params["pesoMax"]);
				$paramS .= "i";
			}

			if(isset($params["neopatentati"])) {
				$query .= " neopatentati = ? AND";
				array_push($paramA, $params["neopatentati"]);
				$paramS .= "i";
			}

			if(isset($params["posti"])) {
				$query .= " numeroPosti = ? AND";
				array_push($paramA, $params["posti"]);
				$paramS .= "i";
			}

			if(isset($params["condizione"])) {
				$query .= " condizione LIKE ? AND";
				array_push($paramA, "%" . $params["condizione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["prezzoMax"])) {
				$query .= " prezzo <= ? AND";
				array_push($paramA, $params["prezzoMax"]);
				$paramS .= "d";
			}

			if(isset($params["chilometraggio"])) {
				$query .= " chilometraggio <= ? AND";
				array_push($paramA, $params["chilometraggio"]);
				$paramS .= "i";
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

		// echo $stmt->param_count;

		if(!empty($params)) {
			// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
			$stmt->bind_param($paramS, ...$paramA);
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

	public function getAllVehicleColors() {
		$query = "SELECT DISTINCT colore FROM Veicolo";

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
		$colors = array();

		foreach($rows as $color)
			array_push($colors, $color["colore"]);
			
		return $colors;
	}

	//FUNZIONE PER RICAVARE DETTAGLI VEICOLO DA ID
	public function getVehicleDetails($id) {
		$query = "SELECT * FROM Veicolo WHERE ID = ?";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
		$stmt->bind_param("i", $id);

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$row = $result->fetch_all(MYSQLI_ASSOC);

		if(count($row) == 1){
			return $row[0];
		}

		return -1;
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


	//FUNZIONE PER PRENDERE NOME, COGNOME E USERNAME DA USERNAME
	public function getNomeCognomeUser($username) {
		$query = "SELECT nome, cognome, username FROM Utente WHERE username = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Binding dei parametri
		$stmt->bind_param("s", $username);
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}
	
	

	//FUNZIONE PER PRENDERE LE PRENOTAZIONI DI UN USERNAME(codice, marca, modello)
	public function getPrenElimina($username) {
		$query = "SELECT p.codice, v.marca, v.modello
				  FROM Prenotazione p
				  JOIN Veicolo v ON p.idAuto = v.id
				  WHERE p.username = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Binding dei parametri
		$stmt->bind_param("s", $username);
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}



	//FUNZIONE PER PRENDERE LE PRENOTAZIONI DI UN USERNAME(codice, marca, modello, data, stato)
	public function getPrenotazioniUtente($username) {
		$query = "SELECT p.codice, v.marca, v.modello, p.dataOra, p.stato
					FROM Prenotazione p
					JOIN Veicolo v ON p.idAuto = v.id
					WHERE p.username LIKE ?
					ORDER BY p.codice";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Binding dei parametri
		$stmt->bind_param("s", $username);

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		return $rows;
	}


	//FUNZIONE PER PRENDERE TUTTE LE PRENOTAZIONI PRESENTI NEL DB
	public function getAllPrenotazioni() {
		$query = "SELECT p.codice, v.marca, v.modello, p.dataOra, p.stato
					FROM Prenotazione p
					JOIN Veicolo v ON p.idAuto = v.id
					ORDER BY p.codice";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}
	

	//FUNZIONE PER CANCELLARE LE PRENOTAZIONI
	public function deletePrenotazione($codicePrenotazione) {
		
		$query = "DELETE FROM Prenotazione WHERE codice = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("s", $codicePrenotazione)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Controllo righe eliminate
		if ($stmt->affected_rows > 0) {
			return true; // Prenotazione eliminata con successo
		} else {
			return false; // Nessuna prenotazione corrisponde al codice fornito
		}
	}

	public function updateNome($username, $nuovoNome) {
    
		// Query per aggiornare il nome dell'utente dato il suo username
		$query = "UPDATE Utente SET nome = ? WHERE username = ?;";
		
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("ss", $nuovoNome, $username)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
		
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		
		// Controllo righe modificate
		if ($stmt->affected_rows > 0) {
			return true; // Nome aggiornato con successo
		} else {
			return false; // Nessun utente trovato con lo username fornito
		}
	}

	public function updateCognome($username, $nuovoCognome) {
    
		// Query per aggiornare il nome dell'utente dato il suo username
		$query = "UPDATE Utente SET cognome = ? WHERE username = ?;";
		
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("ss", $nuovoCognome, $username)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
		
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		
		// Controllo righe modificate
		if ($stmt->affected_rows > 0) {
			return true; // Nome aggiornato con successo
		} else {
			return false; // Nessun utente trovato con lo username fornito
		}
	}

	public function updateUsername($username, $nuovoUsername) {
		// Inizia la transazione
		$this->connection->begin_transaction();
	
		try {
			// Disabilita temporaneamente le foreign key
			$this->connection->query("SET foreign_key_checks = 0;");
	
			// 1. Aggiornare la tabella Prenotazione
			$queryPrenotazione = "UPDATE Prenotazione SET username = ? WHERE username = ?";
			$stmtPrenotazione = $this->connection->prepare($queryPrenotazione);
			if ($stmtPrenotazione === false) {
				throw new Exception("Errore nella preparazione dello statement per Prenotazione: " . $this->connection->error);
			}
			if (!$stmtPrenotazione->bind_param("ss", $nuovoUsername, $username)) {
				throw new Exception("Errore nell'associazione dei parametri per Prenotazione: " . $stmtPrenotazione->error);
			}
			if (!$stmtPrenotazione->execute()) {
				throw new Exception("Errore nell'esecuzione dello statement per Prenotazione: " . $stmtPrenotazione->error);
			}
	
			// 2. Aggiornare la tabella Utente
			$queryUtente = "UPDATE Utente SET username = ? WHERE username = ?";
			$stmtUtente = $this->connection->prepare($queryUtente);
			if ($stmtUtente === false) {
				throw new Exception("Errore nella preparazione dello statement per Utente: " . $this->connection->error);
			}
			if (!$stmtUtente->bind_param("ss", $nuovoUsername, $username)) {
				throw new Exception("Errore nell'associazione dei parametri per Utente: " . $stmtUtente->error);
			}
			if (!$stmtUtente->execute()) {
				throw new Exception("Errore nell'esecuzione dello statement per Utente: " . $stmtUtente->error);
			}
	
			// Riabilita le foreign key
			$this->connection->query("SET foreign_key_checks = 1;");
	
			// Commit della transazione se entrambe le operazioni sono riuscite
			$this->connection->commit();
	
			return true;
		} catch (Exception $e) {
			// In caso di errore, rollback della transazione
			$this->connection->rollback();
	
			// Gestisci l'errore
			die("Errore: " . $e->getMessage());
		}
	}
	
	public function updatePassword($username, $vecchiaPassword, $nuovaPassword) {
		// Query per ottenere la password corrente dell'utente
		$query = "SELECT password FROM Utente WHERE username = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("s", $username)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
	
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione della query: " . $stmt->error);
		}
	
		// Recupero del risultato
		$result = $stmt->get_result();
		if ($result->num_rows === 0) {
			// Utente non trovato
			return -1;
		}
	
		// Estrazione della password memorizzata
		$row = $result->fetch_assoc();
		$passwordMemorizzata = $row['password'];
	
		// Confronta la vecchia password con la password memorizzata nel database
		if (!password_verify($vecchiaPassword, $passwordMemorizzata)) {
			// La vecchia password non corrisponde
			return -1;
		}
	
		// Se la vecchia password è corretta, aggiorna con la nuova password
		$queryUpdate = "UPDATE Utente SET password = ? WHERE username = ?;";
		$stmtUpdate = $this->connection->prepare($queryUpdate);
		if ($stmtUpdate === false) {
			die("Errore nella preparazione dello statement per l'update della password: " . $this->connection->error);
		}
	
		// Crittografa la nuova password usando PASSWORD_DEFAULT (BCRYPT)
		$nuovaPasswordCriptata = password_hash($nuovaPassword, PASSWORD_DEFAULT);
	
		// Associazione dei parametri per l'update
		if (!$stmtUpdate->bind_param("ss", $nuovaPasswordCriptata, $username)) {
			die("Errore nell'associazione dei parametri per l'update: " . $stmtUpdate->error);
		}
	
		// Esecuzione della query di aggiornamento
		if (!$stmtUpdate->execute()) {
			die("Errore nell'esecuzione della query di aggiornamento: " . $stmtUpdate->error);
		}
	
		// Restituisce un valore di successo
		if ($stmtUpdate->affected_rows > 0) {
			return true; // La password è stata aggiornata con successo
		} else {
			return false; // Nessuna modifica (forse la nuova password è uguale alla vecchia)
		}
	}
	

	



}



?>