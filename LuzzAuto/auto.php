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
        <h2>Dettagli</h2>
        <dl>
            <div>
                <dd>Anno</dd>
                <dt>' . $dettagli['anno'] . '</dt>
            </div>
            <div>
                <dd>Chilometraggio</dd>
                <dt>' . $dettagli['chilometraggio'] . ' km</dt>
            </div>
            <div>
                <dd>Colore</dd>
                <dt>' . $dettagli['colore'] . '</dt>
            </div>
            <div>
                <dd>Alimentazione</dd>
                <dt>' . $dettagli['alimentazione'] . '</dt>
            </div>
            <div>
                <dd>Cambio</dd>
                <dt>' . $dettagli['cambio'] . '</dt>
            </div>
            <div>
                <dd>Trazione</dd>
                <dt>' . $dettagli['trazione'] . '</dt>
            </div>
            <div>
                <dd>Potenza</dd>
                <dt>' . $dettagli['potenza'] . ' CV</dt>
            </div>
            <div>
                <dd>Peso</dd>
                <dt>' . $dettagli['peso'] . ' kg</dt>
            </div>
            <div>
                <dd>Neopatentati abilitati</dd>
                <dt>' . (($dettagli['neopatentati']==1)?'Sì':'No') . '</dt>
            </div>
            <div>
                <dd>Posti</dd>
                <dt>' . $dettagli['numeroPosti'] . '</dt>
            </div>
        </dl>';

    } else {
        $stringaDettagli = "
            <h2>Qualcuno potrebbe aver portato il veicolo all'autolavaggio</h2>
            <p>Non siamo riusciti a trovare i dettagli del veicolo specificato.</p>
            ";
    }

    echo str_replace(search: "[dettagli_auto]", replace: $stringaDettagli, subject: $autoHTML);
} catch(Exception){
    header("location: 500.html");
    exit();
}

?>