function addFormError(error){
    let div = document.getElementsByClassName("form_errors")[0];
    div.innerHTML += error;
}

function resetFormError(){
    let div = document.getElementsByClassName("form_errors")[0];
    div.innerHTML = "";
}