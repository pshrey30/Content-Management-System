<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <!--Font Awesome CDN-->
  <link rel="stylesheet" href="https://kit.fontawesome.com/d71f73df39.css" crossorigin="anonymous">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<title>Contact Us</title>
</head>
<body>
    <!--Navbar-->
<?php require_once("includes/navbar.php"); ?>
    <!--Navbar Ends-->
    <!--Contact Us-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 py-5 text-black">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
          <h3>Address</h3>
          <p class="text-center">204/Shivalik-2<br>Ahmedabad,Gujarat<br>INDIA</p>
          <h3>Contact Us</h3>
          <p class="text-center">+91 6354536727</p>
          <h3>Follow Us</h3>
          <div class="d-flex justify-content-center">
            <a href="#" class="m-2"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="#" class="m-2"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="https://www.linkedin.com/in/shrey-patel-07856b215/" class="m-2"><i class="fab fa-linkedin fa-lg"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-8 py-5">
        <h4 class="pb-4">Get in touch</h4>
        <form action="#" method="POST">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
<!--Contact Us Ends-->

<!--Footer-->
<?php require_once("includes/footer.php"); ?>
<!--Footer Ends-->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
