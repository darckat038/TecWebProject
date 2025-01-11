<?php
    
require_once "dbConnection.php";
use DB\DBConnection;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$indexHTML = file_get_contents("index.html");

try {
    $db = new DBConnection();

} catch(Exception) {
    
}

?>