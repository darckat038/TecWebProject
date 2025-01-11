<?php 
require_once 'dbConnection.php';
use DB\DBConnection;

phpinfo();

try{
    $conn = new DBConnection();
    echo $conn->getConnection()->server_info;
    echo "  System status: ". mysqli_stat($conn->getConnection());
    $conn->closeConnection();
}
catch(Exception $e){
    echo 'Errore: ' . $e;
}

?>