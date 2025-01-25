<?php

require_once 'dbConnection.php';
use DB\DBConnection;

function ripristinoInput($adminPage) {
    //RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
    $adminPage = str_replace('[imageOut]', htmlspecialchars(isset($_POST['immagineOutAdmin']) ? $_POST['immagineOutAdmin'] : ''), $adminPage);
    $adminPage = str_replace('[altOut]', htmlspecialchars(isset($_POST['altImmagineOutAdmin']) ? $_POST['altImmagineOutAdmin'] : ''), $adminPage);
    $adminPage = str_replace('[imageIn]', htmlspecialchars(isset($_POST['immagineInAdmin']) ? $_POST['immagineInAdmin'] : ''), $adminPage);
    $adminPage = str_replace('[altIn]', htmlspecialchars(isset($_POST['altImmagineInAdmin']) ? $_POST['altImmagineInAdmin'] : ''), $adminPage);
	$adminPage = str_replace('[marca]', htmlspecialchars(isset($_POST['marcaAdmin']) ? $_POST['marcaAdmin'] : ''), $adminPage);
	$adminPage = str_replace('[modello]', htmlspecialchars(isset($_POST['modelloAdmin']) ? $_POST['modelloAdmin'] : ''), $adminPage);
	$adminPage = str_replace('[anno]', htmlspecialchars(isset($_POST['annoAdmin']) ? $_POST['annoAdmin'] : ''), $adminPage);
    $adminPage = str_replace("[colore]", htmlspecialchars(isset($_POST['coloreAdmin']) ? $_POST['coloreAdmin'] : ''), $adminPage);

    if(htmlspecialchars(isset($_POST['alimentazioneAdmin']))) {
		$adminPage = str_replace("[" . $_POST['alimentazioneAdmin'] . "]", "selected ", $adminPage);
	}
	$adminPage = str_replace(["[benzina]", "[gasolio]", "[elettrico]", "[metano]", "[ibrido]"], ["", "", "", "", ""], $adminPage);

    if(htmlspecialchars(isset($_POST['cambioAdmin']))) {
		$adminPage = str_replace("[" . $_POST['cambioAdmin'] . "]", "selected ", $adminPage);
	}
	$adminPage = str_replace(["[manuale]", "[automatico]"], ["", ""], $adminPage);

    if(htmlspecialchars(isset($_POST['trazioneAdmin']))) {
		$adminPage = str_replace("[" . $_POST['trazioneAdmin'] . "]", "selected ", $adminPage);
	}
	$adminPage = str_replace(["[anteriore]", "[posteriore]", "[integrale]"], ["", "", ""], $adminPage);

    $adminPage = str_replace("[potenza]", htmlspecialchars(isset($_POST['potenzaAdmin']) ? $_POST['potenzaAdmin'] : ''), $adminPage);
    $adminPage = str_replace("[peso]", htmlspecialchars(isset($_POST['pesoAdmin']) ? $_POST['pesoAdmin'] : ''), $adminPage);
    $adminPage = str_replace("[posti]", htmlspecialchars(isset($_POST['numero_postiAdmin']) ? $_POST['numero_postiAdmin'] : ''), $adminPage);
    $adminPage = str_replace("[potenza]", htmlspecialchars(isset($_POST['potenzaAdmin']) ? $_POST['potenzaAdmin'] : ''), $adminPage);

    if(htmlspecialchars(isset($_POST['condizioneAdmin']))) {
		$adminPage = str_replace("[" . $_POST['condizioneAdmin'] . "]", "selected ", $adminPage);
	}
	$adminPage = str_replace(["[nuovo]", "[usato]", "[km0]"], ["", "", ""], $adminPage);

    $adminPage = str_replace("[chilometraggio]", htmlspecialchars(isset($_POST['chilometraggioAdmin']) ? $_POST['chilometraggioAdmin'] : ''), $adminPage);
    $adminPage = str_replace("[prezzo]", htmlspecialchars(isset($_POST['prezzoAdmin']) ? $_POST['prezzoAdmin'] : ''), $adminPage);

    $adminPage = str_replace("[neopatentati]", htmlspecialchars(isset($_POST['neopatentatiAdmin']) && intval($_POST["neopatentatiAdmin"]) == 1 ? 'checked ' : ''), $adminPage);
	
    return $adminPage;
}

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
                                    <th scope='row' data-title='Codice'>" . $row["codice"] . "</th>
                                    <td data-title='Utente'>" . $row["username"] . "</td>
                                    <td data-title='Auto'>" . $row["marca"] . " " . $row['modello'] . "</td>
                                    <td data-title='Data'><time datetime=''" . $row['dataOra'] . "'>" . $row['dataOra'] . "</time></td>
                                    <td data-title='Stato'>" . $statoTestuale . "</td>
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
        $errGest .= "<p>La prenotazione che hai selezionato non &egrave; valida</p>";
    }

    // Controllo sull'azione scelta
    if ($_POST["azioneAdmin"] != "accetta" && $_POST["azioneAdmin"] != "rifiuta") {
        $errGest .= "<p>L'azione che hai selezionato non &egrave; valida</p>";
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
                $errGest .= "<p>La prenotazione che hai selezionato non esiste. (ID: " . $idPrenotazione . ")</p>";
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

// SELECT GESTIONE PRENOTAZIONI

$adminPage = setSelectPrenGest($adminPage);

// AGGIUNGI AUTO


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
            $veicoliDaEliminare .= "<option value='" . $row["id"] . "'>" . $row["id"] . " - " . $row['modello'] ."</option>";
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

    if(!preg_match("/^[0-9]+$/", $_POST["eliminaAutoAdmin"])){
        $errElim = $errElim . "<p>L'auto che hai selezionato non &egrave; valida.</p>";
    }

    if(!empty($errElim)){
        $adminPage = str_replace("[errElim]", $errElim, $adminPage);
        $adminPage = str_replace("[succElim]", $succElim, $adminPage);
        $adminPage = setSelectAutoElim($adminPage);
        echo $adminPage;
        exit();
    }

    $idAuto = $_POST["eliminaAutoAdmin"];

    try{
        $db = new DBConnection();
        $ris = $db->deleteAuto($idAuto);
        $db->closeConnection();
        unset($db);

        if($ris == true){
            $succElim .= "<p>Auto eliminata con successo.</p>";
        }
        else{
            $errElim .= "<p>L'auto che hai selezionato non esiste. (ID: " . $idAuto . ")</p>";
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