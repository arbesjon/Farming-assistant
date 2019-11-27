<?php

    if (isset($_GET['farmer'])) {
        $id = $_GET['farmer'];
    }

    if (isset($_GET['id'])) {
        $idshop = $_GET['id'];
    }

    date_default_timezone_set('Europe/Skopje');

    $idf = $_SESSION['farmerid'];

    $queryfarmer = 'SELECT * FROM Farmers WHERE farmerid = :id';
    $selectfarmer =  $conn->prepare($queryfarmer);
    $selectfarmer->bindParam('id', $id);
    $selectfarmer->execute();

    $farmer = $selectfarmer->fetch();   
    
    if(isset($_POST['sendmessage'])){

        $text = $_POST['message'];
        $msgreadid = "2";
        $msgsent = date('Y-m-d');

        $querymessage = 'INSERT INTO Messages (text, msgsent, senderid, receiverid, msgreadid, shopid) 
        VALUES (:text, :msgsent, :senderid, :receiverid, :msgreadid, :shopid)';

        $selectmsg =  $conn->prepare($querymessage);
        $selectmsg->bindParam('text', $text);
        $selectmsg->bindParam('msgsent', $msgsent);  
        $selectmsg->bindParam('senderid', $idf);
        $selectmsg->bindParam('receiverid', $id);
        $selectmsg->bindParam('msgreadid', $msgreadid);
        $selectmsg->bindParam('shopid', $idshop);

        if($selectmsg->execute()) { ?>
        <script> 
            alert("Message successfully sent!")
                window.location = 'shopdetails?id=<?php echo $idshop; ?>'</script>
            <?php
                header("Location: shop");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred while sending your message!") </script>
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
  <div class="modal fade" id="myModalMsg" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a class="font-weight-light" id="title">Send Message</a>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        <form method="post">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">To:</label>
                <a><?php echo $farmer['username']; ?> </a>
            </div>
            <div class="form-group">
                <label id="formtext" for="exampleFormControlTextarea1" class="font-weight-bold">Message:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message" placeholder="Message"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" name="sendmessage" class="btn btn-success">Send</button>
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