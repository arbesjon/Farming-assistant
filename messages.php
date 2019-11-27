<?php 
    require 'nav.php';

    $id = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Messages INNER JOIN Farmers ON Farmers.farmerid = Messages.senderid WHERE receiverid = :id ORDER BY messageid DESC';

    $query1 ='SELECT * FROM Messages INNER JOIN Farmers ON Farmers.farmerid = Messages.senderid WHERE receiverid = :id AND messageid IN (
      SELECT MAX(messageid)
      FROM Messages
      GROUP BY senderid
  ) ORDER BY msgreadid DESC';

    $select =  $conn->prepare($query1);
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
        <a class="font-weight-light" id="title">Messages</a>
        <a href="readallmessages?farmer=<?php echo $id; ?>">
        <button type="button" id="addPlant" class="btn btn-success">Read All</button></a>
    </span>

    <table class="table">
  <thead class="thead-dark">
    <tr id="table">
      <th scope="col"></th>
      <th scope="col">#</th>
      <th scope="col">Sender</th>
      <th scope="col">Sent</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      if ($select->rowCount() == 0){ ?>
        <tr id="table">
        <th scope="row"></th>
            <td></td>
            <td>No Messages</td>
        </tr>
      <?php }
        foreach($result as $message){
          if($message['msgreadid'] == 1){?>
                <tr id="table">
            <?php } else {?>
                <tr class="bg-info" id="tabler">
            <?php } ?>
            <th scope="row"></th>
            <?php if($message['msgreadid'] == 1){?>
                <td><img class"image" src="img/read.png"</td>
            <?php } else {?>
                <td><img class"image" src="img/unread.png"</td>
            <?php } ?>
            <td><?php echo $message['username'] ?></td>
            <td><?php echo $message['msgsent'] ?></td>
            <td>
              <a href="messagedetails?id=<?php echo $message['messageid']; ?>&shop=<?php echo $message['shopid']; ?>">
              <button type="button" class="btn btn-success" id="edit">Open</button></a>
              <a href="deletemessage?id=<?php echo $message['messageid']; ?>" onclick="return confirm('Are you sure?')">
              <button type="button" class="btn btn-danger">Delete</button></a>
              <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
            </td>
            </tr>
            <?php 
              if (isset($_GET['id']) && $_GET['id'] == $alarm['alarmid'] && $alarm['farmerid'] == $_SESSION['farmerid']) { ?>
                <script>
                  document.getElementById("mm").click();
                </script>
              <?php }
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