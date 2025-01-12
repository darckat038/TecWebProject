<?php

function ripristinoInput(){
	$listinoHTML = file_get_contents("listino.html");
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$listinoHTML = str_replace("[marca]", htmlspecialchars(isset($_GET['marca']) ? $_GET['marca'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[modello]", htmlspecialchars(isset($_GET['modello']) ? $_GET['modello'] : ''), $listinoHTML);
	
	$listinoHTML = str_replace("[condizione]", htmlspecialchars(isset($_GET['condizione']) ? $_GET['condizione'] : '-- Qualsiasi --'), $listinoHTML);

	$listinoHTML = str_replace("[prezzoMax]", htmlspecialchars(isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : ''), $listinoHTML);
	return $listinoHTML;
}

require_once "dbConnection.php";
use DB\DBConnection;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$listinoHTML = file_get_contents("listino.html");

$err = "";

if(isset($_GET["marca"]) || isset($_GET["modello"]) || isset($_GET["anno"]) || isset($_GET["colore"]) 
	|| isset($_GET["alimentazione"]) || isset($_GET["cambio"]) || isset($_GET["trazione"]) || isset($_GET["potenzaMin"]) || isset($_GET["potenzaMax"]) 
	|| isset($_GET["pesoMin"]) || isset($_GET["pesoMax"]) || isset($_GET["neopatentati"]) || isset($_GET["posti"]) || isset($_GET["condizione"]) 
	|| isset($_GET["prezzoMax"]) || isset($_GET["chilometraggio"])) {

    //CONTROLLI SULL'INPUT
	if (!preg_match("/^[A-Za-z0-9\-]*$/", $_GET["marca"])) {
		$err = $err . "<p>Marca non valida, puoi usare solo lettere, numeri e il carattere \"-\".</p>";
	}
	if (!preg_match("/^[A-Za-z0-9\-]*$/", $_GET["modello"])) {
		$err = $err . "<p>Modello non valido, puoi usare solo lettere, numeri e il carattere \"-\".</p>";
	}
	if ($_GET["anno"] != "" && (intval($_GET["anno"]) < 1990 || intval($_GET["anno"]) > 2024)) {
		$err = $err . "<p>Anno non valido, inserisci un anno compreso tra 1990 e 2024</p>";
	}
	if ($_GET["prezzoMax"] != "" && doubleval($_GET["prezzoMax"]) <= 0) {
		$err = $err . "<p>Prezzo non valido, inserisci un prezzo maggiore di 0.</p>"; 
	}

	//CONTROLLO ERRORI
	if (!empty($err)) {
		$listinoHTML = ripristinoInput();
		echo str_replace("[err]", $err, $listinoHTML);
		exit();
	}

	//ESECUZIONE DELLA QUERY
	/*
	try{
		$db = new DBConnection();

		//IMPOSTARE DATI COME INDICATO NEI FILTRI
		$params = array();
		$ris = $db->getFilteredVehicles($params);

		$db->closeConnection();
		unset($db);

		if($ris){
			
		}
		else{
			header("location: 500.html");
			exit();
		}
	}
	catch(Exception){
		header("location: 500.html");
		exit();
	}
		*/
} else {
	$listinoHTML = ripristinoInput();
	echo str_replace("[err]", $err, $listinoHTML);
}

?>