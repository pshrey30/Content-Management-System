<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    //echo $_SESSION["TrackingURL"];
    Confirm_Login();
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

    <title>Dashboard</title>

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
                <h1><i class="fas fa-cog" style="color: #27aae1;"></i> Dashboard</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addnewposts.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Add New Post
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="categories.php" class="btn btn-info btn-block">
                    <i class="fas fa-folder-plus"></i> Add New Category
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="admins.php" class="btn btn-warning btn-block">
                    <i class="fas fa-user-plus"></i> Add New Admin
                </a>
            </div>
            <div class="col-lg-3">
                <a href="comments.php" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Approve Comments
                </a>
            </div>
        </div>
    </div>
    </header>
    <!--HEADER END-->



    <!--Main Area-->
    <section class="container py-2 mb-4">
        <?php 
                echo ErrorMessage();
                echo SuccessMessage();
        ?>
        <div class="row">
            
        
        <!--Left Side Area Starts-->
        <div class="col-lg-2 d-none d-md-block">
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Posts</h1>
                    <h4 class="display-5">
                        <i class="fab fa-readme"></i>
                        <?php 
                            TotalPosts();
                        ?>
                    </h4>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Categories</h1>
                    <h4 class="display-5">
                        <i class="fas fa-folder"></i>
                        <?php 
                        TotalCategory();
                        ?>
                    </h4>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Admins</h1>
                    <h4 class="display-5">
                        <i class="fas fa-users"></i>
                        <?php 
                        TotalAdmins();
                        ?>
                    </h4>
                </div>
              </div>
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="lead">Comments</h1>
                    <h4 class="display-5">
                        <i class="fas fa-comments"></i>
                        <?php 
                        TotalComments();
                        ?>
                    </h4>
                </div>
              </div>            
        </div>
        <!--Left Side Area Ends-->

        <!--Right Side Area Starts-->
        <div class="col-lg-10">
            <h1>Top Posts</h1>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Authors</th>
                        <th>Comments</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <?php
                $SrNo = 0;
                global $connectingDB;
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                $stmt = $connectingDB->query($sql);
                while($DataRows=$stmt->fetch()){
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $Author = $DataRows["author"];
                    $Title = $DataRows["title"];
                    $SrNo++;
                ?>
                <tbody>
                    <tr>
                        <th><?php echo $SrNo;?></th>
                        <th><?php echo $Title;?></th>
                        <th><?php echo $DateTime;?></th>
                        <th><?php echo $Author;?></th>
                        <td>                           
                        <?php 
                        $Total=ApproveCommentsAccordingToPost($PostId);
                        if($Total>0){
                        ?>
                        <span class="badge badge-success">
                        <?php
                        echo $Total; 
                        ?>
                        </span>
                        <?php } ?>

                        <?php 
                        $Total=DisApproveCommentsAccordingToPost($PostId);
                        if($Total>0){
                        ?>
                        <span class="badge badge-danger">
                        <?php
                        echo $Total; 
                        ?>
                        </span>
                        <?php } ?>
                        </td>
                        <td><a target="_blank" href="fullpost.php?id=<?php echo $PostId; ?>">
                        <span class="btn btn-info">Preivew</span>
                        </a>
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
        <!--Right Side Area Ends-->
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