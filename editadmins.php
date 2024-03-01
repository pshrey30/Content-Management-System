<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
    Confirm_Login();
?>

<?php
$SearchQueryParameter = $_GET["id"];
if(isset($_POST['submit'])){
    $UserName = $_POST["username"];
    $Admin    = $_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if(empty($UserName)){
        $_SESSION["ErrorMessage"] = "No Update was Made";
        Redirect_to("admins.php");
    }else{
        // Query to update the existing admin in db
        global $connectingDB;
        if(isset($_POST['username'])){
        $sql = "UPDATE admins
                SET username ='$UserName'
                WHERE id='$SearchQueryParameter'";
        }
        $execute = $connectingDB->query($sql);

        if($execute){
            $_SESSION["SuccessMessage"]="Username was Updated successfully";
            Redirect_to("admins.php");
        }else{
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("admins.php");
        }


    }
}          //Ending of Sumit button if-condition
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

    <title>Edit Admin</title>

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
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="myprofile.php" class="nav-link">My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="blog.php?page=1" class="nav-link" target="_blank">Live Blog </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link"><i class="fa-solid fa-right-from-bracket text-danger"></i> Logout</a>
                </li>
            </ul>
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
            <h1><i class="fas fa-edit" style="color: #27aae1;"></i> Edit Username</h1>
            </div>
        </div>
        </div>
    </div>
    </header>
    <!--HEADER END-->


    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:419px;">
            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
            <?php
                //fetching the existing content
                global $connectingDB;
                $sql = "SELECT * FROM admins WHERE id='$SearchQueryParameter'";
                $stmt = $connectingDB->query($sql);
                while($DataRows=$stmt->fetch()){
                    $AdminToBeUpdated = $DataRows['username'];
                }
            ?>
            
                <form class="" action="editadmins.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo"> Username: </span></label>
                                <input class="form-control" type="text" name="username" id="username" value="<?php echo $AdminToBeUpdated; ?>">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type = "submit" name="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <!--Main Area END-->


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