<?php

function ripristinoInput() {
	$listinoHTML = file_get_contents("listino.html");
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$listinoHTML = str_replace("[marca]", htmlspecialchars(isset($_GET['marca']) ? $_GET['marca'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[modello]", htmlspecialchars(isset($_GET['modello']) ? $_GET['modello'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[anno]", htmlspecialchars(isset($_GET['anno']) ? $_GET['anno'] : ''), $listinoHTML);

	//replace colore
	if(htmlspecialchars(isset($_GET['colore']))) {
		$listinoHTML = str_replace("[" . $_GET['colore'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasi]", "[bianco]", "[nero]", "[grigio]", "[rosso]", "[blu]", "[verde]", "[arancione]", "[giallo]"], ["selected ", "", "", "", "", "", "", "", ""], $listinoHTML);

	//replace alimentazione
	if(htmlspecialchars(isset($_GET['alimentazione']))) {
		$listinoHTML = str_replace("[" . $_GET['alimentazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasi]", "[benzina]", "[gasolio]", "[elettrico]", "[gpl]", "[plugin]"], ["selected ", "", "", "", "", ""], $listinoHTML);

	//replace cambio
	if(htmlspecialchars(isset($_GET['cambio']))) {
		$listinoHTML = str_replace("[" . $_GET['cambio'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasi]", "[manuale]", "[automatico]"], ["selected ", "", ""], $listinoHTML);

	//replace trazione
	if(htmlspecialchars(isset($_GET['trazione']))) {
		$listinoHTML = str_replace("[" . $_GET['trazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasi]", "[anteriore]", "[posteriore]", "[integrale]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace("[potenzaMin]", htmlspecialchars(isset($_GET['potenzaMin']) ? $_GET['potenzaMin'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[potenzaMax]", htmlspecialchars(isset($_GET['potenzaMax']) ? $_GET['potenzaMax'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[pesoMin]", htmlspecialchars(isset($_GET['pesoMin']) ? $_GET['pesoMin'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[pesoMax]", htmlspecialchars(isset($_GET['pesoMax']) ? $_GET['pesoMax'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[neopatentati]", htmlspecialchars(isset($_GET['neopatentati']) ? 'checked ' : ''), $listinoHTML);
	$listinoHTML = str_replace("[posti]", htmlspecialchars(isset($_GET['posti']) ? $_GET['posti'] : ''), $listinoHTML);

	//replace condizione
	if(htmlspecialchars(isset($_GET['condizione']))) {
		$listinoHTML = str_replace("[" . $_GET['condizione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasi]", "[nuovo]", "[usato]", "[km0]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace("[prezzoMax]", htmlspecialchars(isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : ''), $listinoHTML);
	$listinoHTML = str_replace("[chilometraggio]", htmlspecialchars(isset($_GET['chilometraggio']) ? $_GET['chilometraggio'] : ''), $listinoHTML);

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
	if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["marca"])) {
		$err = $err . "<p>Marca non valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["modello"])) {
		$err = $err . "<p>Modello non valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (!empty($_GET["anno"]) && (intval($_GET["anno"]) < 1990 || intval($_GET["anno"]) > 2024)) {
		$err = $err . "<p>Anno non valido, inserisci un anno compreso tra 1990 e 2024</p>";
	}
	if (!empty($_GET["potenzaMin"]) && (intval($_GET["potenzaMin"]) <= 0) || (!empty($_GET["potenzaMax"]) ? (intval($_GET["potenzaMin"]) > intval($_GET["potenzaMax"])) : false)) {
		$err = $err . "<p>Potenza minima non valida, inserisci una potenza maggiore di 0 e minore o uguale alla potenza massima.</p>";
	}
	if (!empty($_GET["potenzaMax"]) && (intval($_GET["potenzaMax"]) <= 0) || (!empty($_GET["potenzaMin"]) ? (intval($_GET["potenzaMax"]) < intval($_GET["potenzaMin"])) : false)) {
		$err = $err . "<p>Potenza massima non valida, inserisci una potenza maggiore di 0 e maggiore o uguale alla potenza minima.</p>";
	}
	if (!empty($_GET["pesoMin"]) && (intval($_GET["pesoMin"]) <= 0) || (!empty($_GET["pesoMax"]) ? (intval($_GET["pesoMin"]) > intval($_GET["pesoMax"])) : false)) {
		$err = $err . "<p>Peso minimo non valido, inserisci un peso maggiore di 0 e minore o uguale al peso massimo.</p>";
	}
	if (!empty($_GET["pesoMax"]) && (intval($_GET["pesoMax"]) <= 0) || (!empty($_GET["pesoMin"]) ? (intval($_GET["pesoMax"]) < intval($_GET["pesoMin"])) : false)) {
		$err = $err . "<p>Peso massimo non valido, inserisci un peso maggiore di 0 e maggiore o uguale al peso minimo.</p>";
	}
	if (!empty($_GET["posti"]) && (intval($_GET["posti"]) <= 0)) {
		$err = $err . "<p>Numero di posti non valido, inserisci un numero maggiore di 0.</p>";
	}
	if (!empty($_GET["prezzoMax"]) && doubleval($_GET["prezzoMax"]) <= 0) {
		$err = $err . "<p>Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
	}
	if (!empty($_GET["chilometraggio"]) && intval($_GET["chilometraggio"]) < 0) {
		$err = $err . "<p>Chilometraggio non valido, inserisci un numero maggiore o uguale a 0.</p>";
	}

	//CONTROLLO ERRORI
	if (!empty($err)) {
		$listinoHTML = ripristinoInput();
		echo str_replace("[err]", $err, $listinoHTML);
		exit();
	}

	//SE NON CI SONO ERRORI MI SALVO I VALORI IN SESSION
	/*
	foreach($_GET as $param => $value) {
		$_SESSION[$param] = $value;
	}
	*/

	$listinoHTML = ripristinoInput();
	echo str_replace("[err]", $err, $listinoHTML);

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