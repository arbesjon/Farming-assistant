<?php

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $idf = $_SESSION['farmerid'];

    $queryplant = 'SELECT * FROM Plant WHERE farmerid = :id';
    $selectplant = $conn->prepare($queryplant);
    $selectplant->bindParam('id', $idf);
    $selectplant->execute();

    $plants = $selectplant->fetchAll();


    $querymeasure = 'SELECT * FROM Measure';
    $selectmeasure = $conn->prepare($querymeasure);
    $selectmeasure->execute();

    $measures = $selectmeasure->fetchAll();


    $queryharvesteid = 'SELECT * FROM Harvest INNER JOIN Plant on Plant.plantid = Harvest.plantid INNER JOIN Crops ON Crops.cropid = Plant.cropid INNER JOIN Measure ON Measure.measureid = Harvest.measureid
     WHERE Harvest.harvestid = :id';

    $selectedit =  $conn->prepare($queryharvesteid);
    $selectedit->bindParam('id', $id);
    $selectedit->execute();

    $harvest = $selectedit->fetch();

    if(isset($_POST['editharvest'])){
        $quantity = $_POST['quantity'];
        $measureid = $_POST['measureid'];
        $plantid = $_POST['plantid'];
        $harvestdate = $_POST['harvestdate'];
        $harvestcosts = $_POST['harvestcosts'];

        $queryharvestupdate = 'UPDATE Harvest SET quantity = :quantity, measureid = :measureid, plantid = :plantid, 
        harvestdate = :harvestdate, harvestcosts = :harvestcosts WHERE harvestid = :id';

        $updateharvest =  $conn->prepare($queryharvestupdate);
        $updateharvest->bindParam('quantity', $quantity);
        $updateharvest->bindParam('measureid', $measureid);  
        $updateharvest->bindParam('plantid', $plantid);
        $updateharvest->bindParam('harvestdate', $harvestdate);
        $updateharvest->bindParam('harvestcosts', $harvestcosts);
        $updateharvest->bindParam('id', $id);

        if($updateharvest->execute()) { ?>
        <script> alert("Successfully updated your harvest!")
                window.location = 'harvest'</script>
            <?php
                header("Location: harvest");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while updating your harvest") </script>
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
  <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Edit Harvest</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Plant:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="plantid">
                    <?php foreach($plants as $plant){
                         if($plant['plantcategoryid'] == 2){ ?>
                            <option value="<?php echo $plant['plantid'];   ?>"
                            <?php if($harvest['plantid'] == $plant['plantid']){?> selected <?php } else { ?> disabled <?php } ?>
                            ><?php echo $plant['plantname']; ?></option>
                        <?php } 
                        }?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Quantity:</label>
                    <input type="text" class="form-control" id="inputCity" name="quantity" placeholder="Quantity" value="<?php echo $harvest['quantity']; ?>">
                </div>
                <div class="form-group col-md-4">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">*</label>
                    <select id="inputState" class="form-control" name="measureid">
                        <?php
                            foreach($measures as $measure){ ?>
                            <option value="<?php echo $measure['measureid']; ?>"
                            <?php if($harvest['measureid'] == $measure['measureid']){?> selected <?php } ?>
                            ><?php echo $measure['measurename']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Harvest Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="harvestdate" placeholder="Date" value="<?php echo $harvest['harvestdate']; ?>">
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Harvest Cost:</label>
            <div class="input-group">
                <input type="text" class="form-control" name="harvestcosts" aria-label="Amount (to the nearest dollar)" placeholder="Cost" value="<?php echo $harvest['harvestcosts']; ?>">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editharvest" class="btn btn-success">Edit</button>
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