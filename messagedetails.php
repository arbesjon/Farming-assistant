<?php 
    require 'nav.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    if (isset($_GET['shop'])) {
        $shopid = $_GET['shop'];
    }

    $idf = $_SESSION['farmerid'];

    date_default_timezone_set('Europe/Skopje');

    $querymessage = 'SELECT * FROM Messages
     INNER JOIN Farmers ON Farmers.farmerid = Messages.senderid
     WHERE Messages.messageid = :id';

    $selectmessage =  $conn->prepare($querymessage);
    $selectmessage->bindParam('id', $id);
    $selectmessage->execute();
    $message = $selectmessage->fetch();

    $msgread = "1";
    $queryread = "UPDATE Messages SET msgreadid = :msgreadid WHERE shopid = :id AND senderid = :sid AND receiverid = :rid";
    $query = $conn->prepare($queryread);
    $query->bindParam('id', $shopid);
    $query->bindParam('sid', $message['senderid']);
    $query->bindParam('rid', $idf);
    $query->bindParam('msgreadid', $msgread);
    $query->execute();

    $querymessages = 'SELECT * FROM Messages
     INNER JOIN Farmers ON Farmers.farmerid = Messages.senderid
     WHERE Messages.shopid = :idd AND (Messages.receiverid = :rid AND Messages.senderid = :sid 
     OR Messages.receiverid = :sid AND Messages.senderid = :rid) ORDER BY messageid';

    $selectmessages =  $conn->prepare($querymessages);
    $selectmessages->bindParam('idd', $shopid);
    $selectmessages->bindParam('rid', $idf);
    $selectmessages->bindParam('sid', $message['senderid']);
    $selectmessages->execute();
    $messages = $selectmessages->fetchAll();

    if(isset($_POST['replaymessage'])){

        $text = $_POST['replay'];
        $msgreadid = "2";
        $msgsent = date('Y-m-d');

        if($text == ""){
            $message = "Message must be filled out";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

            $querymessage = 'INSERT INTO Messages (text, msgsent, senderid, receiverid, msgreadid, shopid) 
            VALUES (:text, :msgsent, :senderid, :receiverid, :msgreadid, :shopid)';

            $selectmsg =  $conn->prepare($querymessage);
            $selectmsg->bindParam('text', $text);
            $selectmsg->bindParam('msgsent', $msgsent);  
            $selectmsg->bindParam('senderid', $idf);
            $selectmsg->bindParam('receiverid', $message['senderid']);
            $selectmsg->bindParam('msgreadid', $msgreadid);
            $selectmsg->bindParam('shopid', $message['shopid']);

            if($selectmsg->execute()) { ?>
            <script>
                    window.location = 'messagedetails?id=<?php echo $id; ?>&shop=<?php echo $shopid; ?>'</script>
                <?php
                    header("Location: messagedetails?id=<?php echo $id; ?>");
                    exit;
                ?>
            <?php } else { ?>
                <script> alert("A problem occurred while sending your message!") </script>
            <?php }
        }
    }

    

?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
    <link href="css/shopcss.css" rel="stylesheet">
    <script src="js/plants.js"></script>

    <title> </title>
  </head>
  <body>
    <div id="top"></div>
    <br>
    <br>
    <br>
    <div class="container">

    <div class="card text-center">
        <div class="card-header">
            <a href="shopdetails?id=<?php echo $message['shopid']; ?>" class="btn btn-primary">Go to shop</a>
        </div>
        <div class="card-body">
        <div style="overflow-y: auto; height:450px; ">
            <?php foreach($messages as $msg){ ?>
                <div class="mx-auto" style="width: 18rem;">
                <div class="card bg-light mb-3" style="max-width: 30rem;">
                    <div id="formtext" class="card-header"><strong><?php echo $msg['username']; ?></strong></div>
                    <div class="card-body">
                        <p class="card-text"><?php echo nl2br($msg['text']); ?></p>
                    </div>
                </div>
                </div>
            <?php } ?>
            <div id="bottom"></div>
            </div>

            <form method="post">
                <div class="form-group">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="replay" placeholder="Replay"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="replaymessage" class="btn btn-success">Send</button>
                </div>
            </form>

        </div>
        <div class="card-footer text-muted">
            <?php echo $message['msgsent']; ?>
        </div>
    </div>

    <div><a id="bottomr" href="#bottom"</a><a id="topr" href="#top"</a>
        <script>
            document.getElementById("bottomr").click();
            document.getElementById("topr").click();
        </script>
    </div>
        
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>


<?php 
    require 'foot.php';
?>