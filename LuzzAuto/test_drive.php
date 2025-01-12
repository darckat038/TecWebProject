<?php

require_once 'dbConnection.php';
use DB\DBConnection;

$test_driveHTML = file_get_contents('test_drive.html');

$err = "";

$formORbuttonsHTML = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
session_start();
if (isset($_SESSION["utente"])) {
	$formORbuttonsHTML = "
    
    <form id='test_drive_form' method='post'>
        <fieldset>

            <legend>Prenota <span lang='en-GB'>Test Drive</span></legend>

            <label id='test_drive_label_auto' for='test_drive_select_auto'>Auto</label>
            <select name='test_drive_select_auto' id='test_drive_select_auto' class='test_drive_input' aria-required='true' aria-label='Campo di scelta della macchina' required data-msg-required='Per favore, seleziona la macchina' data-msg-invalid:='Ci dispiace, formato non corretto'>
                <option value='a'>a</option>
                <option value='a'>a</option>
                <option value='a'>a</option>
                <option value='a'>a</option>
                <option value='a'>a</option>
            </select>

            <label id='test_drive_label_date' for='test_drive_date'>Data e ora</label>
            <input id='test_drive_date' class='test_drive_input' type='datetime-local' name='test_drive_date' aria-required='true' aria-label='Campo di inserimento della data e ora della prenotazione' required data-msg-required='Per favore, inserisci data e ora della prenotazione'>
    
            <input id='test_drive_prenotaBtn' type='submit' value='INVIA RICHIESTA' aria-label='Bottone di invio del form'>

        </fieldset>
                    
    </form>

    <div class='form_errors'>
        [err]
    </div>
    
    ";
}
else{
    $formORbuttonsHTML = "
    
    <p>Accedi al tuo profilo per usufruire del servizio di <span lang='en-GB'>Test Drive</span> :</p>
    <a href='login.html' onclick='setBackToOriginTestDrive()'>LogIn</a>

    <p>Oppure crea un <span lang='en-GB'>account</span> :</p>
    <a href='registrazione.html' onclick='setBackToOriginTestDrive()'>SignIn</a>
    
    ";
}

$test_driveHTML = str_replace("[formORbuttons]", $formORbuttonsHTML, $test_driveHTML);
$test_driveHTML = str_replace("[err]", $err, $test_driveHTML);
echo $test_driveHTML;

?>