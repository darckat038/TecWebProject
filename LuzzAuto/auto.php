<?php

require_once "dbConnection.php";
use DB\DBConnection;

$autoHTML = file_get_contents('auto.html');

try {
    $connessione = new DBConnection();
    $dettagli = $connessione->getVehicleDetails($_GET['id']);
    $connessione->closeConnection();

    if ($dettagli != -1) {
        $stringaDettagli = '
        <div>
            <dd>Anno</dd>
            <dt>' . $dettagli['anno'] . '</dt>
        </div>
        <div>
            <dd>Chilometraggio</dd>
            <dt>' . $dettagli['chilometraggio'] . 'km</dt>
        </div>
        <div>
            <dd>Colore</dd>
            <dt>Blu chiaro</dt>
        </div>
        <div>
            <dd>Alimentazione</dd>
            <dt>Elettrico</dt>
        </div>
        <div>
            <dd>Cambio</dd>
            <dt>Automatico</dt>
        </div>
        <div>
            <dd>Trazione</dd>
            <dt>Integrale</dt>
        </div>
        <div>
            <dd>Potenza</dd>
            <dt>490 CV</dt>
        </div>
        <div>
            <dd>Peso</dd>
            <dt>1765 kg</dt>
        </div>
        <div>
            <dd>Neopatentati abilitati</dd>
            <dt>No</dt>
        </div>
        <div>
            <dd>Posti</dd>
            <dt>5</dt>
        </div>';

    } else {
        $stringaDettagli = "
            <h3>Qualcuno potrebbe aver portato il veicolo all'autolavaggio</h3>
            <p>Non siamo riusciti a trovare i dettagli del veicolo specificato.</p>
            ";
    }
    echo $dettagli;
    echo str_replace("[dettagli_auto]", $stringaDettagli, $autoHTML);

} catch(Exception){
    header("location: 500.html");
    exit();
}

?>                       
                            