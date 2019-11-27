<?php

    $id = $_SESSION['farmerid'];

    if(isset($_POST['addcity'])){

        $cityname = $_POST['cityname'];
        $weatherid = $_POST['weatherid'];

        if($cityname == ""){
            $message = "City Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($weatherid == "") {
            $message = "Weather ID must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {


        $querycityadd = 'INSERT INTO City (cityname, weatherid) 
        VALUES (:cityname, :weatherid)';

        $insertcity =  $conn->prepare($querycityadd);
        $insertcity->bindParam('cityname', $cityname);
        $insertcity->bindParam('weatherid', $weatherid);

        if($insertcity->execute()) { ?>
        <script> alert("Successfully added your city!")
                window.location = 'cpanel'</script>
            <?php
                header("Location: cpanel");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your city") </script>
        <?php }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
  <title></title>
</head>
<body>


  
  <!-- Modal -->
  <div class="modal fade" id="myModalCity" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Add City</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" enctype="multipart/form-data" name="addcity" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">City Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="cityname" placeholder="City Name">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Weather ID:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="weatherid" placeholder="Weather Name">
            </div>
            
            <div class="modal-footer">
                <button type="submit" name="addcity" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

  <script>

function validateForm() {
    var cityname = document.forms["addcity"]["cityname"].value;
    var weatherid = document.forms["addtask"]["weatherid"].value;

    if (cityname == "") {
        alert("City Name must be filled out");
        return false;
    }
    if (weatherid == "") {
        alert("Weather ID must be filled out");
        return false;
    }
}

</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 