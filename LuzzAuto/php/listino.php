<?php

require_once "dbConnection.php";
use DB\DBAccess;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'public_html'. DIRECTORY_SEPARATOR . 'squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$veicoli = "";
$stringaVeicoli = "";

//in fase di produzione il controllo corretto e' $connessioneOK
if ($connessioneOK) {

    // DA INSERIRE CONTROLLO CON $SESSION PER CONTROLLARE SE CI SONO DEI FILTRI SALVATI

	$veicoli = $connessione->getAllVehicles();

	$connessione->closeConnection();

	if(count($veicoli) >= 0) {

		for($i = 0; $i < count($veicoli); $i++) {
			
		}

	}


} else {

	//in fase di produzione rimuovere $connessioneOK
	$stringaVeicoli = $connessioneOK . "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";

}

//echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);
?>