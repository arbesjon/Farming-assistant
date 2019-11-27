<?php	require 'inc/conn.php';

    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $categoryid = "2";

    $querydismiss = "UPDATE Alarm SET alarmcategoryid = :categoryid WHERE alarmid = :id";
    $query = $conn->prepare($querydismiss);
    $query->bindParam('id', $id);
    $query->bindParam('categoryid', $categoryid);
    $query->execute();

    header("Location: alarms");
    exit;
?>