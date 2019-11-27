<?php
require 'inc/conn.php';
session_start();
date_default_timezone_set('Europe/Skopje');

$id = $_SESSION['farmerid'];
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$registerdate = $_SESSION['registerdate'];
$city = $_SESSION['region'];

$today = date('Y-m-d');

$querycity = 'SELECT * FROM City
    WHERE cityid = :cid';

    $selectcity =  $conn->prepare($querycity);
    $selectcity->bindParam('cid', $city);
    $selectcity->execute();
    $resultcity = $selectcity->fetch();

if($_SESSION['username'] == null){
    header("Location: index");
    exit;
}

$action = $_GET['action'];
$datefrom = $_GET['datefrom'];
$dateto = $_GET['dateto'];

if($action == "tasks"){
    if($datefrom == "" || $dateto == ""){
        $query = 'SELECT * FROM Tasks
        WHERE farmerid = :id';
        $select =  $conn->prepare($query);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    } else {
        $query = 'SELECT * FROM Tasks
        WHERE farmerid = :id AND startdate BETWEEN :datefrom AND :dateto';
        $select =  $conn->prepare($query);
        $select->bindParam('datefrom', $datefrom);
        $select->bindParam('dateto', $dateto);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    }

} else if($action == "alarms"){
    if($datefrom == "" || $dateto == ""){
        $query = 'SELECT * FROM Alarm
        WHERE farmerid = :id';
        $select =  $conn->prepare($query);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    } else {
        $query = 'SELECT * FROM Alarm
        WHERE farmerid = :id AND date BETWEEN :datefrom AND :dateto';
        $select =  $conn->prepare($query);
        $select->bindParam('datefrom', $datefrom);
        $select->bindParam('dateto', $dateto);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    }

} else if($action == "plants"){
    if($datefrom == "" || $dateto == ""){
        $query = 'SELECT * FROM Plant
        WHERE farmerid = :id';
        $select =  $conn->prepare($query);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    } else {
        $query = 'SELECT * FROM Plant
        WHERE farmerid = :id AND plantdate BETWEEN :datefrom AND :dateto';
        $select =  $conn->prepare($query);
        $select->bindParam('datefrom', $datefrom);
        $select->bindParam('dateto', $dateto);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    }
    
} else if($action == "harvested"){
    if($datefrom == "" || $dateto == ""){
        $query = 'SELECT * FROM Harvest
        INNER JOIN Plant ON Plant.plantid = Harvest.plantid 
        WHERE Plant.farmerid = :id';
        $select =  $conn->prepare($query);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    } else {
        $query = 'SELECT * FROM Harvest
        INNER JOIN Plant ON Plant.plantid = Harvest.plantid 
        WHERE Plant.farmerid = :id AND harvestdate BETWEEN :datefrom AND :dateto';
        $select =  $conn->prepare($query);
        $select->bindParam('datefrom', $datefrom);
        $select->bindParam('dateto', $dateto);
        $select->bindParam('id', $id);
        $select->execute();
        $result = $select->fetchAll();
    } 
}
    


require("api/fpdf.php");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->setFont("Arial","B",16);
$pdf->Cell(0,10,"Farming Assistant",1,1,C);

$pdf->setFont("Arial","I",12);
$pdf->Cell(0,10,"Farmer: {$firstname} {$lastname}",0,0);
$pdf->Cell(0,10,"Phone: {$phone}",0,1,R);
$pdf->Cell(0,10,"Address: {$resultcity['cityname']}",0,0);
$pdf->Cell(0,10,"Email: {$email}",0,1,R);
$pdf->Cell(0,10,"Date: {$today}",0,1,C);

$pdf->Cell(0,20,"",0,1);

$pdf->setFont("Arial","B",14);

$pdf->Cell(63,8,"Action",1,0);
$pdf->Cell(63,8,"Name",1,0);
$pdf->Cell(63,8,"Date",1,1);


$pdf->setFont("Arial","I",12);

foreach($result as $res){
    if($action == "plants"){
        $pdf->Cell(63,8,"Plant",1,0);
        $pdf->Cell(63,8,"{$res['plantname']}",1,0);
        $pdf->Cell(63,8,"{$res['plantdate']}",1,1);
    } else if($action == "harvested"){
        $pdf->Cell(63,8,"Harvested",1,0);
        $pdf->Cell(63,8,"{$res['plantname']}",1,0);
        $pdf->Cell(63,8,"{$res['harvestdate']}",1,1);
    }else if($action == "tasks"){
        $pdf->Cell(63,8,"Task",1,0);
        $pdf->Cell(63,8,"{$res['taskname']}",1,0);
        $pdf->Cell(63,8,"{$res['startdate']}",1,1);
    }else if($action == "alarms"){
        $pdf->Cell(63,8,"Alarm",1,0);
        $pdf->Cell(63,8,"{$res['alarmname']}",1,0);
        $pdf->Cell(63,8,"{$res['date']}",1,1);
    }
}

$pdf->Output();
?>