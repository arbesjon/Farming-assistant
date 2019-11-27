<?php 
    require 'inc/conn.php';
    session_start();

    if($_SESSION['username'] != null){
        require 'nav.php';
        require 'addproduct.php';
    } else {
        require 'navguest.php';
    }

    $id = $_SESSION['farmerid'];

    $querycrops = 'SELECT * FROM Crops';
    $selectcrops =  $conn->prepare($querycrops);
    $selectcrops->execute();
    $resultcrops = $selectcrops->fetchAll();


    if(isset($_POST['search'])){

        $cropname = $_POST['cropname'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        if($from == "" || $to == ""){
            $query='SELECT * FROM Shop INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid INNER JOIN Measure ON Measure.measureid = Harvest.measureid
            INNER JOIN Plant ON Plant.plantid = Harvest.plantid INNER JOIN Crops ON Crops.cropid = Plant.cropid
             WHERE Crops.cropname LIKE :cropname';

            $select =  $conn->prepare($query);
            $select->bindValue(':cropname', '%' . $cropname . '%', PDO::PARAM_INT);
        } else {
            $query = 'SELECT * FROM Shop INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid INNER JOIN Measure ON Measure.measureid = Harvest.measureid
            INNER JOIN Plant ON Plant.plantid = Harvest.plantid INNER JOIN Crops ON Crops.cropid = Plant.cropid
            WHERE Crops.cropname LIKE :cropname AND Shop.price BETWEEN :from AND :to';

            $select =  $conn->prepare($query);
            $select->bindValue(':cropname', '%' . $cropname . '%', PDO::PARAM_INT);
            $select->bindValue('from', $from);
            $select->bindValue('to', $to);
        }

        $select->execute();

        $result = $select->fetchAll();

    } else {
    
        $query = 'SELECT * FROM Shop
         INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
         INNER JOIN Measure ON Measure.measureid = Harvest.measureid
         INNER JOIN Plant ON Plant.plantid = Harvest.plantid
         INNER JOIN Crops ON Crops.cropid = Plant.cropid';

        $select =  $conn->prepare($query);
        $select->execute();

        $result = $select->fetchAll();
    }
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
        <form method="post" name="search" onsubmit="return validateForm();">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select id="inputState" class="form-control" name="cropname">
                        <option value="" selected>Crop Name</option>
                        <optgroup label = "Crops">
                        <?php foreach($resultcrops as $crop){
                            if($crop['cropcategoryid'] == 1){ ?>
                                <option value="<?php echo $crop['cropname'];   ?>"><?php echo $crop['cropname']; ?></option>
                            <?php } 
                            }?>
                        </optgroup>
                        <optgroup label = "Fruit">
                        <?php foreach($resultcrops as $crop){
                            if($crop['cropcategoryid'] == 2){ ?>
                                <option value="<?php echo $crop['cropname'];   ?>"><?php echo $crop['cropname']; ?></option>
                            <?php } 
                            }?>
                        </optgroup>
                        <optgroup label = "Vegetables">
                        <?php foreach($resultcrops as $crop){
                            if($crop['cropcategoryid'] == 3){ ?>
                                <option value="<?php echo $crop['cropname'];   ?>"><?php echo $crop['cropname']; ?></option>
                            <?php } 
                            }?>
                        </optgroup>
                    </select>
                </div>
                
                <div class="form-group col-md-2">
                    <input type="number" class="form-control" id="inputZip" placeholder="price -from-" value="" name="from">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" class="form-control" id="inputZip" placeholder="price -to-" value="" name="to"> 
                </div>
                
                <div class="input-group-append">
                    <span> <button type="submit" id="btnshop" name="search" class="btn btn-info">Search</button>
                    <?php if($_SESSION['username'] != null){ ?>
                    <span> <button type="button" id="btnshop" name="addproduct" class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Product</button></span>
                    <?php } else { ?>
                        <span><a href="login"> <button type="button" id="btnshop" name="addproduct" class="btn btn-success">Login</button></a></span>
                   <?php } ?>
                    </span> 
                </div>
            </div>
        </form>

    <br>
    <br>

    <div class="row">
        <?php foreach($result as $shop){
            if($shop['plantcategoryid'] == 2 && $shop['shopstatusid'] == 1){ ?>
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
                    </div>
                </div>
            <?php
            }
        } ?>
    </div>

    <script>

function validateForm() {
    var from = document.forms["search"]["from"].value;
    var to = document.forms["search"]["to"].value;

    if (from == "" || to == "") {
        return true;
    }

    if (from < 0 || from > to) {
        alert("Please write correct price");
        return false;
    }
    if (to < 0 || to <= from) {
        alert("Please write correct price");
        return false;
    }
}

</script>

    
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>


<?php 
    require 'foot.php';
?>