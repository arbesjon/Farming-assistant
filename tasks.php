<?php 
    require 'nav.php';
    require 'addtask.php';


    date_default_timezone_set('Europe/Skopje');
    $today = strtotime(date('Y-m-d'));

    $id = $_SESSION['farmerid'];
    $tid = "1";

    $query = 'SELECT * FROM Tasks
     INNER JOIN Category on Category.categoryid = Tasks.categoryid
      LEFT JOIN Fields ON Fields.fieldid = Tasks.fieldid
     WHERE Tasks.farmerid = :id AND Tasks.taskstatusid = :tid
     ORDER BY Tasks.startdate';

    $select =  $conn->prepare($query);
    $select->bindParam('id', $id);
    $select->bindParam('tid', $tid);
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
        <a class="font-weight-light" id="title">Tasks</a>
        <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModal">+ Task</button>
    </span>

    <table class="table">
  <thead class="thead-dark">
    <tr id="table">
      <th scope="col"></th>
      <th scope="col">Task Name</th>
      <th scope="col">Date</th>
      <th scope="col">Category</th>
      <th scope="col">Field</th>
      <th scope="col">Description</th>
      <th scope="col">Finished</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      if ($select->rowCount() == 0){ ?>
        <tr id="table">
        <th scope="row"></th>
            <td></td>
            <td></td>
            <td>No tasks</td>
        </tr>
      <?php }
        foreach($result as $task){ 
          if($task['taskstatusid'] == 1){
          if(strtotime($task['startdate']) <= $today && strtotime($task['enddate']) >= $today){?>
            <tr class="table-info" id="table">
          <?php } else { ?>
            <tr id="table">
          <?php } ?>
            <th scope="row"></th>
            <td><?php echo $task['taskname'] ?></td>
            <td><?php echo $task['startdate'] ?> <strong>to</strong> <?php echo $task['enddate'] ?></td>
            <td><?php echo $task['categoryname'] ?></td>
            <?php if($task['fieldid'] != null){?>
              <td><?php echo $task['fieldname'] ?></td>
            <?php } else {  ?>
              <td> - </td>
            <?php } ?>
            <td><?php echo nl2br($task['description']) ?></td>
            <td>
                <a href="donetask?id=<?php echo $task['taskid']; ?>">
              <button type="button" class="btn btn-success" id="edit">Done</button></a>
            </td>
            <td>
              <a href="?id=<?php echo $task['taskid']; ?>">
              <button type="button" class="btn btn-info" id="edit">Edit</button></a>
              <a href="deletetask?id=<?php echo $task['taskid']; ?>" onclick="return confirm('Are you sure?')">
              <button type="button" class="btn btn-danger">Delete</button></a>
              <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
            </td>
            </tr>
            <?php 
              if (isset($_GET['id']) && $_GET['id'] == $harvest['harvestid'] && $harvest['farmerid'] == $_SESSION['farmerid']) { ?>
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