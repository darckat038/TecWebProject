<?php

function ripristinoInput($test_driveHTML){
	//RIPRISTINO DELL'INPUT INSERITO
    $a = $test_driveHTML;
	$a = str_replace("[auto]", htmlspecialchars(isset($_POST['test_drive_select_auto']) ? $_POST['test_drive_select_auto'] : ''), $a);
	$a = str_replace("[data]", htmlspecialchars(isset($_POST['test_drive_date']) ? $_POST['test_drive_date'] : ''), $a);
	return $a;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$test_driveHTML = file_get_contents('test_drive.html');

$err = "";

$formORbuttonsHTML = "";
$formHTML = "
        
        <form id='test_drive_form' method='post'>
            <fieldset>

                <legend>Prenota <span lang='en-GB'>Test Drive</span></legend>

                <label id='test_drive_label_auto' for='test_drive_select_auto'>Auto</label>
                <select name='test_drive_select_auto' id='test_drive_select_auto' class='test_drive_input' aria-required='true' aria-label='Campo di scelta della macchina' required data-msg-required='Per favore, seleziona la macchina' data-msg-invalid:='Ci dispiace, formato non corretto'>
                    <option value=''>--seleziona--</option>
                    [veicoli]
                </select>

                <label id='test_drive_label_date' for='test_drive_date'>Data e ora</label>
                <input id='test_drive_date' class='test_drive_input' type='datetime-local' name='test_drive_date' aria-required='true' aria-label='Campo di inserimento della data e ora della prenotazione' required data-msg-required='Per favore, inserisci data e ora della prenotazione' value='[data]'>
        
                <input id='test_drive_prenotaBtn' type='submit' value='INVIA RICHIESTA' aria-label='Bottone di invio del form'>

            </fieldset>
                        
        </form>

        <div class='form_errors'>
            [err]
        </div>
        
        ";
$buttonsHTML = "

<p>Accedi al tuo profilo per usufruire del servizio di <span lang='en-GB'>Test Drive</span> :</p>
<a href='login.html' onclick='setBackToOriginTestDrive()'>LogIn</a>

<p>Oppure crea un <span lang='en-GB'>account</span> :</p>
<a href='registrazione.html' onclick='setBackToOriginTestDrive()'>SignIn</a>

";



if(isset($_POST['test_drive_select_auto']) && isset($_POST['test_drive_date'])){
    if(empty($_POST['test_drive_date']) || empty($_POST['test_drive_select_auto'])){
        $formORbuttonsHTML = $formHTML;
        $test_driveHTML = str_replace("[formORbuttons]", $formORbuttonsHTML, $test_driveHTML);

        //ESECUZIONE DELLA QUERY
        try{
            $a = array();
            $db = new DBConnection();
            $ris = $db->getFilteredVehicles($a);
            $db->closeConnection();
            unset($db);
            $veicoli = '';
            //INSERIMENTO DEI VEICOLI NEL SELECT
            foreach($ris as $row){
                $val = $row["marca"] . "-" . $row['modello'];
                //REIMPOSTO IL VALORE SETTATO
                if($_POST['test_drive_select_auto'] == $val){
                    $veicoli .= "<option value='" . $row["marca"] . "-" . $row['modello'] . "' selected>" . $row["marca"] . " " . $row['modello'] ."</option>";
                }
                else{
                    $veicoli .= "<option value='" . $row["marca"] . "-" . $row['modello'] . "'>" . $row["marca"] . " " . $row['modello'] ."</option>";
                }
                
            }
            $test_driveHTML = str_replace("[veicoli]", $veicoli, $test_driveHTML);
        }
        catch(Exception $e){
            header("location: 500.html");
            exit();
        }

        $err = $err . "<p>Devi compilare tutti i campi.</p>";
        $test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
		$test_driveHTML = ripristinoInput($test_driveHTML);
        echo $test_driveHTML;
        exit();
    }
    else{
        //CONTROLLI SULL'INPUT sia di veicolo perchè potrebbe essere cambiato da ispeziona che di data non al passato
        //controllo errori
        //esecuzione query
        //far comparire una scritta verde 'richiesta inviata con successo e un link a area personale'
    }


}
else{
    //CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
    session_start();
    if (isset($_SESSION["utente"])) {
        //IMPOSTO HTML DEL FORM
        $formORbuttonsHTML = $formHTML;

        $test_driveHTML = str_replace("[formORbuttons]", $formORbuttonsHTML, $test_driveHTML);
    
        //ESECUZIONE DELLA QUERY
        try{
            $a = array();
            $db = new DBConnection();
            $ris = $db->getFilteredVehicles($a);
            $db->closeConnection();
            unset($db);
            $veicoli = '';
            //INSERIMENTO DEI VEICOLI NEL SELECT
            foreach($ris as $row){
                $veicoli .= "<option value='" . $row["marca"] . "-" . $row['modello'] . "'>" . $row["marca"] . " " . $row['modello'] ."</option>";
            }
            $test_driveHTML = str_replace("[veicoli]", $veicoli, $test_driveHTML);
        }
        catch(Exception $e){
            header("location: 500.html");
            exit();
        }


    }
    else{
        //IMPOSTO HTML DEI BOTTONI
        $formORbuttonsHTML = $buttonsHTML;

        $test_driveHTML = str_replace("[formORbuttons]", $formORbuttonsHTML, $test_driveHTML);
    }

    $test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
    echo $test_driveHTML;

}


?>