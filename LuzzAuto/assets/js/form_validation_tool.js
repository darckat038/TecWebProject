function addFormError(error){
    let div = document.getElementsByClassName("form_errors")[0];
    div.innerHTML += error;
    // div.children[0].focus();             // funziona solo se l'elemento è interattivo (tabindex)
}

function resetFormError(){
    let div = document.getElementsByClassName("form_errors")[0];
    div.innerHTML = "";
}