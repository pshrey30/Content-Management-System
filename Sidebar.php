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
