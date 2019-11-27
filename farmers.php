<?php
    $farmersq = 'SELECT * from Farmers ORDER BY roleid';
    $selectfarmers =  $conn->prepare($farmersq);
    $selectfarmers->execute();
    $farmers = $selectfarmers->fetchAll();
?>

<br>
<br>
    <div class="row">
        <?php foreach($farmers as $farmer){ ?>
                <div class="card text-center" style="width: 16rem;">
                    <div class="d-flex justify-content-end">
                    <?php if($farmer['roleid'] == 1){?>
                        <a id="pdate" class="font-weight-light">Admin</a>
                    <?php } else {?>
                        <a id="pdate" class="font-weight-light">Farmer</a>
                    <?php } ?>
                    </div>
                    <div class="card-body">
                        <h5 id="formtext" class="card-title"><?php echo $farmer['firstname'] . " " . $farmer['lastname'];?></h5>
                        <p class="card-text"><strong><?php echo $farmer['username'];?></strong></p>
                        <?php if($farmer['roleid'] == 1){?>
                            <a href="deleteadmin?id=<?php echo $farmer['farmerid']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger">delete from admin</a>
                        <?php } else {?>
                            <a href="deletefarmer?id=<?php echo $farmer['farmerid']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger">delete</a>
                            <a href="addadmin?id=<?php echo $farmer['farmerid']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-info">Add Admin</a>
                        <?php } ?>
                    </div>
                </div>
            <?php
            } ?>
    </div>