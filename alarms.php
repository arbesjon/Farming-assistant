<?php 
    require 'nav.php';
    require 'addalarm.php';
    require 'editalarm.php';

    $id = $_SESSION['farmerid'];

    date_default_timezone_set('Europe/Skopje');
    $today = date('Y-m-d');

    $query = 'SELECT * FROM Alarm WHERE farmerid = :id ORDER BY date DESC';

    $select =  $conn->prepare($query);
    $select->bindParam('id', $id);
    $select->execute();

    $result = $select->fetchAll();
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
    <script src="js/plants.js"></script>

    <title> </title>
  </head>
  <body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
    <span>
        <a class="font-weight-light" id="title">Alarms</a>
        <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModal">+ Alarm</button>
    </span>

    <table class="table">
  <thead class="table-primary">
    <tr id="table">
      <th scope="col"></th>
      <th scope="col">Alarm</th>
      <th scope="col">Date</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      if ($select->rowCount() == 0){ ?>
        <tr id="table">
        <th scope="row"></th>
            <td></td>
            <td>No alarm</td>
        </tr>
      <?php }
        foreach($result as $alarm){
          if($alarm['alarmcategoryid'] == 1){
            if($alarm['date'] == $today){?>
                <tr class="table-danger" id="table">
            <?php } elseif($alarm['date'] < $today){?>
                <tr class="table-warning" id="table">
            <?php } else { ?>
                <tr id="table">
            <?php } ?>
            <th scope="row"></th>
            <td><?php echo $alarm['alarmname'] ?></td>
            <td><?php echo $alarm['date'] ?></td>
            <td><?php echo nl2br($alarm['description']) ?></td>
            <td>
              <a href="?id=<?php echo $alarm['alarmid']; ?>">
              <button type="button" class="btn btn-info" id="edit">Edit</button></a>
              <a href="dismissalarm?id=<?php echo $alarm['alarmid']; ?>" onclick="return confirm('Are you sure?')">
              <button type="button" class="btn btn-danger">Dismiss</button></a>
              <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
            </td>
            </tr>
            <?php 
              if (isset($_GET['id']) && $_GET['id'] == $alarm['alarmid'] && $alarm['farmerid'] == $_SESSION['farmerid']) { ?>
                <script>
                  document.getElementById("mm").click();
                </script>
              <?php }
            }
        } ?>
  </tbody>
</table>
</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>


<?php 
    require 'foot.php';
?>