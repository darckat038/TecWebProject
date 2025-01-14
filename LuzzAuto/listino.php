<?php

require_once "dbConnection.php";
use DB\DBConnection;

function ripristinoInput($listinoHTML) {
	// $listinoHTML = file_get_contents("listino.html");
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$listinoHTML = str_replace('[marca]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['marca']) ? $_GET['marca'] : '')), $listinoHTML);
	$listinoHTML = str_replace('[modello]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['modello']) ? $_GET['modello'] : '')), $listinoHTML);
	$listinoHTML = str_replace('[anno]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['anno']) ? $_GET['anno'] : '')), $listinoHTML);
	
	// rimpiazzo di default -> seleziono qualsiasi
	
	try {
		$db = new DBConnection();

		$params = array();

		$colori = $db->getAllVehicleColors();

		$db->closeConnection();
		unset($db);

		$listaColori = '';
		array_unshift($colori, "Qualsiasi");

		foreach($colori as $color) {
			//replace colore
			if(isset($_COOKIE["isFilterRemoved"]) || !(isset($_GET['colore']) && $_GET['colore'] == strtolower($color))) {
				$listaColori .= '<option ' . (strcmp(strtolower($color),"qualsiasi") !== 0 ? 'value="' . strtolower($color) : 'selected value="qualsiasi') . '">' . $color . '</option>';
			}
			else {
				$listaColori .= '<option selected value="' . (strcmp(strtolower($color),"qualsiasi") !== 0 ? strtolower($color) : "qualsiasi") . '">' . $color . '</option>';
			}
		}
	} catch(Exception $e) {
		header("location: 500.html");
		exit();
	}
	$listinoHTML = str_replace("[colori]", $listaColori, $listinoHTML);

	//replace alimentazione
	if(!isset($_COOKIE["isFilterRemoved"]) && htmlspecialchars(isset($_GET['alimentazione']))) {
		$listinoHTML = str_replace("[" . $_GET['alimentazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiA]", "[benzina]", "[gasolio]", "[elettrico]", "[gpl]", "[plugin]"], ["selected ", "", "", "", "", ""], $listinoHTML);

	//replace cambio
	if(!isset($_COOKIE["isFilterRemoved"]) && htmlspecialchars(isset($_GET['cambio']))) {
		$listinoHTML = str_replace("[" . $_GET['cambio'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiCb]", "[manuale]", "[automatico]"], ["selected ", "", ""], $listinoHTML);

	//replace trazione
	if(!isset($_COOKIE["isFilterRemoved"]) && htmlspecialchars(isset($_GET['trazione']))) {
		$listinoHTML = str_replace("[" . $_GET['trazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiT]", "[anteriore]", "[posteriore]", "[integrale]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace('[potenzaMin]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['potenzaMin']) ? $_GET['potenzaMin'] : '')), $listinoHTML);
	$listinoHTML = str_replace('[potenzaMax]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['potenzaMax']) ? $_GET['potenzaMax'] : '')), $listinoHTML);
	$listinoHTML = str_replace('[pesoMin]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['pesoMin']) ? $_GET['pesoMin'] : '')), $listinoHTML);
	$listinoHTML = str_replace('[pesoMax]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['pesoMax']) ? $_GET['pesoMax'] : '')), $listinoHTML);
	$listinoHTML = str_replace("[neopatentati]", htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['neopatentati']) ? 'checked ' : '')), $listinoHTML);
	$listinoHTML = str_replace('[posti]', htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['posti']) ? $_GET['posti'] : '')), $listinoHTML);

	//replace condizione
	if(!isset($_COOKIE["isFilterRemoved"]) && htmlspecialchars(isset($_GET['condizione']))) {
		$listinoHTML = str_replace("[" . $_GET['condizione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiCd]", "[nuovo]", "[usato]", "[km0]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace("[prezzoMax]", htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['prezzoMax']) ? $_GET['prezzoMax'] : '')), $listinoHTML);
	$listinoHTML = str_replace("[chilometraggio]", htmlspecialchars(isset($_COOKIE["isFilterRemoved"]) ? '' : (isset($_GET['chilometraggio']) ? $_GET['chilometraggio'] : '')), $listinoHTML);

	return $listinoHTML;
}

function getVehiclesFromDB($params, $listinoHTML) {
	try{
		$db = new DBConnection();

		//IMPOSTARE DATI COME INDICATO NEI FILTRI
		

		$ris = $db->getFilteredVehicles($params);

		$db->closeConnection();
		unset($db);

		$listaAuto = '';

		if($ris){
			// Qui ci sono auto
			$listaAuto = '<dl id="list_car_list">';
			foreach($ris as $vehicle) {
				$listaAuto .= '
					<a class="list_car_item" href="auto.php?id=' . $vehicle["id"] . '">
						<div class="list_car_image">';
							
						// Gestione delle immagini
						$fotos = explode(separator: "+", string: $vehicle['foto']);
						$foto = '<img src="assets/img/Cars/' . htmlspecialchars(string: $vehicle['marca']) . '/' . htmlspecialchars(string: $fotos[0]) . '" alt="Immagine auto">';
						$listaAuto .= $foto;

				$listaAuto .= '
						</div>
						<dl class="list_car_info">
							<div>
								<dd>Marca</dd>
								<dt>' . $vehicle["marca"] . '</dt>
							</div>
							<div>
								<dd>Modello</dd>
								<dt>' . $vehicle["modello"] . '</dt>
							</div>
							<div>
								<dd>Condizioni</dd>
								<dt>' . $vehicle["condizione"] . '</dt>
							</div>
							<div>
								<dd>Prezzo</dd>
								<dt><abbr title="Euro">&euro;</abbr> ' . $vehicle["prezzo"] . '</dt>
							</div>
						</dl>
					</a>';
			}
			$listaAuto .='</dl>';
		} else {
			$listaAuto ='<p class="list_car_list_empty">Nessun veicolo compatibile con i filtri impostati</p>';
		}

		$listinoHTML = ripristinoInput($listinoHTML);
		$listinoHTML = preg_replace('/<dl id="list_car_list">.*?<\/dl>\s*<\/section>/s', $listaAuto, $listinoHTML);
		
		return $listinoHTML;
	}
	catch(Exception){
		header("location: 500.html");
		exit();
	}
}

//DA SOSTITUIRE CON PERCORSO FILE HTML
$listinoHTML = file_get_contents("listino.html");

session_start();

$err = "";

if(isset($_GET['action']) && $_GET['action'] == 'Applica filtri') {
	if(isset($_GET["marca"]) || isset($_GET["modello"]) || isset($_GET["anno"]) || isset($_GET["colore"]) 
		|| isset($_GET["alimentazione"]) || isset($_GET["cambio"]) || isset($_GET["trazione"]) || isset($_GET["potenzaMin"]) || isset($_GET["potenzaMax"]) 
		|| isset($_GET["pesoMin"]) || isset($_GET["pesoMax"]) || isset($_GET["neopatentati"]) || isset($_GET["posti"]) || isset($_GET["condizione"]) 
		|| isset($_GET["prezzoMax"]) || isset($_GET["chilometraggio"])) {


		//CONTROLLI SULL'INPUT
		if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["marca"])) {
			$err = $err . "<p>Marca non valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if (!preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["modello"])) {
			$err = $err . "<p>Modello non valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if (!empty($_GET["anno"]) && !preg_match("/^[0-9]*$/", $_GET["anno"]) && (intval($_GET["anno"]) < 1990 || intval($_GET["anno"]) > 2024)) {
			$err = $err . "<p>Anno non valido, inserisci un anno compreso tra 1990 e 2024</p>";
		}
		if (!empty($_GET["colore"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["colore"])) {
			$err = $err . "<p>Selezione colore non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if (!empty($_GET["alimentazione"]) && !preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["alimentazione"])) {
			$err = $err . "<p>Selezione alimentazione non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if (!empty($_GET["cambio"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["cambio"])) {
			$err = $err . "<p>Selezione cambio non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if (!empty($_GET["trazione"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["trazione"])) {
			$err = $err . "<p>Selezione trazione non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if (!empty($_GET["potenzaMin"]) && !preg_match("/^[0-9]*$/", $_GET["potenzaMin"]) && (intval($_GET["potenzaMin"]) <= 0) || (!empty($_GET["potenzaMax"]) ? (intval($_GET["potenzaMin"]) > intval($_GET["potenzaMax"])) : false)) {
			$err = $err . "<p>Potenza minima non valida, inserisci una potenza maggiore di 0 e minore o uguale alla potenza massima.</p>";
		}
		if (!empty($_GET["potenzaMax"]) && !preg_match("/^[0-9]*$/", $_GET["potenzaMax"]) && (intval($_GET["potenzaMax"]) <= 0) || (!empty($_GET["potenzaMin"]) ? (intval($_GET["potenzaMax"]) < intval($_GET["potenzaMin"])) : false)) {
			$err = $err . "<p>Potenza massima non valida, inserisci una potenza maggiore di 0 e maggiore o uguale alla potenza minima.</p>";
		}
		if (!empty($_GET["pesoMin"]) && !preg_match("/^[0-9]*$/", $_GET["pesoMin"]) && (intval($_GET["pesoMin"]) <= 0) || (!empty($_GET["pesoMax"]) ? (intval($_GET["pesoMin"]) > intval($_GET["pesoMax"])) : false)) {
			$err = $err . "<p>Peso minimo non valido, inserisci un peso maggiore di 0 e minore o uguale al peso massimo.</p>";
		}
		if (!empty($_GET["pesoMax"]) && !preg_match("/^[0-9]*$/", $_GET["pesoMax"]) && (intval($_GET["pesoMax"]) <= 0) || (!empty($_GET["pesoMin"]) ? (intval($_GET["pesoMax"]) < intval($_GET["pesoMin"])) : false)) {
			$err = $err . "<p>Peso massimo non valido, inserisci un peso maggiore di 0 e maggiore o uguale al peso minimo.</p>";
		}
		if (!empty($_GET["posti"]) && !preg_match("/^[0-9]*$/", $_GET["posti"]) && (intval($_GET["posti"]) <= 0)) {
			$err = $err . "<p>Numero di posti non valido, inserisci un numero maggiore di 0.</p>";
		}
		if (!empty($_GET["condizione"]) && !preg_match("/^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/", $_GET["condizione"])) {
			$err = $err . "<p>Selezione condizione non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if (!empty($_GET["prezzoMax"]) && !preg_match("/^[0-9.]*$/", $_GET["prezzoMax"]) && doubleval($_GET["prezzoMax"]) <= 0) {
			$err = $err . "<p>Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
		}
		if (!empty($_GET["chilometraggio"]) && !preg_match("/^[0-9]*$/", $_GET["chilometraggio"]) && intval($_GET["chilometraggio"]) <= 0) {
			$err = $err . "<p>Chilometraggio non valido, inserisci un numero maggiore di 0.</p>";
		}
		if (!empty($_GET["neopatentati"]) && !preg_match("/^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/", $_GET["neopatentati"])) {
			$err = $err . "<p>Selezione neopatentati non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}

		//CONTROLLO ERRORI
		if (!empty($err)) {
			$listinoHTML = ripristinoInput($listinoHTML);
			echo str_replace("[err]", $err, $listinoHTML);
			exit();
		}

		//ESECUZIONE DELLA QUERY

		$params = array();
		foreach($_GET as $param => $value) {
			switch($param) {
				// Per i valori double o interi, se uso intval/doubleval e ho stringa vuota di partenza, diventa 0/0.0

				// Per i valori interi	
				case "potenzaMin":
				case "potenzaMax":
				case "pesoMin":
				case "pesoMax":
				case "posti":
				case "anno":
				case "neopatentati":
				case "chilometraggio":
					if(intval($value) != 0) {
						$params[$param] = intval($value);
					}
					break;
				// Per i valori double	
				case "prezzoMax":
					if(doubleval($value) != 0) {
						$params[$param] = doubleval($value);
					}
					break;
				case "action":
					break;
				// Per le stringhe
				default:
					if((!str_contains($value, "qualsiasi")) && !empty($value)) {
						$params[$param] = $value;
					}
					break;
			}
		}

		// Qui chiamo funziona per ricavare auto
		$listinoHTML = getVehiclesFromDB($params, $listinoHTML);;

		if(isset($_COOKIE["isFilterRemoved"])) {
			setcookie("isFilterRemoved", "", time() - 3600, "/");
		}

		echo str_replace("[err]", $err, $listinoHTML);
			
	} else {
		// Se ho impostato come valore nel GET solo action=Applica+filtri
		header("location: listino.php");
	}
} else if (isset($_GET['action']) && $_GET['action'] == 'Rimuovi filtri') {
	setcookie("isFilterRemoved", str_replace("Rimuovi+filtri", "Applica+filtri", $_SERVER["REQUEST_URI"]));
	header("location: " . str_replace("Rimuovi+filtri", "Applica+filtri", $_SERVER["REQUEST_URI"]));
} else {
	$listinoHTML = getVehiclesFromDB(array(), $listinoHTML);;
	echo str_replace("[err]", $err, $listinoHTML);
}

?>