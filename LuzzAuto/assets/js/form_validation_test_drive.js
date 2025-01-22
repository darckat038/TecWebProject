//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateTestDriveData();
});

function isNumber(value){
    try{
        if(isNaN(value)){
            return false;
        }
        return true;
    }
    catch(error){
        console.log("An error occurred: ", error.message);
    }
}

function validateTestDriveData(){
    let form = document.getElementById('test_drive_form');
    if(form){
        form.addEventListener('submit', function (event){
            resetFormError(0);
            let msg = "";
            let ok = true;
            if(!validateAuto()){
                console.log("auto non valida");
                msg+="<p>L'auto non è valida.</p>";
                ok = false;
            }
            if(!validateEmptyAuto()){
                console.log("auto non selezionata");
                msg+="<p>Selezionare un'auto da eliminare.</p>";
                ok = false;
            }
            if(!validateDate()){
                console.log("data non valida");
                msg+="<p>La data non è valida js.</p>";
                ok = false;
            }
            if(!ok){
                addFormError(msg, 0);
                event.preventDefault();
            }
        });
    }
}

function validateEmptyAuto(){
    var auto = document.getElementById("test_drive_select_auto").value;
    if(auto == ""){
        return false;
    }
    return true;
}

function validateAuto(){
    var auto = document.getElementById("test_drive_select_auto").value;
    const validChars = /^[A-Za-z0-9\-\s]+$/;
    if(auto.split("-")[0] == ""){
        return false;
    }
    if(auto.split("-")[0] != "" &&  (!validChars.test(auto) || !isNumber(auto.split("-")[0]))){
        return false;
    }
    return true;
}

function validateDate(){
    var date = document.getElementById("test_drive_date").value;
    date = date.replace("T", " ");
    const validChars = /^[0-9\-\:\s]+$/;
    var today = new Date();
    const month = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var dataOggi = today.getFullYear().toString()+"-"+month[today.getMonth()]+"-"+today.getDate()+" "+today.getHours().toString()+":"+today.getMinutes().toString();
    if(!validChars.test(date) || dataOggi > date){
        return false;
    }
    return true;
}