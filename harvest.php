<?php 
    require 'nav.php';
    require 'addharvest.php';
    require 'editharvest.php';

    $id = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Harvest INNER JOIN Plant on Plant.plantid = Harvest.plantid INNER JOIN Crops ON Crops.cropid = Plant.cropid INNER JOIN Measure ON Measure.measureid = Harvest.measureid
     WHERE Plant.farmerid = :id ORDER BY CAST(Harvest.harvestdate AS DATE)';

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
        <a class="font-weight-light" id="title">Harvested</a>
        <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModal">+ Harvest</button>
    </span>

    <table class="table">
  <thead class="table-warning">
    <tr id="table">
      <th scope="col"></th>
      <th scope="col">#</th>
      <th scope="col">Crop Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Harvest Date</th>
      <th scope="col">Harvest Cost</th>
      <th scope="col">All Costs</th>
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
            <td>No harvest</td>
        </tr>
      <?php }
        foreach($result as $harvest){
          if($harvest['plantcategoryid'] == 2 && $harvest['shopstatusid'] == 1){?>
            <tr id="table">
            <th scope="row"></th>
            <td><img class"image" src="img/icons/<?php echo $harvest['image'] ?>"</td>
            <td><?php echo $harvest['plantname'] ?></td>
            <td><?php echo $harvest['quantity'] . $harvest['measurename']; ?></td>
            <td><?php echo $harvest['harvestdate'] ?></td>
            <td><?php echo $harvest['harvestcosts'] ?>€</td>
            <td><?php echo $harvest['harvestcosts'] + $harvest['plantcosts']; ?>€</td>
            <td>
              <a href="?id=<?php echo $harvest['harvestid']; ?>">
              <button type="button" class="btn btn-info" id="edit">Edit</button></a>
              <a href="deleteharvest?id=<?php echo $harvest['harvestid']; ?>" onclick="return confirm('Are you sure?')">
              <button type="button" class="btn btn-danger">Delete</button></a>
              <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
            </td>
            </tr>
            <?php 
              if (isset($_GET['id']) && $_GET['id'] == $harvest['harvestid'] && $harvest['farmerid'] == $_SESSION['farmerid']) { ?>
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