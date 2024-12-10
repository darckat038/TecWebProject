<?php

require_once "templatedbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = "";
$stringaGiocatrici = "";

// In fase di produzione il controllo corretto e' $connessioneOK. In fase di debug e' !$connessioneOK, perchè avere 0 errori viene convertito in "false"
if (!$connessioneOK) {
    $giocatrici = $connessione->getlist();

    $connessione->closeConnection();  // La connessione va chiusa subito, non in fondo

	// Mio tentativo
	/*
	if ($giocatrici && count($giocatrici) > 0) { 
		foreach ($giocatrici as $row) { 
			$stringaGiocatrici .= 
			"<dt>Nome</dt>" . "<dd>" . $row['nome'] . "</dd>" 
			. "<dt>Capitano</dt>" . "<dd>" . $row['capitano'] . "</dd>"
			. "<dt>Data di nascita</dt>" . "<dd>" . $row['dataNascita'] . "</dd>" 
			. "<dt>Luogo</dt>" . "<dd>" . $row['luogo'] . "</dd>" 
			. "<dt>Squadra</dt>" . "<dd>" . $row['squadra'] . "</dd>"
			. "<dt>Ruolo</dt>" . "<dd>" . $row['ruolo'] . "</dd>" 
			. "<dt>Altezza</dt>" . "<dd>" . $row['altezza'] . "</dd>"
			. "<dt>Maglia</dt>" . "<dd>" . $row['maglia'] . "</dd>" 
			. "<dt>Maglia in nazionale</dt>" . "<dd>" . $row['magliaNazionale'] . "</dd>"
			. "<dt>Punti</dt>" . "<dd>" . $row['punti'] . "</dd>" 
			. "<dt>Riconoscimenti</dt>" . "<dd>" . $row['riconoscimenti'] . "</dd>"
			. "<dt>Note</dt>" . "<dd>" . $row['note']. "</dd>"; 
		}
	}
	*/

	// Soluzione della prof
	if(count($giocatrici) > 0){
        $stringaGiocatrici = '<dl> class="giocatrici">';

		foreach ($giocatrici as $giocatrice) {
			$stringaGiocatrici .= '<dt>' . $giocatrice['nome'];
			if($giocatrice['capitano']) {
				$stringaGiocatrici .= " - <em>Capitano</em>";
			}
			$stringaGiocatrici .= '<dt>'
			. '<dd><img src="' . $giocatrice['immagine'] . '" alt="" >'
			. '<dl classe="giocatrice">'
			. '<dt>Data di nascita</dt>' . '<dd>' . $giocatrice['datanascita'] . '</dd>'
			. "<dt>Luogo</dt>" . "<dd>" . $giocatrice['luogo'] . "</dd>" 
			. "<dt>Squadra</dt>" . "<dd>" . $giocatrice['squadra'] . "</dd>"
			. "<dt>Ruolo</dt>" . "<dd>" . $giocatrice['ruolo'] . "</dd>" 
			. "<dt>Altezza</dt>" . "<dd>" . $giocatrice['altezza'] . "</dd>"
			. "<dt>Maglia</dt>" . "<dd>" . $giocatrice['maglia'] . "</dd>" 
			. "<dt>Maglia in nazionale</dt>" . "<dd>" . $giocatrice['magliaNazionale'] . "</dd>";

			/* Va messo prima il controllo del caso negativo perchè in un "if then else" bisogna mettere nel then l'opzione più probabile, 
			per ragioni di efficienza, visto che il then viene eseguito in parallelo al controllo dell'esecuzione dell'if  */
			if($giocatrice['ruolo']!='Libero'){
				$stringaGiocatrici .= '<dt>Punti totali</dt>'
				. '<dd>' . $giocatrice['punti'] . '</dd>';
			}
			else{
				$stringaGiocatrici .= '<dt>Ricezioni</dt>'
				. '<dd>' . $giocatrice['ricezioni'] . '</dd>';
			}
		}
	}

} else {
	// In fase di produzione rimuovere $connessioneOK, perchè all'utente non piace vederlo
	$stringaGiocatrici = $connessioneOK . "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}

echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);

?>
