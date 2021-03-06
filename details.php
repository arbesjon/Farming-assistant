<?php

    $idf = $_SESSION['farmerid'];

    $querydetail = 'SELECT * FROM Details WHERE farmerid = :id';
    $selectdetail = $conn->prepare($querydetail);
    $selectdetail->bindParam('id', $idf);
    $selectdetail->execute();

    $detail = $selectdetail->fetch();

    if(isset($_POST['editdetail'])){
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];

        if($selectdetail->rowCount() > 0){
            $querydetails = 'UPDATE Details SET gender = :gender, birthday = :birthday
             WHERE farmerid = :id';
        } else {
            $querydetails = 'INSERT INTO Details (farmerid, gender, birthday) 
            VALUES (:id, :gender, :birthday)';
        }

        $updatedetails =  $conn->prepare($querydetails);
        $updatedetails->bindParam('gender', $gender);
        $updatedetails->bindParam('birthday', $birthday); 
        $updatedetails->bindParam('id', $idf);

        if($updatedetails->execute()) { ?>
        <script> alert("Successfully updated your profile!")
                window.location = 'profile'</script>
            <?php
                header("Location: profile");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while updating your profile") </script>
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
  <div class="modal fade" id="myModalDetails" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Details</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Gender:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="gender">
                    <option value="M"<?php if($detail['gender'] == 'M'){?> selected <?php }?>>Male</option>
                    <option value="F"<?php if($detail['gender'] == 'F'){?> selected <?php }?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Birthday:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="birthday" placeholder="Birthday" value="<?php echo $detail['birthday']; ?>">
            </div>
            
            <div class="modal-footer">
                <button type="submit" name="editdetail" class="btn btn-success">Edit</button>
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