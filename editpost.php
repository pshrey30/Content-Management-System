<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
    Confirm_Login();
?>

<?php
$SearchQueryParameter = $_GET["id"];
if(isset($_POST['submit'])){
    $PostTitle= $_POST["posttitle"];
    $Category = $_POST["category"];
    $Image    = $_FILES["image"]["name"];
    $Target   = "uploads/".basename($_FILES["image"]["name"]); 
    $PostText = $_POST["postdescription"];
    $admin    = $_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("posts.php");
    }elseif(empty($PostText)){
        $_SESSION["ErrorMessage"] = "Description can't be empty";
        Redirect_to("posts.php");
    }elseif(strlen($PostTitle)<=5){
        $_SESSION["ErrorMessage"] = "Post title must be more than 5 characters";
        Redirect_to("posts.php");
    }elseif(strlen($PostText)>9999){
        $_SESSION["ErrorMessage"] = "Post Description should be less than 1000 characters";
        Redirect_to("posts.php");
    }else{

        //Query to update post in db when everything is fine
        global $connectingDB;
        if(!empty($_FILES["image"]["name"])){
            $sql =  "UPDATE posts
                SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
                WHERE id='$SearchQueryParameter'";
        }
        else{
            $sql =  "UPDATE posts
                SET title='$PostTitle', category='$Category', post='$PostText'
                WHERE id='$SearchQueryParameter'";
        }
        $execute = $connectingDB->query($sql);
        move_uploaded_file($_FILES["image"]["tmp_name"],$Target);

        if($execute){
            $_SESSION["SuccessMessage"]="Post was updated successfully";
            Redirect_to("posts.php");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
            Redirect_to("posts.php");
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

    <title>Edit Post</title>

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
            <h1><i class="fas fa-edit" style="color: #27aae1;"></i> Edit Post</h1>
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
                $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
                $stmt = $connectingDB->query($sql);
                while($DataRows=$stmt->fetch()){
                    $TitleToBeUpdated    = $DataRows['title'];
                    $CategoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated    = $DataRows['image'];
                    $PostToBeUpdated     = $DataRows['post'];
                }
            ?>
                <form class="" action="editpost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeUpdated; ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Existing Category:</span>
                                    <?php echo $CategoryToBeUpdated; ?>
                                <br>
                                <label for="categorytitle"><span class="FieldInfo">Choose Category:</span></label>
                                <select class="form-control" id="categorytitle" name="category">
                                    <?php 
                                        global $connectingDB;
                                        $sql = "SELECT title FROM category";
                                        $stmt = $connectingDB->query($sql);

                                        while($DataRows=$stmt->fetch()){
                                            $Id = $DataRows["id"];
                                            $CategoryName = $DataRows["title"];
                                        
                                    ?>
                                    <option><?php echo $CategoryName; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                            <span class="FieldInfo">Existing Image:</span>
                            <img class="mb-3" src="uploads/<?php echo $ImageToBeUpdated; ?>" width="140px;" height="80px;">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="image" id="imageselect">
                                    <label for="imageselect" class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="FieldInfo"> Post:</span></label>
                                <textarea class="form-control" name="postdescription" id="post" cols="30" rows="10">
                                <?php echo $PostToBeUpdated; ?>
                                </textarea>                                
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