<?php

    $id = $_SESSION['farmerid'];

    $querycrops = 'SELECT * FROM Crops';
    $selectcrops = $conn->prepare($querycrops);
    $selectcrops->execute();

    $crops = $selectcrops->fetchAll();


    $queryfields = 'SELECT * FROM Fields WHERE farmerid = :id';
    $selectfields = $conn->prepare($queryfields);
    $selectfields->bindParam('id', $id);
    $selectfields->execute();

    $fields = $selectfields->fetchAll();


    if(isset($_POST['addplant'])){
        $plantname = $_POST['plantname'];
        $cropid = $_POST['cropid'];
        $fieldid = $_POST['fieldid'];
        $plantdate = $_POST['plantdate'];
        $farmerid = $id;
        $plantcosts = $_POST['plantcosts'];
        $plantcategoryid = "1";

        if($plantname == ""){
            $message = "Plant Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($plantcosts == "" || $plantcosts < 0) {
            $message = "Plant Cost must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if ($plantdate == null) {
            $message = "Plant Date must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

            $queryplantadd = 'INSERT INTO Plant (plantname, cropid, fieldid, plantdate, farmerid, plantcosts, plantcategoryid) 
            VALUES (:plantname, :cropid, :fieldid, :plantdate, :farmerid, :plantcosts, :plantcategoryid)';

            $selectplant =  $conn->prepare($queryplantadd);
            $selectplant->bindParam('plantname', $plantname);
            $selectplant->bindParam('cropid', $cropid);  
            $selectplant->bindParam('fieldid', $fieldid);
            $selectplant->bindParam('plantdate', $plantdate);
            $selectplant->bindParam('farmerid', $farmerid);
            $selectplant->bindParam('plantcosts', $plantcosts);
            $selectplant->bindParam('plantcategoryid', $plantcategoryid);

            if($selectplant->execute()) { ?>
            <script> alert("Successfully added your plant!")
                    window.location = 'plants'</script>
                <?php
                    header("Location: plants");
                    exit;
                ?>
            <?php } else { ?>
                <script> alert("A problem occurred while creating your plant") </script>
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
        <a class="font-weight-light" id="title">Add Plant</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" name="addplant" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Crop:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="cropid">
                    <optgroup label = "Crops">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 1){ ?>
                            <option value="<?php echo $crop['cropid'];   ?>"><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                    <optgroup label = "Fruit">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 2){ ?>
                            <option value="<?php echo $crop['cropid'];   ?>"><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                    <optgroup label = "Vegetables">
                    <?php foreach($crops as $crop){
                         if($crop['cropcategoryid'] == 3){ ?>
                            <option value="<?php echo $crop['cropid'];   ?>"><?php echo $crop['cropname']; ?></option>
                        <?php } 
                        }?>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="plantname" placeholder="Name">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Field:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="fieldid">
                    <?php
                        foreach($fields as $field){
                            $queryexist='SELECT * FROM Plant WHERE fieldid=:fid AND plantcategoryid = 1';
                            $selectexists =  $conn->prepare($queryexist);
                            $selectexists->bindParam('fid', $field['fieldid']);
                            $selectexists->execute();
                            if($selectexists->rowCount() > 0){?>
                            <option value="<?php echo $field['fieldid']; ?>" disabled><?php echo $field['fieldname']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $field['fieldid']; ?>"><?php echo $field['fieldname']; ?></option>
                    <?php   }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Plant Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="plantdate" placeholder="Date">
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Plant Cost:</label>
            <div class="input-group">
                <input type="number" class="form-control" name="plantcosts" aria-label="Amount (to the nearest dollar)" placeholder="Cost">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addplant" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

  <script>

    function validateForm() {
        var plantname = document.forms["addplant"]["plantname"].value;
        var plantdate = document.forms["addplant"]["plantdate"].value;
        var plantcosts = document.forms["addplant"]["plantcosts"].value;

        if (plantname == "") {
            alert("Plant Name must be filled out");
            return false;
        }
        if (plantdate == "") {
            alert("Plant Date must be filled out");
            return false;
        }
        if (plantcosts == "" || plantcosts < 0) {
            alert("Plant Costs must be filled out");
            return false;
        }
    }

</script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 