window.addEventListener('load', function () {
	setBackToOriginTestDrive();
});

function setBackToOriginTestDrive() {
    let linkLogin = document.getElementById('test_drive_login_link');
    if(linkLogin){
        linkLogin.addEventListener('click', function (event){
            var c = "backToOrigin=test_drive.php#test_drive_prenota";
            document.cookie = c;
        });
    }

    let linkSignup = document.getElementById('test_drive_signup_link');
    if(linkSignup){
        linkSignup.addEventListener('click', function (event){
            var c = "backToOrigin=test_drive.php#test_drive_prenota";
            document.cookie = c;
        });
    }
    
}