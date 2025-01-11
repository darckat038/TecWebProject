<?php

function ripristinoInput(){
	$indexHTML = file_get_contents('index.html');
	//RIPRISTINO DELL'INPUT INSERITO
	$indexHTML = str_replace("[marca]", htmlspecialchars(isset($_GET['marca']) ? $_GET['marca'] : ''), $indexHTML);
	$indexHTML = str_replace("[modello]", htmlspecialchars(isset($_GET['modello']) ? $_GET['modello'] : ''), $indexHTML);
	$indexHTML = str_replace("[condizione]", htmlspecialchars(isset($_GET['condizione']) ? $_GET['condizione'] : '-- Qualsiasi --'), $indexHTML);
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
	if (!preg_match("/^[A-Za-z0-9\-]+$/", $_GET["marca"])) {
		$err = $err . "<p>Marca non valida, puoi usare solo lettere, numeri e il carattere \"-\".</p>";
	}
	if (!preg_match("/^[A-Za-z0-9\-]+$/", $_GET["modello"])) {
		$err = $err . "<p>Modello non valido, puoi usare solo lettere, numeri e il carattere \"-\".</p>";
	}
	if (doubleval($_GET["prezzoMax"]) <= 0) {
		$err = $err . "<p>Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
	}

	//CONTROLLO ERRORI
	if (!empty($err)) {
		$indexHTML = ripristinoInput();
		echo str_replace("[err]", $err, $indexHTML);
		exit();
	}

	// PASSAGGIO A LISTINO.PHP
	header("location: listino.php");

} else {
	$indexHTML = ripristinoInput();
	echo str_replace("[err]", $err, $indexHTML);
}

?>