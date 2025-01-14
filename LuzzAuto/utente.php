<?php
session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION["utente"])) {
    header("location: login.php");
    exit();
}

require_once 'dbConnection.php';
use DB\DBConnection;

// Recupero username dalla sessione
$username = $_SESSION["utente"];

$db = new DBConnection();

try {

    $utente = $db->getNomeCognomeUser($username);

    if (!empty($utente)) {
        $nome = $utente[0]['nome'];
        $cognome = $utente[0]['cognome'];
        $username = $utente[0]['username'];
    } else {
        $nome = 'Nome non trovato';
        $cognome = 'Cognome non trovato';
        $username = 'Utente non trovato';
    }

    $db->closeConnection();

} catch (Exception $e) {
    header("location: 500.html");
    exit();
}

// Carico template html
$pagina = file_get_contents('utente.html');

// Sostituisco i segnaposto nel template con i dati recuperati
$pagina = str_replace('[nome]', htmlspecialchars($nome), $pagina);
$pagina = str_replace('[cognome]', htmlspecialchars($cognome), $pagina);
$pagina = str_replace('[username]', htmlspecialchars($username), $pagina);

$err = "";

$formORbuttonsHTML= "";

$formHTML = "
            <form method='post'>

                    <span class='nomeRiqUtente'>Gestione Prenotazioni</span>

                    <label id='labelPrenUtente' for='gestPrenUtente'><strong>Prenotazioni:</strong> </label>
                    <select name='gestPrenUtente' id='gestPrenUtente' aria-required='true' aria-label='Campo di inserimento della prenotazione che desideri annullare' required data-msg-required='Per favore, seleziona la prenotazione'>
                    <option value=''>--seleziona--</option>
                    [prenotazioni]
                    </select>

                    <input id='eliminaPrenUtente' type='submit' value='Elimina' aria-label='Elimina la prenotazione selezionata'>

          </form>

          <div class='form_errors'>
            [err]
          </div>
";

$formORbuttonsHTML = $formHTML;

$pagina = str_replace("[formORbuttons]", $formORbuttonsHTML, $pagina);




//ESECUZIONE DELLA QUERY
try{
    $db = new DBConnection();
    $prenotazione = $db->getPrenotazione($username);
    $db->closeConnection();

    unset($db);

    $veicoli = '';
    $prenotazioni = '';

    //INSERIMENTO DEI VEICOLI NEL SELECT
    foreach($prenotazione as $row){
        $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'];

        //REIMPOSTO IL VALORE SETTATO
        if(isset($_POST['gestPrenUtente']) && $_POST['gestPrenUtente'] == $val){
            $veicoli .= "<option value='" . $val . "' selected>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        else{
            $veicoli .= "<option value='" . $val . "'>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        
    }
    $pagina = str_replace("[prenotazioni]", $veicoli, $pagina);

}
    
catch(Exception $e){
    header("location: 500.html");
    exit();
}



echo $pagina;
?>
























