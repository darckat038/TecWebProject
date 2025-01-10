<?php

require_once ".." . DIRECTORY_SEPARATOR . "php_sessions" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR . "listino.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$veicoli = array();
$stringaVeicoli = "";

//in fase di produzione il controllo corretto e' $connessioneOK
if ($connessioneOK) {

    // DA INSERIRE CONTROLLO CON $SESSION PER CONTROLLARE SE CI SONO DEI FILTRI SALVATI

	$veicoli = $connessione->getFilteredVehicles();

	$connessione->closeConnection();

	if(count($veicoli) > 0) {

		$stringaVeicoli = '<dl id="list_car_list">';

		$stringaVeicoli .= '<!---
				IDEA: DESKTOP -> RETTANGOLI LARGHI, IMG A SX E INFO A DX
						MOBILE -> RETTANGOLI STRETTI, IMG IN ALTO E INFO IN BASSO
				-->';

		foreach($veicoli as $veicolo) {
			
		}

		$stringaVeicoli .= '</dl>
            </section>';

	}


} else {

	//in fase di produzione rimuovere $connessioneOK
	$stringaVeicoli = $connessioneOK . "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";

}

$strPatternToReplace = '/<dl id="list_car_list">.*?<\/dl>\s*<\/section>/s';

echo preg_replace($strPatternToReplace, $stringaVeicoli, $paginaHTML);
?>