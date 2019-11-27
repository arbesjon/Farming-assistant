<?php
    require 'inc/conn.php';
    session_start();

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password =$_POST['password'];

        $query = 'SELECT * FROM Farmers WHERE username = :username AND roleid = 2';

        $select =  $conn->prepare($query);
        $select->bindParam('username', $username);
        $select->execute();

        $user = $select->fetch();

        if(count($user) > 0 && password_verify($password, $user['password'])) { 
            
            $_SESSION['farmerid'] = $user['farmerid'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['region'] = $user['cityid'];
            $_SESSION['roleid'] = $user['roleid'];
            $_SESSION['registerdate'] = $user['registerdate'];
            $_SESSION['languageid'] = $user['languageid'];
            
            header("Location: plants");
            exit;
            ?>

            <script> alert("Successfully Signed in!") </script>

        <?php } else { ?>
            <script> alert("Sorry, those credentials do not match") </script>
        <?php }
    }
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content=""> 

    <title>Welcome to Farming Assistant</title>

    <!-- Custom styles for this template -->
    <link href="css/creative.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/registercss.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/showpw.js"></script>

    </head>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-wrap">
                    <h1>Log In</h1>
                        <form role="form" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="email" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>
                            <div class="checkbox">
                                <span class="character-checkbox" onclick="showPassword()"></span>
                                <span class="label">Show password</span>
                            </div>
                            <input type="submit" name="login" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log In">
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="container" id="footerr">
                <div class="row">
                    <div class="col-xs-12">
                        <p>Don't have an account?</p>
                        <p>Register <strong><a href="register" > here</a></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/creative.min.js"></script>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p>© - 2018</p>
                    <p>Powered by <strong><a href="index" >Farming Assistant</a></strong></p>
                </div>
            </div>
        </div>
    </footer>

</html>