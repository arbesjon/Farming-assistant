<?php

    $id = $_SESSION['farmerid'];

    if(isset($_POST['addcategory'])){

        $categoryname = $_POST['categoryname'];

        if($categoryname == ""){
            $message = "Category Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $querycategoryadd = 'INSERT INTO Category (categoryname) 
        VALUES (:categoryname)';

        $insertcategory =  $conn->prepare($querycategoryadd);
        $insertcategory->bindParam('categoryname', $categoryname);

        if($insertcategory->execute()) { ?>
        <script> alert("Successfully added your category!")
                window.location = 'cpanel'</script>
            <?php
                header("Location: cpanel");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your category") </script>
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
  <div class="modal fade" id="myModalCategory" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Add Category</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" enctype="multipart/form-data" name="addcategory" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Category Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="categoryname" placeholder="Category Name">
            </div>
            
            <div class="modal-footer">
                <button type="submit" name="addcategory" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

   <script>

function validateForm() {
    var categoryname = document.forms["addcategory"]["categoryname"].value;

    if (categoryname == "") {
        alert("Category Name must be filled out");
        return false;
    }
}

</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 