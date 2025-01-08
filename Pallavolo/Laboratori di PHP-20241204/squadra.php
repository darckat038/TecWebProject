<?php

require_once "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'public_html'. DIRECTORY_SEPARATOR . 'squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = "";
$stringaGiocatrici = "";

//in fase di produzione il controllo corretto e' $connessioneOK
if ($connessioneOK) {

	$stringaGiocatrici = $connessione->getList();

	$connessione->closeConnection();

	if(count($stringaGiocatrici) >= 0) {

		for($i = 0; $i < count($stringaGiocatrici); $i++) {
			$stringaGiocatrici .= "<dl class=\"giocatrici\"><dt>";

			$nome = $stringaGiocatrici[$i]['nome'];
			$capitano = $stringaGiocatrici[$i]['capitano'];
			$stringaGiocatrici .= $nome . $capitano == true ? " - Capitano" : "" . "</dt>";
			
			$immagine = $stringaGiocatrici[$i]["immagine"];
			$stringaGiocatrici .= "<dd class=\"giocatoreGrid\"><img src=\"" . $immagine . "\" alt=\"\"><dl class=\"giocatore\">";

			$dataNascita = $stringaGiocatrici[$i]['dataNascita'];
			$stringaGiocatrici .= "<dt>Data di nascita</dt><dd>" . $dataNascita . "<dd>";

			$luogo = $stringaGiocatrici[$i]['luogo'];
			$stringaGiocatrici .= "<dt>Luogo</dt><dd>" . $luogo . "<dd>";

			$squadra = $stringaGiocatrici[$i]['squadra'];
			$stringaGiocatrici .= "<dt>Squadra</dt><dd>" . $squadra . "<dd>";

			$ruolo = $stringaGiocatrici[$i]['ruolo'];
			$stringaGiocatrici .= "<dt>Ruolo</dt><dd>" . $ruolo . "<dd>";

			$altezza = $stringaGiocatrici[$i]['altezza'];
			$stringaGiocatrici .= "<dt>Altezza</dt><dd>" . $altezza . "<dd>";

			$maglia = $stringaGiocatrici[$i]['maglia'];
			$stringaGiocatrici .= "<dt>Maglia</dt><dd>" . $maglia . "<dd>";

			$magliaNazionale = $stringaGiocatrici[$i]['magliaNazionale'];
			$stringaGiocatrici .= "<dt>Maglia in nazionale</dt><dd>" . $magliaNazionale . "<dd>";

			$punti = $stringaGiocatrici[$i]['punti'];
			$stringaGiocatrici .= "<dt>" . $ruolo != 'Libero' ? "Punti totali" : "Ricezioni" . "</dt><dd>" . $punti . "<dd>";

			$riconoscimenti = $stringaGiocatrici[$i]['riconoscimenti'];
			$stringaGiocatrici .= "<dt>Riconoscimenti</dt><dd>" . $riconoscimenti . "<dd>";

			$note = $stringaGiocatrici[$i]['note'];
			$stringaGiocatrici .= "<dt>Note</dt><dd>" . $note . "<dd>";

		}

	}


} else {

	//in fase di produzione rimuovere $connessioneOK
	$stringaGiocatrici = $connessioneOK . "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";

}

//echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);
?>