<?php

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $idf = $_SESSION['farmerid'];

    $queryalarmid = 'SELECT * FROM Alarm WHERE alarmid = :id';
    $selectedit =  $conn->prepare($queryalarmid);
    $selectedit->bindParam('id', $id);
    $selectedit->execute();

    $alarm = $selectedit->fetch();   
    
    if(isset($_POST['editalarm'])){
        $alarmname = $_POST['alarmname'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $queryalarmupdate = 'UPDATE Alarm SET alarmname = :alarmname, date = :date, description = :description 
         WHERE alarmid = :id';

        $selectalarm =  $conn->prepare($queryalarmupdate);
        $selectalarm->bindParam('alarmname', $alarmname);
        $selectalarm->bindParam('date', $date);  
        $selectalarm->bindParam('description', $description);
        $selectalarm->bindParam('id', $id);

        if($selectalarm->execute()) { ?>
        <script> alert("Successfully updated your alarm!")
                window.location = 'alarms'</script>
            <?php
                header("Location: alarms");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while updating your alarm") </script>
        <?php }
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
  <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Edit Alarm</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Alarm Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="alarmname" placeholder="Name" value="<?php echo $alarm['alarmname']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Alarm Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="date" placeholder="Date" value="<?php echo $alarm['date']; ?>">
            </div>
            <div class="form-group">
                <label id="formtext" for="exampleFormControlTextarea1" class="font-weight-bold">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description"><?php echo $alarm['description']; ?></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editalarm" class="btn btn-success">Edit</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 