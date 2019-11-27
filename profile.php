<?php 
    require 'nav.php';
    require 'editprofile.php';
    require 'details.php';

    $idf = $_SESSION['farmerid'];

    $queryprofile = 'SELECT * FROM Farmers
     WHERE farmerid = :id';

    $selectprofile =  $conn->prepare($queryprofile);
    $selectprofile->bindParam('id', $idf);
    $selectprofile->execute();
    $profile = $selectprofile->fetch();
    

?>

<html lang="en">
  <head>
    <!-- Required meta tags s -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
    <link href="css/shopcss.css" rel="stylesheet">
    <script src="js/plants.js"></script>

    <title> </title>
  </head>
  <body>
    <br>
    <br>
    <br>
    <div class="container">

    <div class="mx-auto" style="width: 18rem;">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $profile['firstname'] . ' ' . $profile['lastname'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $profile['username'] ?></h6>
                <img class="card-img-top" src="img/farmer.jpg" alt="Card image cap">
                <p class="card-text">Hi <strong><?php echo $profile['username']?></strong> have a nice day!</p>
                <a href="#" class="card-link" data-toggle="modal" data-target="#myModalEdit">Edit Profile</a>
                <a href="#" class="card-link" data-toggle="modal" data-target="#myModalDetails">Details</a>
            </div>
        </div>
    </div>

    <br>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-dashboard-tab" data-toggle="tab" href="#nav-dashboard" role="tab" aria-controls="nav-dashboard" aria-selected="true">Dashboard</a>
            <a class="nav-item nav-link" id="nav-myshop-tab" data-toggle="tab" href="#nav-myshop" role="tab" aria-controls="nav-myshop" aria-selected="false">My Shop</a>
            <a class="nav-item nav-link" id="nav-weather-tab" data-toggle="tab" href="#nav-weather" role="tab" aria-controls="nav-weather" aria-selected="false">Weather</a>
            <a class="nav-item nav-link" id="nav-reports-tab" data-toggle="tab" href="#nav-reports" role="tab" aria-controls="nav-reports" aria-selected="false">Reports</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-dashboard" role="tabpanel" aria-labelledby="nav-dashboard-tab"><?php require 'profiledashboard.php'; ?></div>
        <div class="tab-pane fade" id="nav-myshop" role="tabpanel" aria-labelledby="nav-myshop-tab"><?php require 'myshop.php'; ?></div>
        <div class="tab-pane fade" id="nav-weather" role="tabpanel" aria-labelledby="nav-weather-tab"><?php require 'weather.php'; ?></div>
        <div class="tab-pane fade" id="nav-reports" role="tabpanel" aria-labelledby="nav-reports-tab"><?php require 'reports.php'; ?></div>
    </div>
        
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>


<?php 
    require 'foot.php';
?>