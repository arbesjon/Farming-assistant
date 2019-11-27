<?php

    $id = $_SESSION['farmerid'];

    $querydimensions = 'SELECT * FROM Dimension';
    $selectdimensions = $conn->prepare($querydimensions);
    $selectdimensions->execute();

    $dimensions = $selectdimensions->fetchAll();


    if(isset($_POST['addfield'])){
        $fieldname = $_POST['fieldname'];
        $surface = $_POST['surface'];
        $dimensionid = $_POST['dimensionid'];
        $farmerid = $id;

        $queryfieldadd = 'INSERT INTO Fields (fieldname, surface, dimensionid, farmerid) 
        VALUES (:fieldname, :surface, :dimensionid, :farmerid)';

        $selectfield =  $conn->prepare($queryfieldadd);
        $selectfield->bindParam('fieldname', $fieldname);
        $selectfield->bindParam('surface', $surface);  
        $selectfield->bindParam('dimensionid', $dimensionid);
        $selectfield->bindParam('farmerid', $farmerid);

        if($selectfield->execute()) { ?>
        <script> alert("Successfully added your field!")
                window.location = 'fields'</script>
            <?php
                header("Location: fields");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your field") </script>
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
  <div class="modal fade" id="myModalAdd" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Add Field</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="fieldname" placeholder="Name">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Surface:</label>
                    <input type="text" class="form-control" id="inputCity" name="surface" placeholder="Surface">
                </div>
                <div class="form-group col-md-4">
                    <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">*</label>
                    <select id="inputState" class="form-control" name="dimensionid">
                        <?php
                            foreach($dimensions as $dimension){ ?>
                            <option value="<?php echo $dimension['dimensionid']; ?>"><?php echo $dimension['dimensionname']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addfield" class="btn btn-success">Add</button>
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