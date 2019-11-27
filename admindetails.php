<?php 
require 'addcrop.php';
require 'addcity.php';
require 'addcategory.php';

    $idf = $_SESSION['farmerid'];

    $query = 'SELECT * FROM Crops INNER JOIN Cropcategory on Cropcategory.cropcategoryid = Crops.cropcategoryid';
    $select =  $conn->prepare($query);
    $select->execute();
    $result = $select->fetchAll();

    $query1 = 'SELECT * FROM City';
    $select1 =  $conn->prepare($query1);
    $select1->execute();
    $result1 = $select1->fetchAll();

    $query2 = 'SELECT * FROM Category';
    $select2 =  $conn->prepare($query2);
    $select2->execute();
    $result2 = $select2->fetchAll();

?>
<br>
<br>
<div class="container">


    <a href="#crop"><button type="button" class="btn btn-info" id="addPlant">Crops</button></a>
    <a href="#city"><button type="button" class="btn btn-info" id="addPlant">City</button></a>
    <a href="#category"><button type="button" class="btn btn-info" id="addPlant">Category</button></a>

<br>
<br>
<br>
<span>
    <a class="font-weight-light" id="title">Crops</a>
    <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModal">+ Crop</button>
</span>
<div id="crop"></div>
<table class="table">
        <thead class="table-secondary">
            <tr id="table">
            <th scope="col"></th>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($select->rowCount() == 0){ ?>
                <tr id="table">
                <th scope="row"></th>
                    <td></td>
                    <td>No Crops</td>
                </tr>
            <?php }
                foreach($result as $crop){?>
                    <tr id="table">
                    <th scope="row"></th>
                    <td><img class"image" src="img/icons/<?php echo $crop['image'] ?>"</td>
                    <td><?php echo $crop['cropname']; ?></td>
                    <td><?php echo $crop['cropcategoryname']; ?></td>
                    <td>
                    <a href="deletecrop?id=<?php echo $crop['cropid']; ?>" onclick="return confirm('Are you sure?')">
                    <button type="button" class="btn btn-danger">Delete</button></a>
                    </td>
                    </tr>
                    <?php 
                } ?>
        </tbody>
    </table>

    <br>
<span>
    <a class="font-weight-light" id="title">City</a>
    <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModalCity">+ City</button>
</span>
<div id="city"></div>
<table class="table">
        <thead class="table-secondary">
            <tr id="table">
            <th scope="col"></th>
            <th scope="col">Name</th>
            <th scope="col">Weather ID</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($select->rowCount() == 0){ ?>
                <tr id="table">
                <th scope="row"></th>
                    <td></td>
                    <td>No City</td>
                </tr>
            <?php }
                foreach($result1 as $city){?>
                    <tr id="table">
                    <th scope="row"></th>
                    <td><?php echo $city['cityname']; ?></td>
                    <td><?php echo $city['weatherid']; ?></td>
                    <td>
                    <a href="deletecity?id=<?php echo $city['cityid']; ?>" onclick="return confirm('Are you sure?')">
                    <button type="button" class="btn btn-danger">Delete</button></a>
                    </td>
                    </tr>
                    <?php 
                } ?>
        </tbody>
    </table>

<br>
<span>
    <a class="font-weight-light" id="title">Category</a>
    <button type="button" class="btn btn-success" id="addPlant" data-toggle="modal" data-target="#myModalCategory">+ Category</button>
</span>
<div id="category"></div>
    <table class="table">
        <thead class="table-secondary">
            <tr id="table">
            <th scope="col"></th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($select->rowCount() == 0){ ?>
                <tr id="table">
                <th scope="row"></th>
                    <td></td>
                    <td>No City</td>
                </tr>
            <?php }
                foreach($result2 as $category){?>
                    <tr id="table">
                    <th scope="row"></th>
                    <td><?php echo $category['categoryname']; ?></td>
                    <td>
                    <a href="deletecategory?id=<?php echo $category['categoryid']; ?>" onclick="return confirm('Are you sure?')">
                    <button type="button" class="btn btn-danger">Delete</button></a>
                    </td>
                    </tr>
                    <?php 
                } ?>
        </tbody>
    </table>
    

</div>