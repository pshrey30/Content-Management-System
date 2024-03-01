<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>

<?php
if(isset($_SESSION["UserId"])){
    Redirect_to("dashboard.php");
}

if(isset($_POST['submit'])){
    $UserName = $_POST["username"];
    $Password = $_POST["password"];
    //$hash_password = password_hash($Password, PASSWORD_DEFAULT);

    if(empty($UserName)||empty($Password)){
        $_SESSION["ErrorMessage"] = "All the fields must be filled out";
        Redirect_to("login.php");
    }else{
        // Code for checking username and password from database
        $Found_Account = Login_Attempt($UserName,$Password); //
        if($Found_Account){
            $_SESSION["UserId"] = $Found_Account["id"];
            $_SESSION["UserName"] = $Found_Account["username"];
            $_SESSION["AdminName"] = $Found_Account["aname"];
            $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["UserName"]."!";
            if(isset($_SESSION["TrackingURL"])){
                Redirect_to($_SESSION["TrackingURL"]);
            }else{
                Redirect_to("dashboard.php");
            }
            
        }
        else{
           $_SESSION["ErrorMessage"] = "Incorrect Username/Password";
            Redirect_to("login.php");
        }
    }

}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Font Awesome CDN-->
    <link rel="stylesheet" href="https://kit.fontawesome.com/d71f73df39.css" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Login Page</title>

  </head>
  <body>
        <!--NavBar-->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand" style="font-family: 'Poller One', cursive;">Blogify</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsecms">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapsecms">
            </div>
        </div>
        
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!--Navbar END-->

    <!--HEADER-->
    <header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        </div>
    </div>
    </header>
    <!--HEADER END-->

    <!--Main Area Starts-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:475px;">
            <br><br><br>
            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Admin Panel</h4>
                        </div>
                        <div class="card-body bg-dark">
                        
                        <form class="" action="login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">UserName:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="FieldInfo">Password:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--Main Area Ends-->
    <!--FOOTER-->
    <footer class="bg-dark text-white">
        <div class="container mt-3">
            <div class="row">
            <div class="col">
                <p class="lead text-center my-2">Theme by Shrey Patel || &copy; <span id="year"></span> ---All Rights Reserved.</p>
                <p class="text-center small"><a style="color:white; text-decoration:none; cursor:pointer;"  href=""></a>This website is only for study purpose.</p>
            </div>
            </div>
        </div>
    </footer>
    <div style="height:10px; background:#27aae1;"></div>
    <!--FOOTER END-->


    <!--Font Awesome CDN-->
    <script src="https://kit.fontawesome.com/d71f73df39.js" crossorigin="anonymous"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
  </body>
</html>