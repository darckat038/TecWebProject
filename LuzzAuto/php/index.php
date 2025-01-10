<?php
    
require_once ".." . DIRECTORY_SEPARATOR . "php_sessions" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR . "index.html");



?>