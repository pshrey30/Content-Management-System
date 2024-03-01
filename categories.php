<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    //echo $_SESSION["TrackingURL"];
    Confirm_Login();
?>

<?php

if(isset($_POST['submit'])){
    $Category=$_POST["categorytitle"];
    $Admin   = $_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if(empty($Category)){
        $_SESSION["ErrorMessage"] = "All the fields must be filled out";
        Redirect_to("categories.php");
    }elseif(strlen($Category)<=2){
        $_SESSION["ErrorMessage"] = "Category must be more than 2 characters";
        Redirect_to("categories.php");
    }elseif(strlen($Category)>49){
        $_SESSION["ErrorMessage"] = "Category must be more than 2 characters";
        Redirect_to("categories.php");
    }else{
        // Query to insert category in db when everything is fine
        global $connectingDB;
        $sql = "INSERT INTO category(title,author,datetime)";
        $sql.="VALUES(:category,:adminname,:datetime)";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindValue(':category',$Category);
        $stmt->bindValue(':adminname',$Admin);
        $stmt->bindValue(':datetime',$DateTime);
        $execute=$stmt->execute();

        if($execute){
            $_SESSION["SuccessMessage"]="Category was added successfully";
            Redirect_to("categories.php");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("categories.php");
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

    <title>Categories</title>

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
            <h1><i class="fas fa-edit" style="color: #27aae1;"></i> Manage Categories</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addnewcategory.php" class="btn btn-primary btn-block">
                    <i class="fas fa-folder-plus"></i> Add New Category
                </a>
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
                <h2>Existing Categories</h2>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Date&Time</th>
                                <th>Category Name</th>
                                <th>Creator Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>          
                        <?php 
                        global $connectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $execute = $connectingDB->query($sql);
                        $srno = 0;
                        while($DataRows = $execute->fetch()){
                            $CategoryId    = $DataRows['id'];
                            $CategoryDate  = $DataRows['datetime'];
                            $CategoryName  = $DataRows['title'];
                            $CreatorName   = $DataRows['author'];
                            $srno++;                      
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($srno); ?></td>
                                <td><?php echo htmlentities($CategoryDate); ?></td>
                                <td><?php echo htmlentities($CategoryName); ?></td>                               
                                <td><?php echo htmlentities($CreatorName); ?></td>
                                <td>
                                <a href="editcategory.php?id=<?php echo $CategoryId; ?>"><span class="btn btn-warning">Edit</span></a>
                                <a href="deletecategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger"  onclick="return checkdelete()">Delete</a>
                                </td>                              
                            </tr>
                        </tbody>
                    <?php } ?>
                    </table>
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
        function checkdelete(){
            return confirm('Are you sure you want to delete this category?')
        }   
    </script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
  </body>
</html>