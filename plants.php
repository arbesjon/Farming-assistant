
<?php 
    require 'nav.php';
    require 'addplant.php';
    require 'editplant.php';

    $id = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Plant INNER JOIN Crops on Crops.cropid = Plant.cropid INNER JOIN Fields ON Fields.fieldid = Plant.fieldid WHERE Plant.farmerid = :id ORDER BY CAST(plantdate AS DATE)';

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
        <a class="font-weight-light" id="title"><?php echo $lng['Plants'] ?></a>
        <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModal">+ <?php echo $lng['Plant'] ?></button>
    </span>

    <table class="table">
  <thead class="table-success">
    <tr id="table">
      <th scope="col"></th>
      <th scope="col">#</th>
      <th scope="col"><?php echo $lng['PlantName'] ?></th>
      <th scope="col"><?php echo $lng['Field'] ?></th>
      <th scope="col"><?php echo $lng['PlantDate'] ?></th>
      <th scope="col"><?php echo $lng['PlantCost'] ?></th>
      <th scope="col"><?php echo $lng['Action'] ?></th>
    </tr>
  </thead>
  <tbody>
      <?php 
      if ($select->rowCount() == 0){ ?>
        <tr id="table">
        <th scope="row"></th>
            <td></td>
            <td></td>
            <td>No plants</td>
        </tr>
      <?php }
        foreach($result as $plant){
          if($plant['plantcategoryid'] == 1){?>
            <tr id="table">
            <th scope="row"></th>
            <td><img class"image" src="img/icons/<?php echo $plant['image'] ?>"</td>
            <td><?php echo $plant['plantname'] ?></td>
            <td><?php echo $plant['fieldname'] ?></td>
            <td><?php echo $plant['plantdate'] ?></td>
            <td><?php echo $plant['plantcosts'] ?>€</td>
            <td>
              <a href="?id=<?php echo $plant['plantid']; ?>">
              <button type="button" class="btn btn-info" id="edit"><?php echo $lng['Edit'] ?></button></a>
              <a href="deleteplant?id=<?php echo $plant['plantid']; ?>" onclick="return confirm('Are you sure?')">
              <button type="button" class="btn btn-danger"><?php echo $lng['Delete'] ?></button></a>
              <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
            </td>
            </tr>
            <?php 
              if (isset($_GET['id']) && $_GET['id'] == $plant['plantid'] && $plant['farmerid'] == $_SESSION['farmerid']) { ?>
                <script>
                  document.getElementById("mm").click();
                </script>
              <?php }?>
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
