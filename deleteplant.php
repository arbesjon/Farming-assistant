<?php	require 'inc/conn.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $query = "DELETE FROM Plant WHERE plantid = :id";
    $query = $conn->prepare($query);

    $query->execute(['id' => $id]);


    header("Location: plants");
    exit;
?>