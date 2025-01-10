

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