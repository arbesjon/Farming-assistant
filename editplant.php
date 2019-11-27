<?php

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $idf = $_SESSION['farmerid'];

    $querycrops = 'SELECT * FROM Crops';
    $selectcrops = $conn->prepare($querycrops);
    $selectcrops->execute();

    $crops = $selectcrops->fetchAll();


    $queryfields = 'SELECT * FROM Fields WHERE farmerid = :id';
    $selectfields = $conn->prepare($queryfields);
    $selectfields->bindParam('id', $idf);
    $selectfields->execute();

    $fields = $selectfields->fetchAll();



    $queryplantedit = 'SELECT * FROM Plant INNER JOIN Crops on Crops.cropid = Plant.cropid INNER JOIN Fields ON Fields.fieldid = Plant.fieldid WHERE Plant.plantid = :id';

    $selectedit =  $conn->prepare($queryplantedit);
    $selectedit->bindParam('id', $id);
    $selectedit->execute();

    $plant = $selectedit->fetch();

    if(isset($_POST['editplant'])){
        $plantname = $_POST['plantname'];
        $cropid = $_POST['cropid'];
        $fieldid = $_POST['fieldid'];
        $plantdate = $_POST['plantdate'];
        $plantcosts = $_POST['plantcosts'];

        $queryplantupdate = 'UPDATE Plant SET plantname = :plantname, cropid = :cropid, fieldid = :fieldid, 
        plantdate = :plantdate, plantcosts = :plantcosts WHERE plantid = :id';

        $updateplant =  $conn->prepare($queryplantupdate);
        $updateplant->bindParam('id', $id);
        $updateplant->bindParam('plantname', $plantname);
        $updateplant->bindParam('cropid', $cropid);  
        $updateplant->bindParam('fieldid', $fieldid);
        $updateplant->bindParam('plantdate', $plantdate);
        $updateplant->bindParam('plantcosts', $plantcosts);

        if($updateplant->execute()) { ?>
        <script> alert("Successfully updated your plant!")
                window.location = 'crops'</script>
            <?php
                header("Location: crops");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while updating your plant") </script>
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
        <a class="font-weight-light" id="title">Edit Plant</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Crop:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="cropid">
                    <optgroup label = "Crops">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 1){ ?>
                            <option value="<?php echo $crop['cropid']; ?>"
                             <?php if($plant['cropid'] == $crop['cropid']){?> selected <?php } ?>
                             ><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                    <optgroup label = "Fruit">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 2){ ?>
                            <option value="<?php echo $crop['cropid']; ?>"
                             <?php if($plant['cropid'] == $crop['cropid']){?> selected <?php } ?>
                             ><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                    <optgroup label = "Vegetables">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 3){ ?>
                            <option value="<?php echo $crop['cropid']; ?>"
                             <?php if($plant['cropid'] == $crop['cropid']){?> selected <?php } ?>
                             ><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="plantname" placeholder="Name" value="<?php echo $plant['plantname']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Field:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="fieldid">
                    <?php
                        foreach($fields as $field){ ?>
                        <option value="<?php echo $field['fieldid']; ?>"
                        <?php if($plant['fieldid'] == $field['fieldid']){?> selected <?php } ?>
                        ><?php echo $field['fieldname']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Plant Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="plantdate" placeholder="Date" value="<?php echo $plant['plantdate']; ?>">
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Plant Cost:</label>
            <div class="input-group">
                <input type="text" class="form-control" name="plantcosts" aria-label="Amount (to the nearest dollar)" placeholder="Cost" value="<?php echo $plant['plantcosts']; ?>">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editplant" class="btn btn-success">Edit</button>
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