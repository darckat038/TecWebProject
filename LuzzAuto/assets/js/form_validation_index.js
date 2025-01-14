window.addEventListener('load', function () {
	validateFastSearch();
});

function validateFastSearch() {
	let form = document.getElementById("home_fastSearch_form");

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
			msg += "<p id=\"prezzoMax_err\">Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";;
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

	var marca = document.getElementById("home_marca").value;

	return allowedChars.test(marca);
}

/*
* Controllo il modello del veicolo
*/
function validateModello() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)

	var modello = document.getElementById("home_modello").value;

	return allowedChars.test(modello);
}

/*
* Controllo il prezzo massimo inserito
*/
function validatePrezzo() {
	var prezzoMax = document.getElementById("home_prezzoMax").value;

	console.log(prezzoMax);
	
	return (prezzoMax != "" ? prezzoMax > 0 : true);
}