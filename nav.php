<?php
    require 'inc/conn.php';
    session_start();

    if($_SESSION['username'] == null){
        header("Location: index");
        exit;
    }

    $id = $_SESSION['farmerid'];

    $querylang = 'SELECT * FROM Farmers
     INNER JOIN Language on Language.languageid = Farmers.languageid
     WHERE farmerid = :id';
     $selectlang =  $conn->prepare($querylang);
     $selectlang->bindParam('id', $id);
     $selectlang->execute();
     $lang = $selectlang->fetch();

     require 'lang/' . $lang['languagename'] . '.php';


    $queryalarm = 'SELECT * FROM Alarm WHERE farmerid = :id AND DATE(date) = DATE(NOW()) AND alarmcategoryid = 1';
    $selectalarm =  $conn->prepare($queryalarm);
    $selectalarm->bindParam('id', $id);
    $selectalarm->execute();

    $querymessage = 'SELECT * FROM Messages WHERE receiverid = :id AND msgreadid = 2';
    $selectmessage =  $conn->prepare($querymessage);
    $selectmessage->bindParam('id', $id);
    $selectmessage->execute();

    $querytask = 'SELECT * FROM Tasks WHERE farmerid = :id AND taskstatusid = 1 AND DATE(startdate) <= DATE(NOW()) AND DATE(enddate) >= DATE(NOW())';
    $selecttask =  $conn->prepare($querytask);
    $selecttask->bindParam('id', $id);
    $selecttask->execute();

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content=""> 

    <title>Farming Assistant</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/creative.min.css" rel="stylesheet">
    <link href="css/navcss.css" rel="stylesheet">
    <script src="js/dropdown.js"></script>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavHome" >
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Farming Assistant</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="shop"><img class="imgshop" src="img/shop.png" ></a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="messages"><img class="navimg" src="img/messages.png" >
              <?php if($selectmessage->rowCount() > 0){ ?><span class="badge"><?php echo $selectmessage->rowCount(); ?></span><?php } ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="alarms"><img class="navimg" src="img/alerts.png" >
                <?php if($selectalarm->rowCount() > 0){ ?><span class="badge"><?php echo $selectalarm->rowCount(); ?></span><?php } ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="tasks"><img class="navimg" src="img/tasks.png" >
                <?php if($selecttask->rowCount() > 0){ ?><span class="badge"><?php echo $selecttask->rowCount(); ?></span><?php } ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger1" href="#" onclick="dropDown();"><?php echo $_SESSION['username'] . " ▼"; ?></a>
                <ul class="dropdownul" id="hideshow">
                  <?php if($_SESSION['roleid'] == 1){?>
                    <li class="dropdownli"><a href="cpanel"><img class="imgdd" src="img/cpanel.png">  <?php echo $lng['CPanel']?></a></li>
                  <?php } ?>
                  <li class="dropdownli"><a href="profile"><img class="imgdd" src="img/profile.png">  <?php echo $lng['Profile']?></a></li>
                  <li class="dropdownli"><a href="fields"><img class="imgdd" src="img/field.png">  <?php echo $lng['Fields']?></a></li>
                  <li class="dropdownli"><a href="plants"><img class="imgdd" src="img/plant.png">  <?php echo $lng['Plants']?></a></li>
                  <li class="dropdownli"><a href="harvest"><img class="imgdd" src="img/harvest.png">  <?php echo $lng['Harvested']?></a></li>
                  <li class="dropdownli"><a href="logout"><img class="imgdd" src="img/logout.png">  <?php echo $lng['Logout']?></a></li>
                </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>