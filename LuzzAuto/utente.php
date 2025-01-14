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
        $campiTabella = "<tr><td colspan='5'>Non ci sono prenotazioni disponibili.</td></tr>";
    }else{
        foreach ($prenotazione as $row) {
            $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'] . "-" . $row['dataOra'] . "-" . $row['stato']; 
            $campiTabella .= "<tr>
                                <td>" . $row["codice"] . "</td>
                                <td>" . $row["marca"] . " " . $row['modello'] . "</td>
                                <td>" . $row['dataOra'] . "</td>
                                <td>" . $row['stato'] . "</td>
                              </tr>";
        } 

    }  
    $pagina = str_replace("[campiTabella]", $campiTabella, $pagina);

}   
catch(Exception $e){
    header("location: 500.html");
    exit();
}





//GESTIONE PRENOTAZIONE
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



echo $pagina;
?>
























