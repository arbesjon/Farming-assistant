<?php	require 'inc/conn.php';

    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $query = "DELETE FROM Harvest WHERE harvestid = :id";
    $query = $conn->prepare($query);

    $query->execute(['id' => $id]);


    header("Location: harvest");
    exit;
?>