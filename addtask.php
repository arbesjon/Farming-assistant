<?php

    $id = $_SESSION['farmerid'];

    $queryfields = 'SELECT * FROM Fields WHERE farmerid = :id';
    $selectfields = $conn->prepare($queryfields);
    $selectfields->bindParam('id', $id);
    $selectfields->execute();

    $fields = $selectfields->fetchAll();


    $querycategory = 'SELECT * FROM Category';
    $selectcategory = $conn->prepare($querycategory);
    $selectcategory->execute();

    $category = $selectcategory->fetchAll();

    if(isset($_POST['addtask'])){
        $taskname = $_POST['taskname'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $description = $_POST['description'];
        $taskstatusid="1";
        $categoryid = $_POST['categoryid'];
        $fieldid = $_POST['fieldid'];
        if($fieldid == ""){
            $fieldid = NULL;
        }
        $farmerid = $id;

        if($taskname == ""){
            $message = "Task Name must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($startdate == null) {
            $message = "Start Date must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($enddate == null) {
            $message = "End Date must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else if($description == "") {
            $message = "Description must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $querytaskadd = 'INSERT INTO Tasks (taskname, startdate, enddate, description, taskstatusid, categoryid, fieldid, farmerid) 
        VALUES (:taskname, :startdate, :enddate, :description, :taskstatusid, :categoryid, :fieldid, :farmerid)';

        $selecttask =  $conn->prepare($querytaskadd);
        $selecttask->bindParam('taskname', $taskname);
        $selecttask->bindParam('startdate', $startdate);  
        $selecttask->bindParam('enddate', $enddate);
        $selecttask->bindParam('description', $description);
        $selecttask->bindParam('taskstatusid', $taskstatusid);
        $selecttask->bindParam('categoryid', $categoryid);
        $selecttask->bindParam('fieldid', $fieldid);
        $selecttask->bindParam('farmerid', $farmerid);

        if($selecttask->execute()) { ?>
        <script> alert("Successfully added your task!")
                window.location = 'tasks'</script>
            <?php
                header("Location: tasks");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while creating your task") </script>
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
        <a class="font-weight-light" id="title">Add Task</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post" name="addtask" onsubmit="return validateForm();">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Task Name:</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="taskname" placeholder="Name">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Start Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="startdate" placeholder="Date">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">End Date:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="enddate" placeholder="Date">
            </div>
            <div class="form-group">
                <label id="formtext" for="exampleFormControlTextarea1" class="font-weight-bold">Description:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description"></textarea>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Category:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="categoryid">
                    <?php
                        foreach($category as $cat){ ?>
                        <option value="<?php echo $cat['categoryid']; ?>"><?php echo $cat['categoryname']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Field:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="fieldid">
                    <option value="">-</option>
                    <?php
                        foreach($fields as $field){ ?>
                        <option value="<?php echo $field['fieldid']; ?>"><?php echo $field['fieldname']; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addtask" class="btn btn-success">Add</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </form>

        </div>
      </div>
      
    </div>
  </div>

  <script>

function validateForm() {
    var taskname = document.forms["addtask"]["taskname"].value;
    var startdate = document.forms["addtask"]["startdate"].value;
    var enddate = document.forms["addtask"]["enddate"].value;
    var description = document.forms["addtask"]["description"].value;

    if (taskname == "") {
        alert("Task Name must be filled out");
        return false;
    }
    if (startdate == "") {
        alert("Start Date must be filled out");
        return false;
    }
    if (enddate == "") {
        alert("End Date must be filled out");
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