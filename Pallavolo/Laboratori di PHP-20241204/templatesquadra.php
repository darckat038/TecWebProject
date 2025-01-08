<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'php'. DIRECTORY_SEPARATOR . 'squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = "";
$stringaGiocatrici = "";

if ($connessioneOK) {
	$stringaGiocatrici = .....

} else {
	$stringaGiocatrici = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}
echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);

?>