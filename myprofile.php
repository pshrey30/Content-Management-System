<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    Confirm_Login();
?>

<?php
// Fetching the existing admin
$AdminId = $_SESSION['UserId'];
global $connectingDB;
$sql = "SELECT * FROM admins where id=$AdminId";
$stmt = $connectingDB->query($sql);
while($DataRows=$stmt->fetch()){
    $ExisitngName = $DataRows['aname'];
    $ExisitngUsername = $DataRows['username'];
    $ExisitngHeadline = $DataRows['aheadline'];
    $ExisitngBio = $DataRows['abio'];
    $ExisitngImage = $DataRows['aimage'];
}
if(isset($_POST['submit'])){
    $Aname     = $_POST["name"];
    $AHeadline = $_POST["headline"];
    $ABio      = $_POST["bio"];
    $Image     = $_FILES["image"]["name"];
    $Target    = "images/".basename($_FILES["image"]["name"]); 

    if(strlen($AHeadline)>30){
        $_SESSION["ErrorMessage"] = "Headline should be less than 30 character";
        Redirect_to("myprofile.php");
    }elseif(strlen($ABio)>9999){
        $_SESSION["ErrorMessage"] = "Bio should be less than 500 characters";
        Redirect_to("myprofile.php");
    }else{

        //Query to update admin in db when everything is fine
        global $connectingDB;
        if (!empty($_FILES["image"]["name"])){
            $sql = "UPDATE admins
                    SET aname='$Aname', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                    WHERE id='$AdminId'";
        }elseif(!empty($ABio)) {
            $sql = "UPDATE admins
                    SET aname='$Aname', aheadline='$AHeadline', abio='$ABio'
                    WHERE id='$AdminId'";
        }elseif(!empty($AHeadline)){
            $sql = "UPDATE admins
                    SET aname='$Aname', aheadline='$AHeadline'
                    WHERE id='$AdminId'";
        }elseif(!empty($Aname)){
            $sql = "UPDATE admins
                    SET aname='$Aname'
                    WHERE id='$AdminId'";
        }else{
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("myprofile.php");
        }
        $execute = $connectingDB->query($sql);
        move_uploaded_file($_FILES["image"]["tmp_name"], $Target);

        if($execute){
            $_SESSION["SuccessMessage"]="Details Updated successfully";
            Redirect_to("myprofile.php");
        }else{   
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("myprofile.php");
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

    <title>My Profile</title>

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

            <h1><i class="fas fa-user mr-2" style="color: #27aae1;"></i><?php echo $ExisitngUsername; ?></h1>
            <small><?php echo $ExisitngHeadline; ?></small>
            </div>
        </div>
        </div>
    </div>
    </header>
    <!--HEADER END-->


    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <!--Left Area-->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo $ExisitngName; ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="images/<?php echo $ExisitngImage; ?>" class="block img-fluid mb-3" alt="">
                        <div class="">
                        <?php echo $ExisitngBio; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--Right Area-->
            <div class="col-md-9" style="min-height:419px;">
            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
                <form class="" action="myprofile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" id="title" placeholder="Your Name here" value="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="title" placeholder="Headline" name="headline" value="">
                                <small class="text-muted">Add a professional headline like, 'Engineer' at XYZ or 'Architect'</small>
                                <span class="text-danger">Not more than 30 characters</span>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Bio" class="form-control" name="bio" id="post" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="image" id="imageselect">
                                    <label for="imageselect" class="custom-file-label" aria-describedby="inputGroupFileAddon02">Select Image</label>
                                </div>
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