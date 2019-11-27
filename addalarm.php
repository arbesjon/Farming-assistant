<?php

    $id = $_SESSION['farmerid'];

    if(isset($_POST['addalarm'])){
        $alarmname = $_POST['alarmname'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $farmerid = $id;
        $alarmcategoryid = "1";

        if($alarmname == ""){
            $message = "Alarm Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($description == "") {
            $message = "Description must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if ($date == null) {
            $message = "Date must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $queryalarmadd = 'INSERT INTO Alarm (alarmname, date, description, farmerid, alarmcategoryid) 
        VALUES (:alarmname, :date, :description, :farmerid, :alarmcategoryid)';

        $selectalarm =  $conn->prepare($queryalarmadd);
        $selectalarm->bindParam('alarmname', $alarmname);
        $selectalarm->bindParam('date', $date);  
        $selectalarm->bindParam('description', $description);
        $selectalarm->bindParam('farmerid', $farmerid);
        $selectalarm->bindParam('alarmcategoryid', $alarmcategoryid);

        if($selectalarm->execute()) { ?>
        <script> alert("Successfully added your alarm!")
                window.location = 'alarms'</script>
            <?php
                header("Location: alarms");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your alarm") </script>
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Add Alarm</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" name="addalarm" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Alarm Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="alarmname" placeholder="Name">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Alarm Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="date" placeholder="Date">
            </div>
            <div class="form-group">
                <label id="formtext" for="exampleFormControlTextarea1" class="font-weight-bold">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addalarm" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

  <script>

function validateForm() {
    var alarmname = document.forms["addalarm"]["alarmname"].value;
    var date = document.forms["addalarm"]["date"].value;
    var description = document.forms["addalarm"]["description"].value;

    if (alarmname == "") {
        alert("Alarm Name Name must be filled out");
        return false;
    }
    if (date == "") {
        alert("Date Date must be filled out");
        return false;
    }
    if (description == "") {
        alert("Description must be filled out");
        return false;
    }
}

</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 