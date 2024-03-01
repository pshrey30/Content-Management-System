<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
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

    <title>Blog Page</title>
    <style media="screen">
    .heading{
    font-family:'Times New Roman', Times, serif;
    font-weight: bold;
    color: #005e90;
    }
    .headng:hover{
    color: #0090db;
    }
    .custom-btn {
    width: 130px;
    height: 40px;
    color: #fff;
    border-radius: 5px;
    padding: 10px 25px;
    font-family: 'Lato', sans-serif;
    font-weight: 500;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    display: inline-block;
    box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
    7px 7px 20px 0px rgba(0,0,0,.1),
    4px 4px 5px 0px rgba(0,0,0,.1);
    outline: none;
    }
    .btn-3 {
    background: rgb(0,172,238);
    background: linear-gradient(0deg, rgba(0,172,238,1) 0%, rgba(2,126,251,1) 100%);
    width: 130px;
    height: 40px;
    line-height: 42px;
    padding: 0;
    border: none;
    
    }
    .btn-3 span {
    position: relative;
    display: block;
    width: 100%;
    height: 100%;
    }
    .btn-3:before,
    .btn-3:after {
    position: absolute;
    content: "";
    right: 0;
    top: 0;
    background: rgba(2,126,251,1);
    transition: all 0.3s ease;
    }
    .btn-3:before {
    height: 0%;
    width: 2px;
    }
    .btn-3:after {
    width: 0%;
    height: 2px;
    }
    .btn-3:hover{
    background: transparent;
    box-shadow: none;
    }
    .btn-3:hover:before {
    height: 100%;
    }
    .btn-3:hover:after {
    width: 100%;
    }
    .btn-3 span:hover{
    color: rgba(2,126,251,1);
    }
    .btn-3 span:before,
    .btn-3 span:after {
    position: absolute;
    content: "";
    left: 0;
    bottom: 0;
    background: rgba(2,126,251,1);
    transition: all 0.3s ease;
    }
    .btn-3 span:before {
    width: 2px;
    height: 0%;
    }
    .btn-3 span:after {
    width: 0%;
    height: 2px;
    }
    .btn-3 span:hover:before {
    height: 100%;
    }
    .btn-3 span:hover:after {
    width: 100%;
    }
    </style>

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
<!--Navbar Ends-->

    <!--HEADER-->
    <div class="container">
        <div class="row mt-4">

            <!--Main Area Starts-->
            <div class="col-sm-8" >
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
                }//Query When Pagination is Active. i.e blog.php?Page=1
                elseif(isset($_GET["page"])){
                    $page = $_GET["page"];
                    if($page==0 || $page<1){
                    $ShowPostFrom=0;
                    }else{
                    $ShowPostFrom=($page*3)-3;
                    }
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,3";
                    $stmt = $connectingDB->query($sql);
                }
                //Query when categories is active in URL
                elseif(isset($_GET["category"])){
                    $Category = $_GET["category"];
                    $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);

                }
                //The default SQL query
                else{
                    $sql  = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                    $stmt = $connectingDB->query($sql);
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
                <div class="card">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                    <small class="text-muted"><span class="text-dark">Category: <a href="blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> Written by <span class="text-dark" ><a href="profile.php?username=<?php echo htmlentities($Admin); ?>" target="_blank"><?php echo htmlentities($Admin); ?></a></span> on <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                    <span style="float:right;" class="badge badge-dark text-light">
                        Comments: <?php echo ApproveCommentsAccordingToPost($PostId);?>
                    </span>
                    <hr>
                    <p class="card-text">
                        <?php
                            if (strlen($PostDescription)>150){
                              $PostDescription = substr($PostDescription,0,150)."...";  
                            } 
                            echo htmlentities($PostDescription); 
                        ?>
                    </p>
                    <a href="fullpost.php?id=<?php echo $PostId; ?>" style="float:right;">
                        <button class="custom-btn btn-3"><span>Read More</span></button>
                    </a>

                </div>
                </div>
            <?php } ?>
            <!--Pagination-->
            <nav>
                <ul class="pagination pagination-lg mt-3">
                    <!--Backward button-->
                    <?php 
                        if(isset($page)){
                            if($page>1){                           
                       ?>
                       <li class="page-item">
                            <a href="blog.php?page=<?php echo $page-1; ?>" class="page-link">&laquo;</a>
                        </li>                        
                      <?php } }?>
                   <?php
                    global $connectingDB;
                    $sql = "SELECT COUNT(*) FROM posts";
                    $stmt = $connectingDB->query($sql);
                    $RowPagination = $stmt->fetch();
                    $TotalPosts = array_shift($RowPagination);
                    //echo $TotalPosts."<br>";
                    $PostPagination = $TotalPosts/3;
                    $PostPagination = ceil($PostPagination);
                    //echo $PostPagination;
                    for($i=1; $i<=$PostPagination ; $i++){
                        if(isset($page)){ 
                            if($i==$page){                                          
                   ?>
                    <li class="page-item active">
                        <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    
                    <?php
                        }else{
                          ?><li class="page-item">
                             <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li> 
                      <?php  }
                       } }  ?>
                       <!--Forward button-->
                       <?php 
                        if(isset($page) && !empty($page)){
                            if($page+1<=$PostPagination){                           
                       ?>
                       <li class="page-item">
                            <a href="blog.php?page=<?php echo $page+1; ?>" class="page-link">&raquo;</a>
                        </li>
                      <?php } } ?>

                </ul>
            </nav>
                
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

    <!--Footer Starts-->
    <?php require_once("includes/footer.php"); ?>
    <!--Footer Ends-->

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