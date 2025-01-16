<?php
session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION["utente"])) {
    header("location: login.php");
    exit();
}



//INFORMAZIONI UTENTE
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



//TABELLA PRENOTAZIONI

//esecuzione della query
try{
    $db = new DBConnection();
    $prenotazione = $db->getPrenotazioni($username);
    $db->closeConnection();

    unset($db);

    $campiTabella = '';

    if(empty($prenotazione)) {
        //non ci sono prenotazioni
        $campiTabella = "<p id='prenIndispUtente'>Non ci sono prenotazioni disponibili.</p>";
    }else{
        $campiTabella .= "  
                            <p id='descTable'>
                            La tabella descrive le prenotazioni dei test drive da parte dell'utente, è organizzata in colonne
                            con numero prenotazione, modello auto, data test drive e stato della prenotazione 
                            </p>
                            <table class='tabellaPrenUtente' aria-describedby='descTable'>
                                <thead>
                                <tr>
                                    <th scope='col'><abbr title='Numero prenotazione'>Num. Pren.</abbr></th>
                                    <th scope='col' abbr='modello'>Modello Auto</th>
                                    <th scope='col' abbr='data'>Data Test Drive</th>
                                    <th scope='col' >Stato</th>
                                </tr>
                                </thead>
                                <tbody>";
        foreach ($prenotazione as $row) {

            $statoTestuale = "";
            if($row['stato'] == 1){
                $statoTestuale = "<span id='accettatoUtente'>Accettato</span>";
            }else if($row['stato'] == -1){
                $statoTestuale = "<span id='rifiutatoUtente'>Rifiutato</span>";
            }else{
                $statoTestuale = "<span id='attesaUtente'>In attesa</span>";
            }

            $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'] . "-" . $row['dataOra'] . "-" . $row['stato']; 
            $campiTabella .= "<tr>
                                <td>" . $row["codice"] . "</td>
                                <td>" . $row["marca"] . " " . $row['modello'] . "</td>
                                <td>" . $row['dataOra'] . "</td>
                                <td>" . $statoTestuale . "</td>
                              </tr>";
        }
        $campiTabella .= "</tbody>
                          </table>"; 

    }  
    $pagina = str_replace("[campiTabella]", $campiTabella, $pagina);

}   
catch(Exception $e){
    header("location: 500.html");
    exit();
}





//GESTIONE PRENOTAZIONE
$err = "";

$succ="";

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

";

$formORbuttonsHTML = $formHTML;

$pagina = str_replace("[formORbuttons]", $formORbuttonsHTML, $pagina);


//esecuzione della query
try{
    $db = new DBConnection();
    $prenotazione = $db->getPrenEllimina($username);
    $db->closeConnection();

    unset($db);

    $prenotazioni = '';

    //inserimento veicoli nel select
    foreach($prenotazione as $row){
        $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'];

        //reimposto il valore settato
        if(isset($_POST['gestPrenUtente']) && $_POST['gestPrenUtente'] == $val){
            $prenotazioni .= "<option value='" . $val . "' selected>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        else{
            $prenotazioni .= "<option value='" . $val . "'>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        
    }
    $pagina = str_replace("[prenotazioni]", $prenotazioni, $pagina);

}
    
catch(Exception $e){
    header("location: 500.html");
    exit();
}


if (isset($_POST['gestPrenUtente'])) {

    // Controllo sul campo vuoto
    if (empty($_POST['gestPrenUtente'])) {
        $err .= "<p>Devi compilare tutti i campi.</p>";
        $pagina = str_replace("[err]", $err, $pagina);
        $pagina = str_replace("[succ]", $succ, $pagina);
        echo $pagina;
        exit();
    }

    // Controllo sull'input (validazione)
    if (!preg_match("/^[A-Za-z0-9\-\s]+$/", $_POST["gestPrenUtente"])) {
        $err .= "<p>Auto non valida</p>";
    }

    // Restituzione errori in caso di problemi di validazione
    if (!empty($err)) {
        $pagina = str_replace("[err]", $err, $pagina);
        $pagina = str_replace("[succ]", $succ, $pagina);
        echo $pagina;
        exit();
    }

    // Recupero ID della prenotazione
    $idPrenotazione = explode("-", $_POST["gestPrenUtente"])[0];
    $idPrenotazione = htmlspecialchars($idPrenotazione);

    // Tentativo di cancellazione della prenotazione
    try {
        $db = new DBConnection();
        $ris = $db->deletePrenotazione($idPrenotazione); // Assume che la funzione restituisca un booleano (true/false)
        $db->closeConnection();
        unset($db);

        if (!$ris) {
            // Prenotazione non trovata
            $err .= "<p>Prenotazione non esiste. (ID: " . $idPrenotazione . ")</p>";
        } else {
            // Prenotazione cancellata con successo
            $succ .= "<p>Prenotazione cancellata con SUCCESSO.</p>";
        }

    } catch (Exception $e) {
        // Gestione errori e logging
        error_log("Errore: " . $e->getMessage());
        header("location: 500.html");
        exit();
    }

    // Aggiornamento della pagina con esito finale
    $pagina = str_replace("[err]", $err, $pagina);
    $pagina = str_replace("[succ]", $succ, $pagina);

}



echo $pagina;
?>























