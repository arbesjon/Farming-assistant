<?php	require 'inc/conn.php';

    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $taskstatusid = "2";

    $querydone = "UPDATE Tasks SET taskstatusid = :taskstatusid WHERE taskid = :id";
    $query = $conn->prepare($querydone);
    $query->bindParam('id', $id);
    $query->bindParam('taskstatusid', $taskstatusid);
    $query->execute();

    header("Location: tasks");
    exit;
?>