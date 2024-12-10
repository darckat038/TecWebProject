<?php 

require_once "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('nuovaGiocatrice.html');

$messaggiPerForm = "";

$nome = '';
$capitano = 0; 
$dataNascita = ''; 
$luogo = '';
$altezza = ''; 
$squadra = ''; 
$maglia = '';
$magliaNazionale = '';
$ruolo = '';
$punti = '';
$riconoscimenti = '';
$note = '';

$tagPermessi ='<em><strong><ul><li>';

function pulisciInput($value){
 	// elimina gli spazi
 	$value = trim($value);
 	// rimuove tag html (non sempre è una buona idea!) 
  	$value = strip_tags($value);
  	// converte i caratteri speciali in entità html (ex. &lt;)
	$value = htmlentities($value);
  	return $value;
}

function pulisciNote($value){
    global $tagPermessi;  // Per poter vedere la variabile globale nello scope della funzione

    // elimina gli spazi
 	$value = trim($value);
 	// rimuove tag html, tranne i tag permessi 
  	$value = strip_tags($value, $tagPermessi);
  	// converte i caratteri speciali in entità html (ex. &lt;)
	// $value = htmlentities($value);  Non si può più fare, perche' ora ci sono dei tag permessi
  	return $value;
}


if (isset($_POST['submit'])) {
    $messaggiPerForm .= "<ul>";

	$nome = pulisciInput($_POST['nome']);
    if (strlen($nome)==0){
		$messaggiPerForm .= "<li>Inserire il nome e cognome</li>";
	}
	else{
		if(preg_match('/\d/', $nome)) { // Controllo se ci sono numeri
            $messaggiPerForm .= "<li>Nome e cognome non possono contenere numero</li>";
		}
		else {
            if (!preg_match("/[\w)+\ ]+\s[\w\ ]+/", $nome)){ // Per sia nome sia cognome; 
				// Funziona solo perche' prima ho controllato che non ci siano numeri, perche' w senno' considera tutti i caratteri alfanumerici
				$messaggiPerForm .= "<li>Inserire sia il nome che il cognome</li>";
			}
		}
	}

	$capitano = pulisciInput($_POST['capitano']); // Comunque occorre pulire, nel caso qualcuno modifichi il form con il dev tool
	
	$dataNascita = pulisciInput($_POST['dataNascita']);
	if(preg_grep("/\d{4}-\d{2}-d{2}/", $nascita)){
		$messaggiPerForm .= "<li>Inserisci tutta la data</li>";
	}

	$luogo = pulisciInput($_POST['luogo']);
	if(strlen($nome)==0){
		$messaggiPerForm .= "<li>Inserire il luogo</li>";
	}
	else{
		if(preg_match('/\d/', $nome)) { // Controllo se ci sono numeri
            $messaggiPerForm .= "<li>Il luogo non puo' contenere un numero</li>";
		}
		else {
            if (!preg_match("/[\w-\s]+/", $nome)){ // Permessi caratteri alfanumerici e spazi
				$messaggiPerForm .= "<li>Inserire un nome di luogo che contenga solo caratteri alfanumerici</li>";
			}
		}
	}

	// Altezza

	// Squadra

	// Maglia

	// Maglia Nazionale

    $ruolo = $_POST['ruolo'];                  // Comunque occorre pulire, nel caso qualcuno modifichi il form con il dev tool
	if (!preg_match("/[\w-\s]+/", $ruolo)){ 
		$messaggiPerForm .= "<li>Inserire un ruolo che contenga solo caratteri alfanumerici</li>";
	}

	// Punti

	$riconoscimenti = pulisciNote($_POST['riconoscimenti']);

    $note = pulisciNote($_POST['note']);

	$messaggiPerForm .= "</ul>";


	if ($messaggiPerForm == "<ul></ul>") {
		$connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

		if($connessioneOK == true){
			$resultInsert = $connessione->insertNewElement($nome, $capitano, $dataNascita, $luogo, $altezza, $squadra, $maglia, $ruolo, 
			$magliaNazionale, $punti, $riconoscimenti, $note);
			$connessione->closeConnection(); // Chiudo subito la connessione

		    if($resultInsert == true){
			    $messaggiPerForm = '<div id="greetings"><p>Giocatrice aggiunta correttamente</p></div>';
		    }
		    else{
			    $messaggiPerForm = '<div id="messageErrors"><p>Errore nell\'inserimento della giocatrice. Riprovare</p></div>';
		    }
		}
	}
}

$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valoreNome]', $nome, $paginaHTML);
$paginaHTML = str_replace('[valData]', $dataNascita, $paginaHTML);
$paginaHTML = str_replace('[valLuogo]', $luogo, $paginaHTML);
$paginaHTML = str_replace('[valoreAltezza]', $altezza, $paginaHTML);
$paginaHTML = str_replace('[valoreSquadra]', $squadra, $paginaHTML);
$paginaHTML = str_replace('[valoreMaglia]', $maglia, $paginaHTML);
$paginaHTML = str_replace('[valRuolo]', $ruolo, $paginaHTML);
$paginaHTML = str_replace('[valoreMagliaNazionale]', $magliaNazionale, $paginaHTML);
$paginaHTML = str_replace('[valorePunti]', $punti, $paginaHTML);
$paginaHTML = str_replace('[valoreRiconoscimenti]', $riconoscimenti, $paginaHTML);
$paginaHTML = str_replace('[valoreNote]', $note, $paginaHTML);

echo $paginaHTML;

?>

