<?php

    $id = $_SESSION['farmerid'];

    $querycropcategory = 'SELECT * FROM Cropcategory';
    $selectcropcategory = $conn->prepare($querycropcategory);
    $selectcropcategory->execute();

    $category = $selectcropcategory->fetchAll();

    if(isset($_POST['addcrop'])){

        $cropname = $_POST['cropname'];
        $cropcategoryid = $_POST['cropcategoryid'];

        if($cropname == ""){
            $message = "Crop Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $cropimage = $_FILES['image']['name'];
        $tmp_dir = $_FILES['image']['tmp_name'];

        $upload_dir = 'img/icons/';
        $imageExt = strtolower(pathinfo($cropimage,PATHINFO_EXTENSION));
        $valid_extensions = array('png', 'jpg', 'jpeg', 'gif');
        $imgCrop = $cropname.".".$imageExt;
        $count = 0;
        foreach($valid_extensions as $vaild){
            if($imageExt == $vaild){
                $count++;
            }
        }
        if($count == 0){
            $message = "Please select photo";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            move_uploaded_file($tmp_dir, $upload_dir.$imgCrop);
        

            $querycropadd = 'INSERT INTO Crops (cropname, image, cropcategoryid) 
            VALUES (:cropname, :image, :cropcategoryid)';

            $insertcrop =  $conn->prepare($querycropadd);
            $insertcrop->bindParam('cropname', $cropname);
            $insertcrop->bindParam('image', $imgCrop);  
            $insertcrop->bindParam('cropcategoryid', $cropcategoryid);

            if($insertcrop->execute()) { ?>
            <script> alert("Successfully added your crop!")
                    window.location = 'cpanel'</script>
                <?php
                    header("Location: cpanel");
                    exit;
                ?>
            <?php } else { ?>
                <script> alert("A problem occurred while creating your crop") </script>
            <?php }
            }
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
        <a class="font-weight-light" id="title">Add Crop</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" enctype="multipart/form-data" name="addcrop" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Crop Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="cropname" placeholder="Crop Name">
            </div>
            <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Category:</label>
            <select class="form-control" id="exampleFormControlSelect1" name="cropcategoryid">
                <?php foreach($category as $ca){ ?>
                    <option value="<?php echo $ca['cropcategoryid'];   ?>"><?php echo $ca['cropcategoryname']; ?></option>
                <?php } ?>
            </select>
            <br>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Image:</label>
                <div class="custom-file">
                    <input type="file" name="image" class="form-control" id="exampleFormControlInput1" value="Choose image">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="submit" name="addcrop" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

   <script>

function validateForm() {
    var cropname = document.forms["addcrop"]["cropname"].value;

    if (cropname == "") {
        alert("Crop Name must be filled out");
        return false;
    }
}

</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 