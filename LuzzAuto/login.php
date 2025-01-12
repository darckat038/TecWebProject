<?php
require_once 'dbConnection.php';
use DB\DBConnection;

$loginHTML = file_get_contents('login.html');

$err = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO da fare
session_start();
if (isset($_SESSION["utente"])) {
	header("location: utente.php");
	exit();
}

echo str_replace("[err]", $err, $loginHTML);
?>