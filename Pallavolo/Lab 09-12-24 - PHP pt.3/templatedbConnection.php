<?php
namespace DB;

class DBAccess {

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "";
	private const USERNAME = "";
	private const PASSWORD = "";

	private $connection;

	public function openDBConnection() {

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

		// Debug
		return mysqli_connect_error();

		// Produzione
		/*if (mysqli_connect_errno()) {
			return false;
		}
		else {
			return true;
		}*/
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}


	public function getList() {
        $query = "SELECT * FROM giocatrici ORDER BY ID ASC";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
            $result = array();
			while($row = mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			mysqli_free_result($queryResult);
			return $result;
		}
	}

	public function insertNewElement($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti, $riconoscimenti, $note) {

		$queryInsert = "INSERT INTO giocatrici(nome, capitano, dataNascita, luogo, squadra, ruolo, altezza, maglia, magliaNazionale, punti, riconoscimenti, note) " .
                       "VALUES (\"$nome\", \"$capitano\", \"$dataNascita\", \"$luogo\", \"$squadra\", \"$ruolo\", $altezza, $maglia, $magliaNazionale, $punti, \"$riconoscimenti\", \"$note\")";


		// Tentativi personali
        /*
        // Eseguire la query
		if ($result = mysqli_query($this->connection, $queryInsert or die("Errore in openDBConnection: " . mysqli_error($this->connection)))) { 
			echo "Nuovo record inserito con successo: " . mysqli_num_rows($result); 
		} 
		else { 
			echo "Errore: " . $queryInsert . "<br>" . mysqli_error($conn); 
		}

		// Oppure
		try {
			// Eseguire la query
			$result = mysqli_query($this->connection, $queryInsert);
			if ($result) {
				echo "Nuovo record inserito con successo: " . mysqli_num_rows($result);
			} else {
				throw new Exception("Errore: " . $queryInsert . "<br>" . mysqli_error($this->connection));
			}
		} catch (Exception $e) {
			echo "Errore in openDBConnection: " . $e->getMessage();
		}
		*/

		// La soluzione della prof
		$queryResult = mysqli_query($this->connection, $queryInsert or die("Errore in openDBConnection: " . mysqli_error($this->connection)));

		if(mysqli_affected_rows($this->connection) > 0){
			return true;
		}
		else {
			return false;
		}
	}

	
}


?>