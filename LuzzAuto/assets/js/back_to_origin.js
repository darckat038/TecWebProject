window.addEventListener('load', function () {
	setBackToOriginTestDriveLogin();
    setBackToOriginTestDriveSignup();
});

function setBackToOriginTestDriveLogin() {
    let linkLogin = document.getElementById('test_drive_login_link');
    if(linkLogin){
        linkLogin.addEventListener('click', function (event){
            var cL = "backToOrigin=test_drive.php#test_drive_prenota";
            document.cookie = cL;
        });
    }
}

function setBackToOriginTestDriveSignup() {
    let linkSignup = document.getElementById('test_drive_signup_link');
    if(linkSignup){
        linkSignup.addEventListener('click', function (event){
            var cS = "backToOrigin=test_drive.php#test_drive_prenota";
            document.cookie = cS;
        });
    }
}