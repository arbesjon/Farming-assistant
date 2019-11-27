<?php	require 'inc/conn.php';

    session_start();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    $query = "DELETE FROM Messages WHERE messageid = :id";
    $query = $conn->prepare($query);

    $query->execute(['id' => $id]);


    header("Location: messages");
    exit;
?>