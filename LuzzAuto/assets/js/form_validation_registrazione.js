//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL

function validateLoginData(){
    let form = document.getElementById('signup_form');
    form.addEventListener('submit', function (event){
        resetFormError();
        if(!validateNome()){
            event.preventDefault();
            var errorDiv = document.getElementsByClassName('form_errors');
            if (errorDiv) {
                errorDiv[0].focus();
            }
            
        }
    });
}

function validateNome(){
    var nome = document.getElementById("signup_nome").value;
    const validChars = /^[A-Za-z]+$/;
    if(!validChars.test(nome)){
        addFormError("<p>Nome non valido, può contenere solo lettere.</p>")
        return false;
    }
    return true;
}

window.addEventListener('load', function () {
	validateLoginData();
});