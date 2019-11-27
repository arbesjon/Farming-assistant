<?php

    $idf = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Shop
        INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
        INNER JOIN Measure ON Measure.measureid = Harvest.measureid
        INNER JOIN Plant ON Plant.plantid = Harvest.plantid
        INNER JOIN Crops ON Crops.cropid = Plant.cropid
        WHERE Plant.farmerid = :id';

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
    <link href="css/shopcss.css" rel="stylesheet">
    <script src="js/plants.js"></script>

    <title> </title>
  </head>
  <body>
    <br>
    <br>
    <br>
    <div class="container">

    <div class="row">
        <?php foreach($result as $shop){
            if($shop['plantcategoryid'] == 2){ ?>
                <div class="card" id="card">
                    <div class="d-flex justify-content-end">
                        <a id="pdate" class="font-weight-light"><?php echo $shop['publishdate']; ?></a>
                    </div>
                    <img class="card-img-top" id="cardimg" src="img/icons/<?php echo $shop['image'];?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 id="formtext" class="card-title"><?php echo $shop['cropname'];?></h5>
                        <p class="card-text">Price: <strong><?php echo $shop['price'];?>€</strong></p>
                        <p class="card-text">Quantity: <strong><?php echo $shop['quantity'] . $shop['measurename'];?></strong></p>
                        <a href="shopdetails?id=<?php echo $shop['shopid']; ?>" class="btn btn-primary">MORE</a>
                        <div class="d-flex justify-content-end">
                        <?php if($shop['shopstatusid'] == 1){?>
                            <p class="text-success"><strong>Active</strong></p>
                        <?php } else {?>
                            <p class="text-info"><strong>Sold</strong></p>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
            }
        } ?>
    </div>

    
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>
