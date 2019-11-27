<?php 
    require 'nav.php';

?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
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

    
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-dashboard-tab" data-toggle="tab" href="#nav-dashboard" role="tab" aria-controls="nav-dashboard" aria-selected="false">Dashboard</a>
            <a class="nav-item nav-link" id="nav-farmers-tab" data-toggle="tab" href="#nav-farmers" role="tab" aria-controls="nav-farmers" aria-selected="false">Farmers</a>
            <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="false">Details</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-dashboard" role="tabpanel" aria-labelledby="nav-dashboard-tab"><?php require 'admindashboard.php'; ?></div>
        <div class="tab-pane fade" id="nav-farmers" role="tabpanel" aria-labelledby="nav-farmers-tab"><?php require 'farmers.php'; ?></div>
        <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab"><?php require 'admindetails.php'; ?></div>
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