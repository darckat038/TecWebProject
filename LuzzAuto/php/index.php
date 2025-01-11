<?php
    
require_once ".." . DIRECTORY_SEPARATOR . "php_sessions" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR . "index.html");

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$imgVeicoli = array();
$DM_Mudol = "";
$ESU_Belzuny = "";
$UNIPD_Planetary = "";

if ($connessioneOK) {

	$imgVeicoli = $connessione->getFilteredVehicles();

	$connessione->closeConnection();

	if(count($imgVeicoli) > 0) {
        
        //Ricavo immagine DM Mudol
        if($imgVeicoli['marca'] == "DM" && $imgVeicoli['modello'] == "Mudol") {
            $DM_Mudol = '<img id="home_first_image" src="' . $imgVeicoli['imgEsterna'] . '" alt="Berlina sportiva blu elettrico vista davanti sinistra">';
        }

        //Ricavo immagine ESU Belzuny
        if($imgVeicoli['marca'] == "ESU" && $imgVeicoli['modello'] == "Belzuny") {
            $ESU_Belzuny = '<img id="home_second_image" src="' . $imgVeicoli['imgEsterna'] . '" alt="Suv di lusso sportivo rosso vista frontale su sfondo roccioso">';
        }

        //Ricavo immagine UniPD Planetary
        if($imgVeicoli['marca'] == "UniPD" && $imgVeicoli['modello'] == "Planetary") {
            $ESU_Belzuny = '<img id="home_third_image" src="' . $imgVeicoli['imgEsterna'] . '" alt="Minivan premium blu metallizzato futuristico vista davanti destra">';
        }

    } else {
        $DM_Mudol = '<img id="home_first_image" src="" alt="Berlina sportiva blu elettrico vista davanti sinistra">';
        $ESU_Belzuny = '<img id="home_second_image" src="" alt="Suv di lusso sportivo rosso vista frontale su sfondo roccioso">';
        $UNIPD_Planetary = '<img id="home_third_image" src="" alt="Minivan premium blu metallizzato futuristico vista davanti destra">';
    }

} else {

    $DM_Mudol = '<img id="home_first_image" src="" alt="Berlina sportiva blu elettrico vista davanti sinistra">';
    $ESU_Belzuny = '<img id="home_second_image" src="" alt="Suv di lusso sportivo rosso vista frontale su sfondo roccioso">';
    $UNIPD_Planetary = '<img id="home_third_image" src="" alt="Minivan premium blu metallizzato futuristico vista davanti destra">';

}

// Rimpiazzo segnaposto con immagini

$paginaHTML = str_replace("[IMG_DM_MUDOL]", $DM_Mudol, $paginaHTML);
$paginaHTML = str_replace("[IMG_ESU_BELZUNY]", $ESU_Belzuny, $paginaHTML);
$paginaHTML = str_replace("[IMG_UNIPD_PLANETARY]", $UNIPD_Planetary, $paginaHTML);

/*
echo str_replace("[IMG_DM_STEMMA]", $DM_Stemma, $paginaHTML);
echo str_replace("[IMG_ESU_STEMMA]", $ESU_Stemma, $paginaHTML);
echo str_replace("[IMG_EXFIAT_STEMMA]", $EXFIAT_Stemma, $paginaHTML);
echo str_replace("[IMG_UNIPD_STEMMA]", $UNIPD_Stemma, $paginaHTML);
echo str_replace("[IMG_AUDI_STEMMA]", $AUDI_Stemma, $paginaHTML);
echo str_replace("[IMG_FORD_STEMMA]", $FORD_Stemma, $paginaHTML);
echo str_replace("[IMG_OPEL_STEMMA]", $OPEL_Stemma, $paginaHTML);
echo str_replace("[IMG_TESLA_STEMMA]", $TESLA_Stemma, $paginaHTML);
*/

?>