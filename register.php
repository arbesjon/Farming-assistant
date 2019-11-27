<?php
    require 'inc/conn.php';
    session_start();

    date_default_timezone_set('Europe/Skopje');

    if(isset($_POST['signup'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $phone = $_POST['phone'];
        $cityid = $_POST['cityid'];
        $languageid = $_POST['languageid'];
        $roleid = "2";
        $registerdate = date('Y-m-d');

        $queryusername = 'SELECT * FROM Farmers WHERE username = :username';
        $selectusername =  $conn->prepare($queryusername);
        $selectusername->bindParam('username', $username);
        $selectusername->execute();
        if($selectusername->rowCount() > 0){
            $message = "Username exist";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

        $query = 'INSERT INTO Farmers (firstname, lastname, username, email, password, phone, registerdate, cityid, roleid, languageid) 
        VALUES (:firstname, :lastname, :username, :email, :password, :phone, :registerdate, :cityid, :roleid, :languageid)';

        $select =  $conn->prepare($query);
        $select->bindParam('firstname', $firstname);
        $select->bindParam('lastname', $lastname);  
        $select->bindParam('username', $username);
        $select->bindParam('email', $email);
        $select->bindParam('password', $password);
        $select->bindParam('phone', $phone);
        $select->bindParam('registerdate', $registerdate);
        $select->bindParam('cityid', $cityid);
        $select->bindParam('roleid', $roleid);
        $select->bindParam('languageid', $languageid);

        if($select->execute()) { ?>
        <script> alert("Successfully created your account!")
                window.location = 'login'</script>
            <?php
                header("Location: login");
                exit;
            ?>
        <?php } else { ?>
            <script> alert("A problem occurred creating your account") </script>
        <?php }
        }
    }

    $querycity = 'SELECT * FROM City';
    $selectcity = $conn->prepare($querycity);
    $selectcity->execute();

    $citys = $selectcity->fetchAll();

    $querylanguage = 'SELECT * FROM Language';
    $selectlanguage = $conn->prepare($querylanguage);
    $selectlanguage->execute();

    $languages = $selectlanguage->fetchAll();
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
                    <h1>Welcome</h1>
                        <form role="form" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="firstname" class="sr-only">FirstName</label>
                                <input type="text" name="firstname" id="email" class="form-control" placeholder="FirstName">
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="sr-only">LastName</label>
                                <input type="text" name="lastname" id="email" class="form-control" placeholder="LastName">
                            </div>
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="email" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>
                            <div class="checkbox">
                                <span class="character-checkbox" onclick="showPassword()"></span>
                                <span class="label">Show password</span>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="sr-only">Phone</label>
                                <input type="text" name="phone" id="email" class="form-control" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label for="cityid" class="sr-only">Region</label>
                                <select id="email" class="form-control" name="cityid">
                                    <?php
                                        foreach($citys as $city){ ?>
                                        <option value="<?php echo $city['cityid']; ?>"><?php echo $city['cityname']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="languageid" class="sr-only">Language</label>
                                <select id="email" class="form-control" name="languageid">
                                    <?php
                                        foreach($languages as $language){ ?>
                                        <option value="<?php echo $language['languageid']; ?>"><?php echo $language['languagename']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="submit" name="signup" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Sign up">
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="container" id="footerr">
                <div class="row">
                    <div class="col-xs-12">
                        <p>Have an account?</p>
                        <p>Login <strong><a href="login" > here</a></strong></p>
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