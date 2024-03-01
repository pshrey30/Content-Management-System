<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php 
$searchqueryparamter = $_GET["id"];
?>
<?php

if(isset($_POST['submit'])){
    $Name    = $_POST["commentername"];
    $Email   = $_POST["commenteremail"];
    $Comment = $_POST["commenterthoughts"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"] = "All the fields must be filled out";
        Redirect_to("fullpost.php?id=$searchqueryparamter");
    }elseif(strlen($Comment)>999){
        $_SESSION["ErrorMessage"] = "Comment length must be less than 1000 characters";
        Redirect_to("fullpost.php?id=$searchqueryparamter");
    }else{
        // Query to insert comment in db when everything is fine
        global $connectingDB;
        $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql.="VALUES(:datetime,:name,:email,:comment,'pending','OFF',:postIdFromURL)";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':datetime',$DateTime);
        $stmt->bindValue(':name',$Name);
        $stmt->bindValue(':email',$Email);
        $stmt->bindValue(':comment',$Comment);
        $stmt->bindValue(':postIdFromURL',$searchqueryparamter);
        
        $execute=$stmt->execute();

        if($execute){
            $_SESSION["SuccessMessage"]="Comment was sent successfully";
            Redirect_to("fullpost.php?id=$searchqueryparamter");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("fullpost.php?id=$searchqueryparamter");
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

    <title>Full Post Page</title>

  </head>
  <body>
    <!--NavBar-->
<!--<div style="height:10px; background:#27aae1;"></div>-->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:black;">
    <div class="container mt-1">
        <a href="#" class="navbar-brand" style="font-family: 'Poller One', cursive;">Blogify</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsecms">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapsecms">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
                <a href="blog.php?page=1" class="nav-link">Home</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Categories
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                global $connectingDB;
                    $sql = "SELECT * FROM category ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                    while($DataRows = $stmt->fetch()){
                        $CategoryId    = $DataRows["id"];
                        $CategoryName  = $DataRows["title"];
                    ?>
                    <a class="dropdown-item" href="blog.php?category=<?php echo $CategoryName; ?>"><?php echo $CategoryName; ?></a>
                <?php }?>
            </li>
            <li class="nav-item">
                <a href="aboutus.php" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
                <a href="contactus.php" class="nav-link" target="_blank">Contact Us</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <form class="form-inline d-none d-sm-block" action="blog.php">
                <div class="form-group ">
                <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
                <button class="btn btn-primary" name="SearchButton">Go</button>
                </div>
            </form>
        </ul>
        </div>
    </div>
    
</nav>
    <!--Navbar END-->

    <!--HEADER-->
    <div class="container">
        <div class="row mt-4">

            <!--Main Area Starts-->
            <div class="col-sm-8">
                <h1>The complete responsive Blog CMS</h1>
                <h1 class="lead">By Shrey Patel</h1>
                <?php 
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <?php
                global $connectingDB;
                //SQL query when search button is active
                if(isset($_GET["SearchButton"])){
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM posts
                    WHERE datetime LIKE :search
                    OR title LIKE :search
                    OR category LIKE :search
                    OR post LIKE :search";
                    $stmt = $connectingDB->prepare($sql);
                    $stmt->bindValue(':search','%'.$Search.'%');
                    $stmt->execute();
                }
                //The default SQL query
                else{
                    $PostIdfromURL = $_GET['id'];
                    if(!isset($PostIdfromURL)){
                        $_SESSION["ErrorMessage"]="Bad Request!";
                        Redirect_to("blog.php?Page=1");
                    }
                    $sql  = "SELECT * FROM posts WHERE id='$PostIdfromURL'";
                    $stmt = $connectingDB->query($sql);
                    $Result = $stmt->rowcount();
                    if($Result!=1){
                        $_SESSION["ErrorMessage"]="Bad Request!";
                        Redirect_to("blog.php?Page=1");
                    }
                }
                while($DataRows = $stmt->fetch()){
                    $PostId           = $DataRows["id"];
                    $DateTime         = $DataRows["datetime"];
                    $PostTitle        = $DataRows["title"];
                    $Category         = $DataRows["category"];
                    $Admin            = $DataRows["author"];
                    $Image            = $DataRows["image"];
                    $PostDescription  = $DataRows["post"]; 
                ?>
                <div class="card mb-3">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                    <small class="text-muted"><span class="text-dark">Category: <a href="blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> Written by <span class="text-dark"><a href="profile.php?username=<?php echo htmlentities($Admin); ?>" target="_blank"><?php echo htmlentities($Admin); ?></a></span> on <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                    <span style="float:right;" class="badge badge-dark text-light">
                        Comments: <?php echo ApproveCommentsAccordingToPost($PostId);?>
                    </span>
                    <hr>
                    <p class="card-text">
                        <?php
                            echo nl2br($PostDescription); 
                        ?>
                    </p>

                </div>
                </div>
            <?php } ?>

            <!--Comment Area Starts-->
            <!--Fetchig the existing comment START-->
            <span class="FieldInfo">Comments</span>
            <?php
            global $connectingDB;
            $sql = "SELECT * FROM comments WHERE post_id='$searchqueryparamter' AND status='ON'";
            $stmt = $connectingDB->query($sql);
            while($DataRows = $stmt->fetch()){
                $CommentDate      = $DataRows['datetime'];
                $CommenterName    = $DataRows['name'];
                $CommenterContent = $DataRows['comment'];
            
                    
            ?>
            <div>
                
                <div class="media">
                    <img class="d-block img-fluid align-self-start" src="images/comment.png" style="max-width: 70px;" >
                    <div class="media-body ml-2">
                        <h6 class="lead"><?php  echo $CommenterName; ?></h6>
                        <p class="small"><?php  echo $CommentDate; ?></p>
                        <p><?php  echo $CommenterContent; ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <?php } ?>
            <!--Fetching the existing comment END-->
            <div class="">
                <form class="" action="fullpost.php?id=<?php echo $searchqueryparamter; ?>" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="FieldInfo">Share your thoughts about this post</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>   
                            <input class="form-control" type="text" name="commentername" placeholder="Name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>   
                            <input class="form-control" type="email" name="commenteremail" placeholder="Email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="commenterthoughts" class="form-control" id="" cols="80" rows="8"></textarea>
                        </div>
                        <div class="">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <!--Comment Area Ends-->
            </div>
            <!--Main Area Ends-->
            <!--Sidebar Area Starts-->
            <div class="col-sm-4">
    <div class="card mt-4">
        <div class="card-body">
            <img src="images/50sale.jpg" class="d-block img-fluid mb-3" alt="">
            <div class="text-left">
            Don't miss out on our incredible shoe sale! For a limited time only, we're offering a huge 50% discount on all shoes in-store and online. From stylish sneakers to elegant dress shoes, we've got everything you need to step up your footwear game.
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h2 class="lead">Sign Up!</h2>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="button">Join the Forum!</button>
            <button type="button" class="btn btn-danger btn-block text-center text-white mb-3" name="button">Login</button>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="" placeholder="Enter Your Email" value="">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now!</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-primary text-light">
            <h2 class="lead">Categories</h2>
            </div>
            <div class="card-body">
                <?php 
                global $connectingDB;
                $sql = "SELECT * FROM category ORDER BY id desc";
                $stmt = $connectingDB->query($sql);
                while($DataRows = $stmt->fetch()){
                    $CategoryId   = $DataRows["id"];
                    $CategoryName = $DataRows["title"];
                ?>
                <a href="blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
            <?php }?>    
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h2 class="lead">Recent Post</h2>
        </div>
        <div class="card-body">
            <?php
            global $connectingDB;
            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
            $stmt = $connectingDB->query($sql);
            while($DataRows=$stmt->fetch()){
                $Id        = $DataRows["id"];
                $PostTitle = $DataRows["title"];
                $DateTime  = $DataRows["datetime"];
                $Image     = $DataRows["image"];                      
            ?>
            <div class="media">
                <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                <div class="media-body ml-2">
                    <a href="fullpost.php?id=<?php echo htmlentities($Id); ?>"><h6 class="lead"><?php echo htmlentities($PostTitle); ?></h6></a>
                    <p class="small"><?php echo htmlentities($DateTime); ?></p>
                </div>
            </div>
            <?php }  ?>
        </div>
    </div>
</div>
<!--Sidebar Area Ends-->
        </div>
    </div>

    <!--HEADER END-->

    <!--FOOTER-->
    <?php require_once("includes/footer.php"); ?>
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