<?php

// DA INSERIRE CONTROLLO CON $SESSION PER CONTROLLARE SE CI SONO DEI FILTRI SALVATI

require_once "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'public_html'. DIRECTORY_SEPARATOR . 'squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = "";
$stringaGiocatrici = "";

//in fase di produzione il controllo corretto e' $connessioneOK
if ($connessioneOK) {

	$giocatrici = $connessione->getList();

	$connessione->closeConnection();

	if(count($giocatrici) >= 0) {

		for($i = 0; $i < count($giocatrici); $i++) {
			$stringaGiocatrici .= "<dl class=\"giocatrici\"><dt>";

			$nome = $giocatrici[$i]['nome'];
			$capitano = $giocatrici[$i]['capitano'];
			$stringaGiocatrici .= $nome . $capitano == true ? " - Capitano" : "" . "</dt>";
			
			$immagine = $giocatrici[$i]["immagine"];
			$stringaGiocatrici .= "<dd class=\"giocatoreGrid\"><img src=\"" . $immagine . "\" alt=\"\"><dl class=\"giocatore\">";

			$dataNascita = $giocatrici[$i]['dataNascita'];
			$stringaGiocatrici .= "<dt>Data di nascita</dt><dd>" . $dataNascita . "<dd>";

			$luogo = $giocatrici[$i]['luogo'];
			$stringaGiocatrici .= "<dt>Luogo</dt><dd>" . $luogo . "<dd>";

			$squadra = $giocatrici[$i]['squadra'];
			$stringaGiocatrici .= "<dt>Squadra</dt><dd>" . $squadra . "<dd>";

			$ruolo = $giocatrici[$i]['ruolo'];
			$stringaGiocatrici .= "<dt>Ruolo</dt><dd>" . $ruolo . "<dd>";

			$altezza = $giocatrici[$i]['altezza'];
			$stringaGiocatrici .= "<dt>Altezza</dt><dd>" . $altezza . "<dd>";

			$maglia = $giocatrici[$i]['maglia'];
			$stringaGiocatrici .= "<dt>Maglia</dt><dd>" . $maglia . "<dd>";

			$magliaNazionale = $giocatrici[$i]['magliaNazionale'];
			$stringaGiocatrici .= "<dt>Maglia in nazionale</dt><dd>" . $magliaNazionale . "<dd>";

			$punti = $giocatrici[$i]['punti'];
			$stringaGiocatrici .= "<dt>" . $ruolo != 'Libero' ? "Punti totali" : "Ricezioni" . "</dt><dd>" . $punti . "<dd>";

			$riconoscimenti = $giocatrici[$i]['riconoscimenti'];
			$stringaGiocatrici .= "<dt>Riconoscimenti</dt><dd>" . $riconoscimenti . "<dd>";

			$note = $giocatrici[$i]['note'];
			$stringaGiocatrici .= "<dt>Note</dt><dd>" . $note . "<dd>";

		}

	}


} else {

	//in fase di produzione rimuovere $connessioneOK
	$stringaGiocatrici = $connessioneOK . "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";

}

echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);
?>