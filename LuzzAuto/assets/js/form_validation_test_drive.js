//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateTestDriveData();
});

function validateTestDriveData(){
    
    let form = document.getElementById('test_drive_form');
    if(form){
        form.addEventListener('submit', function (event){
            resetFormError();
            let div = document.getElementsByClassName("form_success")[0];
            div.innerHTML = "";
            
            let msg = "";
            let ok = true;
            
            if(!validateAuto()){
                msg+="<p>L'auto non è valida.</p>";
                ok = false;
            }
    
            if(!validateDate()){
                msg+="<p>La data non è valida.</p>";
                ok = false;
            }
    
            if(!ok){
                addFormError(msg);
                event.preventDefault();
            }
            
        });
    }
}

function validateAuto(){
    var auto = document.getElementById("test_drive_select_auto").value;
    const validChars = /^[A-Za-z0-9\-\s]+$/;
    if(!validChars.test(auto)){
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

