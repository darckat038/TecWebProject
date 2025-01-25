<?php

require_once 'dbConnection.php';
use DB\DBConnection;

function ripristinoInput($adminPage) {
    //RIPRISTINO DELL'INPUT INSERITO FORM INSERISCI AUTO
	// Se c'è input salvato in $_POST, mette quello, altrimenti valore di default (stringa vuota o select default)
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
                if($row['dataOra'] >= date("Y-m-d H:i:s")) {
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
                if($row['dataOra'] >= date("Y-m-d H:i:s")) {
                    //reimposto il valore settato se ci sono errori
                    if(isset($_POST['gestPrenAdmin']) && $_POST['gestPrenAdmin'] == $val) {
                        $prenotazioni .= "<option value='" . $val . "' selected>Prenotazione numero " . $row["codice"] . "</option>";
                    }
                    else{
                        $prenotazioni .= "<option value='" . $val . "'>Prenotazione numero " . $row["codice"] . "</option>";
                    }
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
if(isset($_POST['aggiungiAutoAdmin'])){

    // Controllo sull'input (verifico che l'admin abbia compilato tutti i campi)
    if (empty($_POST['immagineOutAdmin']) || empty($_POST['altImmagineOutAdmin']) || empty($_POST['immagineInAdmin']) || 
        empty($_POST['altImmagineInAdmin']) || empty($_POST['marcaAdmin']) || empty($_POST['modelloAdmin']) || empty($_POST['annoAdmin']) || 
        empty($_POST['coloreAdmin']) || empty($_POST['alimentazioneAdmin']) || empty($_POST['cambioAdmin']) || empty($_POST['trazioneAdmin']) || 
        empty($_POST['potenzaAdmin']) || empty($_POST['pesoAdmin']) || empty($_POST['numero_postiAdmin']) || empty($_POST['condizioneAdmin']) || 
        empty($_POST['chilometraggioAdmin']) || empty($_POST['prezzoAdmin']) || !isset($_POST['neopatentatiAdmin'])) {

        $errAggiungi = "<p>Devi compilare tutti i campi.</p>";
        $adminPage = ripristinoInput($adminPage);
        $adminPage = str_replace("[errAdd]", $errAggiungi, $adminPage);
    }

    //CONTROLLI SULL'INPUT

    if (!preg_match("/^([A-Za-z0-9,.]+( [A-Za-z0-9,.]+)*)?$/", $_POST["altImmagineOutAdmin"]) || strlen($_POST["altImmagineOutAdmin"]) > 100) {
        $errAggiungi = $errAggiungi . "<p id=\"altImmagineOut_err\">L'alternativa testuale che hai inserito riguardante la prima immagine non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e i caratteri virgola e punto. Non devi superare i 100 caratteri di lunghezza.</p>";
    }
    if (!preg_match("/^([A-Za-z0-9,.]+( [A-Za-z0-9,.]+)*)?$/", $_POST["altImmagineInAdmin"]) || strlen($_POST["altImmagineInAdmin"]) > 100) {
        $errAggiungi = $errAggiungi . "<p id=\"altImmagineOut_err\">L'alternativa testuale che hai inserito riguardante la seconda immagine non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e i caratteri virgola e punto. Non devi superare i 100 caratteri di lunghezza.</p>";
    }
    if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_POST["marca"])) {
        $errAggiungi = $errAggiungi . "<p id=\"marca_err\">La marca che hai inserito non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
    }
    if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_POST["modello"])) {
        $errAggiungi = $errAggiungi . "<p id=\"modello_err\">Il modello che hai inserito non &egrave; valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
    }
    if (is_numeric($_POST["anno"]) && (!preg_match("/^\d{1,4}$/", $_POST["anno"]) || intval($_POST["anno"]) <= 0)) {
        $errAggiungi = $errAggiungi . "<p id=\"anno_err\">L'anno che hai inserito non &egrave; valido, inserisci un anno maggiore di 0 e di massimo 4 cifre.</p>";
    }
    if (!preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_POST["colore"])) {
        $errAggiungi = $errAggiungi . "<p id=\"colore_err\">Il colore che hai inserito non &egrave; valido, puoi usare solo lettere e spazi(non all'inizio e alla fine).</p>";
    }
    if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_POST["alimentazione"])) {
        $errAggiungi = $errAggiungi . "<p id=\"alimentazione_err\">Hai selezionato un'alimentazione non valida. Seleziona nuovamente la scelta desiderata.</p>";
    }
    if (!preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_POST["cambio"])) {
        $errAggiungi = $errAggiungi . "<p id=\"cambio_err\">Hai selezionato un tipo di cambio non valido. Seleziona nuovamente la scelta desiderata.</p>";
    }
    if (!preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_POST["trazione"])) {
        $errAggiungi = $errAggiungi . "<p id=\"trazione_err\">Hai selezionato un tipo di trazione non valido. Seleziona nuovamente la scelta desiderata.</p>";
    }
    if (is_numeric($_POST["potenza"])) {
        if (!preg_match("/^(\d+)?$/", $_POST["potenza"]) || intval($_POST["potenza"]) <= 0) {
            $errAggiungi = $errAggiungi . "<p id=\"potenzaMin_err\">Hai inserito una potenza non valida, inserisci una potenza maggiore di 0.</p>";
        }
    }
    if (is_numeric($_POST["peso"])) {
        if (!preg_match("/^(\d+)?$/", $_POST["peso"]) || intval($_POST["peso"]) <= 0) {
            $errAggiungi = $errAggiungi . "<p id=\"pesoMin_err\">Hai inserito un peso non valido, inserisci un peso maggiore di 0.</p>";
        }
    }
    if (is_numeric($_POST["posti"]) && (!preg_match("/^(\d+)?$/", $_POST["anno"]) || intval($_POST["anno"]) <= 0)) {
        $errAggiungi = $errAggiungi . "<p id=\"posti_err\">Hai inserito un numero di posti non valido, inserisci un numero maggiore di 0.</p>";
    }
    if (!preg_match("/^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/", $_POST["condizione"])) {
        $errAggiungi = $errAggiungi . "<p id=\"condizione_err\">hai selezionato una condizione non valida. Seleziona nuovamente la scelta desiderata.</p>";
    }
    if (is_numeric($_POST["prezzoMax"]) && (!preg_match("/^(\d+)?$/", $_POST["prezzoMax"]) || intval($_POST["prezzoMax"]) <= 0)) {
            $errAggiungi = $errAggiungi . "<p id=\"prezzoMax_err\">Hai inserito un prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
    }
    if (is_numeric($_POST["chilometraggio"]) && (!preg_match("/^(\d+)?$/", $_POST["chilometraggio"]) || intval($_POST["chilometraggio"]) <= 0)) {
        $errAggiungi = $errAggiungi . "<p id=\"chilometraggio_err\">Hai inserito un chilometraggio non valido, inserisci un valore maggiore di 0.</p>";
    }
    if (!empty($_POST["neopatentati"]) && intval($_POST["neopatentati"]) != 1) {
        $errAggiungi = $errAggiungi . "<p id=\"neopatentati_err\">Hai selezionato un valore di neopatentati non valido. Seleziona nuovamente la scelta desiderata.</p>";
    }

    /*
    // Restituzione errori in caso di problemi di validazione
    if (!empty($errGest)) {
        $adminPage = str_replace("[errAdd]", $errGest, $adminPage);
        
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
        */
}

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