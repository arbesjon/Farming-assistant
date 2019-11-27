<?php	require 'inc/conn.php';
session_start();

if($_SESSION['username'] == null){
    header("Location: index");
    exit;
}

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $roleid = "1";

    $query = "UPDATE Farmers SET roleid = :roleid WHERE farmerid = :id";
    $addadmin = $conn->prepare($query);
    $addadmin->bindParam('roleid', $roleid);
    $addadmin->bindParam('id', $id);
    $addadmin->execute();


    header("Location: cpanel");
    exit;
?>