/*
function deleteErrorMessagesOnLoad() {
	let indexBody = document.getElementsByTagName("body");

	indexBody.addEventListener("load", function() {
		
	})
	return;
}
*/

function validateFastSearch() {
	let form = document.getElementById("home_fastSearch_form");

	form.addEventListener("submit", function(event) {
		if(!( validateMarca(form) && validateModello(form) && validatePrezzo(form) )) {
			focusOnTopmostError();
			event.preventDefault();
		}
	})
}

function validateMarca(form) {
	const allowedChars = /^[A-Za-z0-9\-]+$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
}

function validateModello() {
	const allowedChars = /^[A-Za-z0-9\-]+$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
}

function validatePrezzo(form) {
	var id = "home_prezzo";
	var username = form;
	
	if (prezzoMax <= 0) {
		showErrorMessage(id, 'Prezzo massimo non valido, devi inserire un valore più grande di 0.');
		return false;
	}
	removeErrorMessage(id);
	return true;
}

/*
 * Mostra messaggio di errore a seguito di validazione
 */
function showErrorMessage(id, message) {
	var element = document.getElementById(id);
	var messageTarget = document.getElementById(id + '-hint');

	removeErrorMessage(id);

	element.classList.add('invalid');
	if (element.tagName != 'DIV') {
		element.setAttribute("aria-invalid", true);
	}

	messageTarget.classList.add("error-message");
	messageTarget.innerHTML = message;
	return;
}

/*
 * Rimuove messaggio di errore a seguito di validazione
 */
function removeErrorMessage(id) {
	var element = document.getElementById(id);
	var messageTarget = document.getElementById(id + '-hint');

	element.classList.remove('invalid');
	if (element.tagName != 'DIV') {
		element.setAttribute("aria-invalid", false);
	}

	messageTarget.classList.remove("error-message");
	messageTarget.innerHTML = '';
	return;
}

/*
 * Pone il focus sul primo errore del form.
 */
function focusOnTopmostError() {
	var invalidFields = document.getElementsByClassName('invalid');
	if (invalidFields) {
		invalidFields[0].focus();
	}
	return;
}