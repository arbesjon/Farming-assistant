<?php 

    require 'inc/conn.php';
    session_start();

    if($_SESSION['username'] != null){
        require 'nav.php';
        require 'sendmessage.php';
    } else {
        require 'navguest.php';
    }
    

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $idf = $_SESSION['farmerid'];

    $queryshop = 'SELECT * FROM Shop
     INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
     INNER JOIN Measure ON Measure.measureid = Harvest.measureid 
     INNER JOIN Plant ON Plant.plantid = Harvest.plantid
     INNER JOIN Farmers ON Farmers.farmerid = Plant.farmerid
     INNER JOIN Crops ON Crops.cropid = Plant.cropid
     WHERE Shop.shopid = :id';

    $selectshop =  $conn->prepare($queryshop);
    $selectshop->bindParam('id', $id);
    $selectshop->execute();
    $crop = $selectshop->fetch();

    

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

    <div class="mx-auto" style="width: 18rem;">
        <div class="card" style="width: 18rem;">
            <div class="d-flex justify-content-end">
                <a id="pdate" class="font-weight-light"><?php echo $crop['publishdate']; ?></a>
            </div>
            <img class="card-img-top" id="cardimg" src="img/icons/<?php echo $crop['image'];?>" alt="Card image cap">
            <div class="card-body">
                <h5 id="formtext" class="card-title"><?php echo $crop['cropname']; ?></h5>
                <p class="card-text"><?php echo nl2br($crop['description']); ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Price: <strong><?php echo $crop['price']; ?>€</strong></li>
                <li class="list-group-item">Qunatity: <strong><?php echo $crop['quantity'] . $crop['measurename']; ?></strong></li>
                <li class="list-group-item">Harvested: <strong><?php echo $crop['harvestdate']; ?></strong></li>
                <div class="d-flex justify-content-end">
                <a id="pdate" class="font-weight-light"><b><?php echo $crop['username']; ?></b></a>
                </div>
            </ul>
            <div class="card-body">
            <?php if($crop['farmerid'] == $idf){?>
                <a href="#" class="card-link"><button type="button" class="btn btn-info">edit</button></a> <br><br>
                <a href="deleteshop?id=<?php echo $crop['shopid']; ?>" onclick="return confirm('Are you sure?')" class="card-link"><button type="button" class="btn btn-danger">delete</button></a> <br><br>
                <a href="soldproduct?id=<?php echo $crop['harvestid'] ?>" class="card-link"><button type="button" class="btn btn-success">sold</button></a>
            <?php } else { ?>
                <?php if($_SESSION['username'] != null){ ?>
                <a href="?id=<?php echo $crop['shopid']?>&farmer=<?php echo $crop['farmerid']?>" class="card-link"><button type="button" class="btn btn-info">Send Message</button></a>
                <?php } else {?>
                    <a href="login" class="card-link"><button type="button" class="btn btn-info">login to Send Message</button></a>
                <?php } ?>
            <?php } ?>
            <button type="button" id="mm" data-toggle="modal" data-target="#myModalMsg"></button>

                <?php if (isset($_GET['farmer']) && $_GET['farmer'] != $_SESSION['farmerid'] && $_SESSION['farmerid'] != null) { ?>
                    <script>
                    document.getElementById("mm").click();
                    </script>
                <?php }?>

            </div>
        </div>
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