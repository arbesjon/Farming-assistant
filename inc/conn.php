<?php

$servername = 'localhost';
$username = 'id5483363_farmingassistant';
$password = 'farmingassistant';

try{
    $conn = new PDO("mysql:host=$servername;dbname=id5483363_farmingassistant", $username, $password);
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>