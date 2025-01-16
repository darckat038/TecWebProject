<?php

function ripristinoInput($test_driveHTML){
	//RIPRISTINO DELL'INPUT INSERITO
    $a = $test_driveHTML;
	$a = str_replace("[data]", htmlspecialchars(isset($_POST['test_drive_date']) ? $_POST['test_drive_date'] : ''), $a);
	return $a;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$test_driveHTML = file_get_contents('test_drive.html');

$err = "";

$succ = "";

$formORbuttonsHTML = "";

$formHTML = "
        
        <form id='test_drive_form' method='post' action='test_drive.php#test_drive_prenota'>
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

        <div class='form_success'>
            [succ]
        </div>
        
        ";
$buttonsHTML = "

<p>Accedi al tuo profilo per usufruire del servizio di <span lang='en-GB'>Test Drive</span> :</p>
<a href='login.html' onclick='setBackToOriginTestDrive()'>LogIn</a>

<p>Oppure crea un <span lang='en-GB'>account</span> :</p>
<a href='registrazione.html' onclick='setBackToOriginTestDrive()'>SignIn</a>

";

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
            $val = $row["id"] . "-" . $row["marca"] . "-" . $row['modello'];
            //REIMPOSTO IL VALORE SETTATO
            if((isset($_POST['test_drive_select_auto']) && $_POST['test_drive_select_auto'] == $val) || (isset($_COOKIE['auto_details_id']) && $_COOKIE['auto_details_id'] == $row["id"])){
                $veicoli .= "<option value='" . $row["id"] . "-" . $row["marca"] . "-" . $row['modello'] . "' selected>" . $row["id"] . " - " . $row["marca"] . " " . $row['modello'] ."</option>";
            }
            else{
                $veicoli .= "<option value='" . $row["id"] . "-" . $row["marca"] . "-" . $row['modello'] . "'>" . $row["id"] . " - " . $row["marca"] . " " . $row['modello'] ."</option>";
            }
        }
        if(isset($_COOKIE['auto_details_id'])){
            setcookie("auto_details_id", "", time()-7200, "/");
        }
        $test_driveHTML = ripristinoInput($test_driveHTML);
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



if(isset($_POST['test_drive_select_auto']) && isset($_POST['test_drive_date'])){

    if(empty($_POST['test_drive_date']) || empty($_POST['test_drive_select_auto'])){
        $err = $err . "<p>Devi compilare tutti i campi.</p>";
        $test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
        $test_driveHTML = str_replace("[succ]", $succ, $test_driveHTML);
		$test_driveHTML = ripristinoInput($test_driveHTML);
        echo $test_driveHTML;
        exit();
    }
    else{

        //CONTROLLI SULL'INPUT
        if (!preg_match("/^[A-Za-z0-9\-\s]+$/", $_POST["test_drive_select_auto"])) {
			$err = $err . "<p>Auto non valida</p>";
		}
        $_POST["test_drive_date"] = str_replace("T", ' ', $_POST["test_drive_date"]) . ":00";
        if (strtotime($_POST["test_drive_date"]) < strtotime(date("Y-m-d H:i:s")) || !preg_match('/^[0-9\-\:\s]+$/', $_POST["test_drive_date"])) {
			$err = $err . "<p>La data non è valida.</p>";
		}

        //CONTROLLO ERRORI
		if (!empty($err)) {
			$test_driveHTML = ripristinoInput($test_driveHTML);
            $test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
            $test_driveHTML = str_replace("[succ]", $succ, $test_driveHTML);
            echo $test_driveHTML;
            exit();
		}
        
        //esecuzione query (controllo se auto esiste nella query)
        //far comparire una scritta verde 'richiesta inviata con successo e un link a area personale'

        $idAuto = explode("-", $_POST["test_drive_select_auto"])[0];

        //ESECUZIONE DELLA QUERY
		try{
			$db = new DBConnection();
			$ris = $db->insertPrenotazione($_SESSION["utente"], $idAuto, $_POST["test_drive_date"]);
			$db->closeConnection();
			unset($db);
			if($ris == -1){
				$err = $err . "<p>L'<span lang='en-GB'>Auto</span> non esiste. (" . $idAuto . ")</p>";
			}
            if($ris == -2){
                $err = $err . "<p>Questa prenotazione esiste già</p>" . "<p>Visita la tua <a href='utente.php'>Area personale</a>";
            }
            if($ris==1){
                //PRENOTAZIONE INVIATA CON SUCCESSO
                $succ .= "<p> Prenotazione inviata con SUCCESSO.</p>" . 
                "<p>Visita la tua <a href='utente.php#prenotazioni_utente'>Area personale</a> per visualizzarne i dettagli.</p>";
            }
            if($ris==0){
                header("location: 500.html");
                exit();
            }
			
		}
		catch(Exception){
			header("location: 500.html");
			exit();
		}


		$test_driveHTML = ripristinoInput($test_driveHTML);
    }


}


$test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
$test_driveHTML = str_replace("[succ]", $succ, $test_driveHTML);
echo $test_driveHTML;
?>