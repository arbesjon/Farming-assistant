<?php	require 'inc/conn.php';

    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $shopstatusid = "2";

    $querysold = "UPDATE Harvest SET shopstatusid = :shopstatusid WHERE harvestid = :id";
    $query = $conn->prepare($querysold);
    $query->bindParam('id', $id);
    $query->bindParam('shopstatusid', $shopstatusid);
    $query->execute();

    header("Location: profile");
    exit;
?>