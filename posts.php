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

    <title>Posts</title>

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
                <h1><i class="fas fa-blog" style="color: #27aae1;"></i> Blog Posts</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addnewposts.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Add New Post
                </a>
            </div>
        </div>
    </div>
    </header>
    <!--HEADER END-->



    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date&tTime</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        global $connectingDB;
                        $sql  = "SELECT * FROM posts ORDER BY id desc";
                        $stmt = $connectingDB->query($sql);
                        $Sr   = 0;
                        while($DataRows = $stmt->fetch()){
                            $Id        = $DataRows["id"];
                            $DateTime  = $DataRows["datetime"];
                            $PostTitle = $DataRows["title"];
                            $Category  = $DataRows["category"];
                            $Admin     = $DataRows["author"];
                            $Image     = $DataRows["image"];
                            $PostText  = $DataRows["post"];
                            $Sr++;
                        
                    ?>
                    <tr>
                        <td><?php echo $Sr; ?></td>
                        <td>
                            <?php if(strlen($PostTitle)>20){
                                $PostTitle = substr($PostTitle,0,18)."...";
                            }   
                            echo $PostTitle;
                            ?>
                        </td>
                        <td>
                            <?php if(strlen($Category)>8){
                                $Category = substr($Category,0,8)."...";
                            }   
                            echo $Category;
                            ?>
                        </td>
                        <td>
                            <?php if(strlen($DateTime)>11){
                                $DateTime = substr($DateTime,0,11)."...";
                            }
                            echo $DateTime; 
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(strlen($Admin)>6){
                                    $Admin=substr($Admin,0,6)."...";
                            }
                            echo $Admin;    
                            ?>
                        </td>

                        <td><img src="uploads/<?php echo $Image; ?>" width="100px;" height="50px;"</td>

                        <td>                           
                        <?php 
                        $Total=ApproveCommentsAccordingToPost($Id);
                        if($Total>0){
                        ?>
                        <span class="badge badge-success">
                        <?php
                        echo $Total; 
                        ?>
                        </span>
                        <?php } ?>

                        <?php 
                        $Total=DisApproveCommentsAccordingToPost($Id);
                        if($Total>0){
                        ?>
                        <span class="badge badge-danger">
                        <?php
                        echo $Total; 
                        ?>
                        </span>
                        <?php } ?>
                        </td>
                        
                        <td>
                            <a href="editpost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                            <a href="deleteposts.php?id=<?php echo $Id; ?>"><span class="btn btn-danger" onclick="return checkdelete()">Delete</span></a>
                        </td>
                        <td><a href="fullpost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                    </tr>
                    </tbody>
                <?php } ?>
                </table>
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
        function checkdelete(){
            return confirm('Are you sure you want to delete this Post?')
        }   
    </script>
    
    
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
  </body>
</html>