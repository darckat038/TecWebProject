document.addEventListener("DOMContentLoaded", function () {
	validateFastSearch();
});

function validateFastSearch() {
	let form = document.getElementById("list_filter_form");

	form.addEventListener("submit", function(event) {

		var ok = true;
		let msg = "";

		console.log("submit event");
		resetFormError();
		if(!validateMarca()) {
			ok = false;
			msg += "<p tabindex=\"0\" id=\"marca_err\">Marca non valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if(!validateModello()) {
			ok = false;
			msg += "<p id=\"modello_err\">Modello non valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if(!validatePrezzo()) {
			ok = false;
			msg += "<p id=\"prezzoMax_err\">Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
		}
		if(!validateCondizione()) {
			ok = false;
			msg += "<p id=\"condizione_err\">Selezione condizione non valida. Selezionare nuovamente la scelta desiderata.</p>";
		}
		if(!ok) {
			console.log("Prevenzione del submit, errore trovato.");
			addFormError(msg);
			event.preventDefault();
		} else {
			console.log("Tutto ok, il form verrà inviato.");
		}
	});
}

/*
* Controllo la marca del veicolo
*/
function validateMarca() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)

	var marca = document.getElementById("list_filter_marca").value;

	return allowedChars.test(marca);
}

/*
* Controllo il modello del veicolo
*/
function validateModello() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)

	var modello = document.getElementById("list_filter_modello").value;

	return allowedChars.test(modello);
}

/*
* Controllo l'anno del veicolo
*/
function validateAnno() {
	const allowedChars = /^(\d{4})?$/; // solo numeri, 4 cifre

	var anno = document.getElementById("list_filter_anno").value;

	return allowedChars.test(anno) && (anno >= 1990 && anno <= 2024); ;
}

/*
* Controllo il colore del veicolo
*/
function validateColore() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole

	var colore = document.getElementById("list_filter_colore").value;

	return allowedChars.test(colore);
}

/*
* Controllo il tipo di alimentazione del veicolo
*/
function validateAlimentazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole

	var alimentazione = document.getElementById("list_filter_alimentazione").value;

	return allowedChars.test(alimentazione);
}

/*
* Controllo il tipo di cambio del veicolo
*/
function validateCambio() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole

	var cambio = document.getElementById("list_filter_cambio").value;

	return allowedChars.test(cambio);
}

/*
* Controllo il tipo di trazione del veicolo
*/
function validateTrazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole

	var trazione = document.getElementById("list_filter_trazione").value;

	return allowedChars.test(trazione);
}

/*
* Controllo la potenza minima del veicolo
*/
function validatePotenzaMin() {
	const allowedChars = /^(\d+)?$/; // solo numeri

	var potenzaMin = document.getElementById("list_filter_potenzaMin").value;
	var potenzaMax = document.getElementById("list_filter_potenzaMax").value;

	return allowedChars.test(potenzaMin) && (potenzaMax ? potenzaMin <= potenzaMax : true);
}

/*
* Controllo il modello del veicolo
*/
function validateCondizione() {
	const allowedChars = /^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/; // lettere maiuscole e minuscole, numeri

	var condizione = document.getElementById("list_filter_condizione").value;

	return allowedChars.test(condizione);
}

/*
* Controllo il prezzo massimo inserito
*/
function validatePrezzo() {
	var prezzoMax = document.getElementById("list_filter_prezzoMax").value;

	console.log(prezzoMax);
	
	return (prezzoMax != "" ? prezzoMax > 0 : true);
}