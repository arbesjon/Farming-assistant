<?php

    $id = $_SESSION['farmerid'];

    date_default_timezone_set('Europe/Skopje');

    $queryharvest = 'SELECT * FROM Harvest INNER JOIN Plant ON Plant.plantid = Harvest.plantid WHERE Plant.farmerid = :id';
    $selectharvest = $conn->prepare($queryharvest);
    $selectharvest->bindParam('id', $id);
    $selectharvest->execute();

    $harvests = $selectharvest->fetchAll();

    if(isset($_POST['addproduct'])){
        $harvestid = $_POST['harvestid'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $publishdate = date('Y-m-d');

        if($description == ""){
            $message = "Description must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($price == "" || $price < 0) {
            $message = "Price must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $queryproductadd = 'INSERT INTO Shop (harvestid, price, publishdate, description) 
        VALUES (:harvestid, :price, :publishdate, :description)';

        $selectproduct =  $conn->prepare($queryproductadd);
        $selectproduct->bindParam('harvestid', $harvestid);
        $selectproduct->bindParam('price', $price);  
        $selectproduct->bindParam('publishdate', $publishdate);
        $selectproduct->bindParam('description', $description);

        if($selectproduct->execute()) { ?>
        <script> alert("Successfully publishing your product!")
                window.location = 'shop'</script>
            <?php
                header("Location: shop");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while publishing your product") </script>
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
        <a class="font-weight-light" id="title">Add Product</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" name="addproduct" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Harvested:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="harvestid">
                    <?php foreach($harvests as $harvest){
                            $queryexist='SELECT * FROM Shop WHERE harvestid=:hid';
                            $selectexists =  $conn->prepare($queryexist);
                            $selectexists->bindParam('hid', $harvest['harvestid']);
                            $selectexists->execute();
                            if($selectexists->rowCount() > 0){?>
                            <option value="<?php echo $harvest['harvestid']; ?>" disabled><?php echo $harvest['plantname']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $harvest['harvestid']; ?>" ><?php echo $harvest['plantname']; ?></option>
                         <?php }
                        }?>
                </select>
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Price:</label>
            <div class="input-group">
                <input type="number" class="form-control" name="price" aria-label="Amount (to the nearest dollar)" placeholder="Price">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label id="formtext" for="exampleFormControlTextarea1" class="font-weight-bold">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addproduct" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

  <script>

function validateForm() {
    var price = document.forms["addproduct"]["price"].value;
    var description = document.forms["addproduct"]["description"].value;

    if (price == "" || price < 0) {
        alert("Price must be filled out");
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