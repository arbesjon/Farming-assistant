<?php

    $idf = $_SESSION['farmerid'];

    $querycity = 'SELECT * FROM City';
    $selectcity = $conn->prepare($querycity);
    $selectcity->execute();

    $city = $selectcity->fetchAll();


    $querylanguage = 'SELECT * FROM Language';
    $selectlanguage = $conn->prepare($querylanguage);
    $selectlanguage->execute();

    $languages = $selectlanguage->fetchAll();

    if(isset($_POST['editprofile'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $pass = $_POST['password'];
        $phone = $_POST['phone'];
        $city = $_POST['cityid'];
        $language = $_POST['languageid'];

        $queryprofileupdate = 'UPDATE Farmers SET firstname = :firstname, lastname = :lastname, email = :email, 
        phone = :phone, cityid = :cityid, languageid = :languageid WHERE farmerid = :id';

        $updateprofile =  $conn->prepare($queryprofileupdate);
        $updateprofile->bindParam('firstname', $firstname);
        $updateprofile->bindParam('lastname', $lastname);  
        $updateprofile->bindParam('email', $email);
        $updateprofile->bindParam('phone', $phone);
        $updateprofile->bindParam('cityid', $city);
        $updateprofile->bindParam('languageid', $language);
        $updateprofile->bindParam('id', $idf);

        if ($pass != "") {
        	$queryprofileupdatepass = 'UPDATE Farmers SET password = :password WHERE farmerid = :id';
        	$updateprofilepass = $conn->prepare($queryprofileupdatepass);
        	$updateprofilepass->bindParam('password', $password);
        	$updateprofilepass->bindParam('id', $idf);
            $updateprofilepass->execute();

            $_SESSION['password'] = $password;
        }

        if($updateprofile->execute()) { 

            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['region'] = $city;
            $_SESSION['languageid'] = $language; ?>

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
  <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Edit Profile</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">First Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="firstname" placeholder="First Name" value="<?php echo $_SESSION['firstname']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Last Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="lastname" placeholder="Last Name" value="<?php echo  $_SESSION['lastname']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Email:</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Password:</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Phone:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="phone" placeholder="Phone" value="<?php echo $_SESSION['phone']; ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">City:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="cityid">
                    <?php
                        foreach($city as $c){ ?>
                        <option value="<?php echo $c['cityid']; ?>"
                        <?php if($_SESSION['region'] == $c['cityid']){?> selected <?php } ?>
                        ><?php echo $c['cityname']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Language:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="languageid">
                    <?php
                        foreach($languages as $lng){ ?>
                        <option value="<?php echo $lng['languageid']; ?>"
                        <?php if($_SESSION['languageid'] == $lng['languageid']){?> selected <?php } ?>
                        ><?php echo $lng['languagename']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            
            <div class="modal-footer">
                <button type="submit" name="editprofile" class="btn btn-success">Edit</button>
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