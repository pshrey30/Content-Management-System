<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<!--Fetching the exisitng Data-->
<?php 
$SearchQueryParameter = $_GET['username'];
global $connectingDB;
$sql ="SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:username";
$stmt = $connectingDB->prepare($sql);
$stmt->bindValue(':username',$SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1){
    while($DataRows=$stmt->fetch()){
        $ExisitngName = $DataRows["aname"];
        $ExisitngBio = $DataRows["abio"];
        $ExisitngImage = $DataRows["aimage"];
        $ExisitngHeadline = $DataRows["aheadline"];
    }
}else{
    $_SESSION["ErrorMessage"] = "Username not found";
        Redirect_to("blog.php?Page=1");
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

    <title>Profile</title>

  </head>
  <body>
        <!--NavBar-->
    <?php  require_once("includes/navbar.php"); ?>
    <!--Navbar END-->

    <!--HEADER-->
    <header class="bg-dark text-white py-3 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

            <h1><i class="fas fa-user text-success mr-2" style="color: #27aae1;"></i> <?php echo $ExisitngName; ?></h1>
            <h3><?php echo $ExisitngHeadline; ?></h3>
            </div>
        </div>
        </div>
    </div>
    </header>

    <!--HEADER END-->
    <section class="container py-2 mb-5">
        <div class="row">
            <div class="col-md-3 mt-4">
                <img src="images/<?php echo $ExisitngImage; ?>" class="d-block img-fluid mt-2" alt="">
            </div>
            <div class="col-md-9 mt-5" style="min-height:312 px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead"><?php echo $ExisitngBio; ?></p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--FOOTER-->
    <?php  require_once("includes/footer.php"); ?>
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