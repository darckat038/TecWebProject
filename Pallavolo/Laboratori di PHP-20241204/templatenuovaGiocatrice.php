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

}


if (isset($_POST['submit'])) {
	
	
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

