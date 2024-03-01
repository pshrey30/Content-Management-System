<?php
    require_once("includes/db.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>

<?php
if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    global $connectingDB;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $execute = $connectingDB->query($sql);
    if($execute){
        $_SESSION["SuccessMessage"]="Comment Deleted Successfully ! ";
        Redirect_to("comments.php");
    }else{
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again!";
        Redirect_to("comments.php");
    }
}
?>