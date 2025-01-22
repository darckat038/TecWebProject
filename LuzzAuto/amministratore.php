<?php

require_once 'dbConnection.php';
use DB\DBConnection;

function mostraTabellaPrenotazioni() {
    // Variabile per memorizzare il risultato
    $campiTabella = '';
    
    try {
        // Connessione al database
        $db = new DBConnection();
        
        // Recupera le prenotazioni per l'utente
        $prenotazione = $db->getAllPrenotazioni();
        
        // Chiudi la connessione
        $db->closeConnection();
        unset($db);

        $campiTabella = "
                        <p id='descTable'>
                            La tabella descrive le richieste di prenotazioni dei test drive effettuate dagli utenti. È organizzata in colonne
                            con numero prenotazione, modello auto, data test drive e stato della prenotazione.
                        </p>
                        <table class='tabellaPrenAdmin' aria-describedby='descTable'>
                        <caption class='nomeRiqPrenAdmin'>Prenotazioni</caption>
                            <thead>
                                <tr>
                                    <th scope='col'><abbr title='Numero prenotazione'>Num. Pren.</abbr></th>
                                    <th scope='col'>Utente</th>
                                    <th scope='col' abbr='modello'>Modello Auto</th>
                                    <th scope='col' abbr='data'>Data <span lang='en-GB'>Test Drive</span></th>
                                    <th scope='col' >Stato</th>
                                </tr>
                            </thead>
                            <tbody>";
        
        if (empty($prenotazione)) {
            // Se non ci sono prenotazioni, mostro il messaggio corrispondente
            $campiTabella .= "
                            <tr>
                                <td colspan='5' id='prenIndispAdmin'>Non ci sono prenotazioni disponibili</td>
                            </tr>";
        } else {
            // Ciclo su ogni prenotazione per generare le righe
            foreach ($prenotazione as $row) {
                $statoTestuale = "";
                if ($row['stato'] == 1) {
                    $statoTestuale = "<span id='accettatoUtente'>Accettato</span>";
                } else if ($row['stato'] == -1) {
                    $statoTestuale = "<span id='rifiutatoUtente'>Rifiutato</span>";
                } else {
                    $statoTestuale = "<span id='attesaUtente'>In attesa</span>";
                }

                // Aggiungi una riga per la prenotazione
                $campiTabella .= "<tr>
                                    <td>" . $row["codice"] . "</td>
                                    <td>" . $row["username"] . "</td>
                                    <td>" . $row["marca"] . " " . $row['modello'] . "</td>
                                    <td><time datetime=''" . $row['dataOra'] . "'>" . $row['dataOra'] . "</time></td>
                                    <td>" . $statoTestuale . "</td>
                                  </tr>";
            }
            
        }
        $campiTabella .= "
                            </tbody>
                        </table>"; 
    } catch (Exception $e) {
        // Gestisco l'errore nel caso di problemi con la connessione
        header("location: 500.html");
        exit();
    }

    return $campiTabella; // Restituisco il markup generato della tabella
}

session_start();

// Controllo se l'amministratore è loggato
if (!isset($_SESSION["utente"])) {
    header("location: login.php");
    exit();
}
// Controllo se l'utente è loggato
if (isset($_SESSION["utente"]) && $_SESSION["utente"] !="admin") {
    header("location: utente.php");
    exit();
}

// Carico template html
$adminPage = file_get_contents('amministratore.html');

function setSelectPrenGest($adminPage) {//esecuzione della query
    try{
        $db = new DBConnection();
        $prenotazione = $db->getAllPrenotazioni();
        $db->closeConnection();

        unset($db);

        $prenotazioni = '';

        //inserimento veicoli nel select
        foreach($prenotazione as $row){
            $val = $row["codice"];

            if($row['stato'] == 0){
                //reimposto il valore settato se ci sono errori
                if(isset($_POST['gestPrenAdmin']) && $_POST['gestPrenAdmin'] == $val) {
                    $prenotazioni .= "<option value='" . $val . "' selected>Prenotazione numero " . $row["codice"] . "</option>";
                }
                else{
                    $prenotazioni .= "<option value='" . $val . "'>Prenotazione numero " . $row["codice"] . "</option>";
                }
            }
            
        }
        $adminPage = str_replace("[prenotazioni]", $prenotazioni, $adminPage);
        return $adminPage;

    } catch(Exception $e){
        header("location: 500.html");
        exit();
    }
}


//GESTIONE PRENOTAZIONI
$errGest = "";

