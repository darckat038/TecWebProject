<?php

require_once "dbConnection.php";
use DB\DBConnection;

$autoHTML = file_get_contents(filename: 'auto.html');

try {
    $connessione = new DBConnection();
    $dettagli = $connessione->getVehicleDetails($_GET['id']);
    $connessione->closeConnection();

    if ($dettagli != -1) {
        $immagini = "";
        $fotos = explode(separator: "+", string: $dettagli['foto']); // Divide la stringa in un array di nomi di foto

        // Itera sull'array dei nomi di foto
        foreach ($fotos as $foto) {
            // Genera il codice HTML per ogni immagine
            $immagini .= '<img src="assets/img/Cars/' . htmlspecialchars(string: $dettagli['marca']) . '/' . htmlspecialchars(string: $foto) . '" alt="Immagine auto">';
        }

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

        $stringaBottoni = '
        <dl>
            <dd>Marca</dd>
            <dt>' . $dettagli['marca'] . '</dt>
            <dd>Modello</dd>
            <dt>' . $dettagli['modello'] . '</dt>
            <dd>Condizioni</dd>
            <dt>' . $dettagli['condizione'] . '</dt>
            <dd>Prezzo</dd>
            <dt>€ ' . $dettagli['prezzo'] . '</dt>
        </dl>

        <a class="list_button" href="">Prenota un test drive</a>';

    } else {
        $immagini = "<img src=\"assets/img/Content/auto_non_trovata.png\" alt=\"Auto ricoperta di schiuma\">";
        $stringaDettagli = "
            <h2>Qualcuno potrebbe aver portato il veicolo all'autolavaggio</h2>
            <p>Non riusciamo a trovare i dettagli del veicolo specificato.</p>
            ";
        $stringaBottoni = "";
    }

    $autoHTML = str_replace(search: "[immagini_auto]", replace: $immagini, subject: $autoHTML);
    $autoHTML = str_replace(search: "[dettagli_auto]", replace: $stringaDettagli, subject: $autoHTML);
    echo str_replace(search: "[bottoni_auto]", replace: $stringaBottoni, subject: $autoHTML);
} catch(Exception){
    header(header: "location: 500.html");
    exit();
}

?>