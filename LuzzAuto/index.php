<?php

function ripristinoInput(){
	$indexHTML = file_get_contents('index.html');
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$indexHTML = str_replace("[marca]", htmlspecialchars(isset($_GET['marca']) ? $_GET['marca'] : ''), $indexHTML);
	$indexHTML = str_replace("[modello]", htmlspecialchars(isset($_GET['modello']) ? $_GET['modello'] : ''), $indexHTML);

	//replace condizione
	if(htmlspecialchars(isset($_GET['condizione']))) {
		$indexHTML = str_replace("[" . $_GET['condizione'] . "]", "selected ", $indexHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$indexHTML = str_replace(["[qualsiasiCd]", "[nuovo]", "[usato]", "[km0]"], ["selected ", "", "", ""], $indexHTML);

	$indexHTML = str_replace("[prezzoMax]", htmlspecialchars(isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : ''), $indexHTML);
	return $indexHTML;
}

require_once "dbConnection.php";
use DB\DBConnection;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$indexHTML = file_get_contents("index.html");

$err = "";

if(isset($_GET["marca"]) || isset($_GET["modello"]) || isset($_GET["condizione"]) || isset($_GET["prezzoMax"])) {

    //CONTROLLI SULL'INPUT
	if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["marca"])) {
		$err = $err . "<p id=\"marca_err\">Marca non valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["modello"])) {
		$err = $err . "<p id=\"modello_err\">Modello non valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (!empty($_GET["prezzoMax"]) && doubleval($_GET["prezzoMax"]) <= 0) {
		$err = $err . "<p id=\"prezzoMax_err\">Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
	}

	//CONTROLLO ERRORI
	if (!empty($err)) {
		$indexHTML = ripristinoInput();
		echo str_replace("[err]", $err, $indexHTML);
		exit();
	}

	// PASSAGGIO A LISTINO.PHP
	// Aggiungo i valori di default di listino
	$queryString = http_build_query($_GET) . "&anno=&colore=qualsiasi&alimentazione=qualsiasi&cambio=qualsiasi&trazione=qualsiasi&potenzaMin=&potenzaMax=&pesoMin=&pesoMax=&posti=&chilometraggio=&action=Applica+filtri";
	header("location: listino.php?$queryString");

} else {
	$indexHTML = ripristinoInput();
	echo str_replace("[err]", $err, $indexHTML);
}

?>