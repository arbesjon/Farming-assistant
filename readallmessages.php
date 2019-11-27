<?php	require 'inc/conn.php';

    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    if (isset($_GET['farmer'])) {
        $id = $_GET['farmer'];
    }

    $msgread = "1";

    $queryread = "UPDATE Messages SET msgreadid = :msgreadid WHERE receiverid = :id";
    $query = $conn->prepare($queryread);
    $query->bindParam('id', $id);
    $query->bindParam('msgreadid', $msgread);
    $query->execute();

    header("Location: messages");
    exit;
?>