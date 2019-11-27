<?php

    $id = $_SESSION['farmerid'];

    $queryplant = 'SELECT * FROM Plant WHERE farmerid = :id';
    $selectplant = $conn->prepare($queryplant);
    $selectplant->bindParam('id', $id);
    $selectplant->execute();

    $plants = $selectplant->fetchAll();


    $querymeasure = 'SELECT * FROM Measure';
    $selectmeasure = $conn->prepare($querymeasure);
    $selectmeasure->execute();

    $measures = $selectmeasure->fetchAll();


    if(isset($_POST['addharvest'])){
        $quantity = $_POST['quantity'];
        $measureid = $_POST['measureid'];
        $plantid = $_POST['plantid'];
        $harvestdate = $_POST['harvestdate'];
        $harvestcosts = $_POST['harvestcosts'];
        $shopstatusid = "1";
        $plantcategoryid = "2";

        $queryharvestadd = 'INSERT INTO Harvest (quantity, measureid, plantid, harvestdate, harvestcosts, shopstatusid) 
        VALUES (:quantity, :measureid, :plantid, :harvestdate, :harvestcosts, :shopstatusid)';

        $selectharvest =  $conn->prepare($queryharvestadd);
        $selectharvest->bindParam('quantity', $quantity);
        $selectharvest->bindParam('measureid', $measureid);  
        $selectharvest->bindParam('plantid', $plantid);
        $selectharvest->bindParam('harvestdate', $harvestdate);
        $selectharvest->bindParam('harvestcosts', $harvestcosts);
        $selectharvest->bindParam('shopstatusid', $shopstatusid);

        if($selectharvest->execute()) { 

            $queryplantupdatecategory = 'UPDATE Plant SET plantcategoryid = :plantcategoryid WHERE plantid = :id';
            $updateplantcategory =  $conn->prepare($queryplantupdatecategory);
            $updateplantcategory->bindParam('id', $plantid);
            $updateplantcategory->bindParam('plantcategoryid', $plantcategoryid);
            $updateplantcategory->execute(); ?>

        <script> alert("Successfully added your harvest!")
                window.location = 'harvest'</script>
            <?php
                header("Location: harvest");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your harvest") </script>
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Add Harvest</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Plant:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="plantid">
                    <?php foreach($plants as $plant){
                         if($plant['plantcategoryid'] == 1){ ?>
                            <option value="<?php echo $plant['plantid'];   ?>"><?php echo $plant['plantname']; ?></option>
                        <?php } 
                        }?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Quantity:</label>
                    <input type="text" class="form-control" id="inputCity" name="quantity" placeholder="Quantity">
                </div>
                <div class="form-group col-md-4">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">*</label>
                    <select id="inputState" class="form-control" name="measureid">
                        <?php
                            foreach($measures as $measure){ ?>
                            <option value="<?php echo $measure['measureid']; ?>"><?php echo $measure['measurename']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Harvest Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="harvestdate" placeholder="Date">
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Harvest Cost:</label>
            <div class="input-group">
                <input type="text" class="form-control" name="harvestcosts" aria-label="Amount (to the nearest dollar)" placeholder="Cost">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addharvest" class="btn btn-success">Add</button>
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