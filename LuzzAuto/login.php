<?php

function ripristinoInput(){
	$loginHTML = file_get_contents('login.html');
	//RIPRISTINO DELL'INPUT INSERITO
	$loginHTML = str_replace("[username]", htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : ''), $loginHTML);
	$loginHTML = str_replace("[password]", htmlspecialchars(isset($_POST['password']) ? $_POST['password'] : ''), $loginHTML);
	return $loginHTML;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$loginHTML = file_get_contents('login.html');

$err = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
session_start();
if (isset($_SESSION["utente"])) {
	header("location: utente.php");
	exit();
}


//CONTROLLO SE SONO SETTATI TUTTI I CAMPI E CHE NON SIANO VUOTI
if(isset($_POST["username"]) && isset($_POST["password"])){

	if(empty($_POST["username"]) || empty($_POST["password"])){
		$err = $err . "<p>Devi compilare tutti i campi.</p>";
        $loginHTML = ripristinoInput();
		echo str_replace("[err]", $err, $loginHTML);
		exit();
	}
	else{

		//ESECUZIONE DELLA QUERY
		try{
			$db = new DBConnection();
			$ris = $db->loginUser($_POST["username"], $_POST["password"]);
			$db->closeConnection();
			unset($db);
			if($ris == -1){
				$err = $err . "<p><span lang='en-GB'>Username</span> non trovato.</p>";
				$loginHTML = ripristinoInput();
				echo str_replace("[err]", $err, $loginHTML);
			}
			else{
				if($ris == 1){
					if($_POST["username"] == "admin"){
						$_SESSION['utente'] = $_POST["username"];
						if(isset($_COOKIE['backToOrigin'])){
							setcookie("backToOrigin", "", time() - 3600, "/");
						}
						header("location: amministratore.php");
					}
					else{
						$_SESSION['utente'] = $_POST["username"];
						//CONTROLLO BACK TO ORIGIN PER TORNARE ALLA PAGINA DI PROVENIENZA
						if(isset($_COOKIE['backToOrigin'])){
							header("location: " . $_COOKIE['backToOrigin']);
							setcookie("backToOrigin", "", time() - 3600, "/");
						}
						else{
							header("location: utente.php");
						}
					}
				}
				else{
					$err = $err . "<p><span lang='en-GB'>Password</span> errata.</p>";
				    $loginHTML = ripristinoInput();
				    echo str_replace("[err]", $err, $loginHTML);
				}
			}
		}
		catch(Exception){
			header("location: 500.html");
			exit();
		}

	}

}
else{
	$loginHTML = ripristinoInput();
	echo str_replace("[err]", $err, $loginHTML);
}

?>