<?php 
    require 'nav.php';
    require 'addfield.php';
    require 'editfield.php';

    $id = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Fields INNER JOIN Dimension on Dimension.dimensionid = Fields.dimensionid WHERE Fields.farmerid = :id';

    $select =  $conn->prepare($query);
    $select->bindParam('id', $id);
    $select->execute();

    $result = $select->fetchAll();
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
    <script src="js/plants.js"></script>

    <title> </title>
  </head>
  <body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
    <span>
        <a class="font-weight-light" id="title">Fields</a>
        <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModalAdd">+ Field</button>
    </span>

    <table class="table">
        <thead class="table-secondary">
            <tr id="table">
            <th scope="col"></th>
            <th scope="col">Name</th>
            <th scope="col">Surface</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($select->rowCount() == 0){ ?>
                <tr id="table">
                <th scope="row"></th>
                    <td></td>
                    <td>No fields</td>
                </tr>
            <?php }
                foreach($result as $field){?>
                    <tr id="table">
                    <th scope="row"></th>
                    <td><?php echo $field['fieldname'] ?></td>
                    <td><?php echo $field['surface'] . $field['dimensionname']; ?></td>
                    <td>
                    <a href="?id=<?php echo $field['fieldid']; ?>">
                    <button type="button" class="btn btn-info" id="edit">Edit</button></a>
                    <a href="deletefield?id=<?php echo $field['fieldid']; ?>" onclick="return confirm('Are you sure?')">
                    <button type="button" class="btn btn-danger">Delete</button></a>
                    <button type="button" id="mm" data-toggle="modal" data-target="#myModalEdit"></button>
                    </td>
                    </tr>
                    <?php 
                    if (isset($_GET['id']) && $_GET['id'] == $field['fieldid'] && $field['farmerid'] == $_SESSION['farmerid']) { ?>
                        <script>
                        document.getElementById("mm").click();
                        </script>
                    <?php }
                } ?>
        </tbody>
    </table>


    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>

<?php 
    require 'foot.php';
?>