if (isset($_POST['gestPrenAdmin'])) {

    // Controllo sull'input (validazione)
    if (empty($_POST['gestPrenAdmin']) || !preg_match("/^[0-9]+$/", $_POST["gestPrenAdmin"])) {
        $errGest .= "<p>Prenotazione selezionata non valida</p>";
    }

    // Controllo sull'azione scelta
    if ($_POST["azioneAdmin"] != "accetta" && $_POST["azioneAdmin"] != "rifiuta") {
        $errGest .= "<p>Azione selezionata non valida</p>";
    }

    // Restituzione errori in caso di problemi di validazione
    if (!empty($errGest)) {
        $adminPage = str_replace("[errGest]", $errGest, $adminPage);
        
    } else {

        if($_POST["azioneAdmin"] == "accetta"){
            $stato = 1;
        }else{
            $stato = -1;
        }

        // Recupero ID della prenotazione
        $idPrenotazione = explode("-", $_POST["gestPrenAdmin"])[0];
        $idPrenotazione = htmlspecialchars($idPrenotazione);

        // Tentativo di aggiornamento della prenotazione
        try {
            $db = new DBConnection();
            $ris = $db->updateStatoPrenotazione($idPrenotazione, $stato); // Assume che la funzione restituisca un booleano (true/false)
            $db->closeConnection();
            unset($db);

            if (!$ris) {
                // Prenotazione non trovata
                $errGest .= "<p>Prenotazione non esiste. (ID: " . $idPrenotazione . ")</p>";
            }

        } catch (Exception $e) {
            // Gestione errori e logging
            error_log("Errore: " . $e->getMessage());
            header("location: 500.html");
            exit();
        }
    }
}

// Aggiornamento della pagina con esito finale
$adminPage = str_replace("[errGest]", $errGest, $adminPage);

//TABELLA PRENOTAZIONI

$campiTabella = mostraTabellaPrenotazioni();
$adminPage = str_replace("[campiTabella]", $campiTabella, $adminPage);

// SELECT PRENOTAZIONI

$adminPage = setSelectPrenGest($adminPage);

//ELIMINA PRENOTAZIONE

function setSelectAutoElim($adminPage){
    //ESECUZIONE DELLA QUERY PER INSERIRE LE AUTO NEL SELECT
    try{
        $a = array();
        $db = new DBConnection();
        $ris = $db->getFilteredVehicles($a);
        $db->closeConnection();
        unset($db);
        $veicoliDaEliminare = '';
        //INSERIMENTO DEI VEICOLI NEL SELECT
        $marca = '';
        foreach($ris as $row){
            if($marca != $row["marca"]){
                if($marca == ''){
                    $marca = $row["marca"];
                    $veicoliDaEliminare .= "<optgroup label='". $marca . "'>";
                }
                else{
                    $marca = $row["marca"];
                    $veicoliDaEliminare .= "</optgroup><optgroup label='". $marca . "'>";
                }
            }
            $veicoliDaEliminare .= "<option value='" . $row["id"] . "-" . $row["marca"] . "-" . $row['modello'] . "'>" . $row["id"] . " - " . $row['modello'] ."</option>";
        }

        $adminPage = str_replace("[VeicoliDaEliminare]", $veicoliDaEliminare, $adminPage);
        return $adminPage;
    }
    catch(Exception $e){
        header("location: 500.html");
        exit();
    }
}

$errElim = '';
$succElim = '';

if(isset($_POST['eliminaAutoAdmin'])){
    if(empty($_POST['eliminaAutoAdmin'])){
        $errElim .= "<p>Devi compilare tutti i campi.</p>";
        $adminPage = str_replace("[errElim]", $errElim, $adminPage);
        $adminPage = str_replace("[succElim]", $succElim, $adminPage);
        $adminPage = setSelectAutoElim($adminPage);
        echo $adminPage;
        exit();
    }

    if(!preg_match("/^[A-Za-z0-9\-\s]+$/", $_POST["eliminaAutoAdmin"])){
        $errElim = $errElim . "<p>Auto selezionata non valida.</p>";
    }

    if(!empty($errElim)){
        $adminPage = str_replace("[errElim]", $errElim, $adminPage);
        $adminPage = str_replace("[succElim]", $succElim, $adminPage);
        $adminPage = setSelectAutoElim($adminPage);
        echo $adminPage;
        exit();
    }

    $idAuto = explode("-", $_POST["eliminaAutoAdmin"])[0];

    try{
        $db = new DBConnection();
        $ris = $db->deleteAuto($idAuto);
        $db->closeConnection();
        unset($db);

        if($ris == true){
            $succElim .= "<p>Auto eliminata con successo.</p>";
        }
        else{
            $errElim .= "<p>Auto non esiste. (ID: " . $idAuto . ")</p>";
        }

        $adminPage = str_replace("[errElim]", $errElim, $adminPage);
        $adminPage = str_replace("[succElim]", $succElim, $adminPage);
        $adminPage = setSelectAutoElim($adminPage);
    }
    catch(Exception $e){
        header("location: 500.html");
        exit();
    }
}
else{
    $adminPage = setSelectAutoElim($adminPage);
    $adminPage = str_replace("[errElim]", $errElim, $adminPage);
    $adminPage = str_replace("[succElim]", $succElim, $adminPage);
}

echo $adminPage;
?>