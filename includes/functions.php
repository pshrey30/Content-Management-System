<?php
require_once("includes/db.php");

function Redirect_to($New_Location){
    header("location:".$New_Location);
    exit;
}

function CheckUserNameExistsOrNot($UserName){
    global $connectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
        return true;
    }else{
        return false;   
    }
}

function Login_Attempt($UserName,$Password){
    global $connectingDB;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
        return $Found_Account=$stmt->fetch();
    }else{
        return null;
    }
}

function Confirm_Login(){
    if(isset($_SESSION["UserId"])){
        return true;
    }else{
        $_SESSION["ErrorMessage"] = "Login Required !";
        Redirect_to("login.php");
    }
}


function TotalPosts(){
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $connectingDB->query($sql);
    $TotalRows  = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}


function TotalCategory(){
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $connectingDB->query($sql);
    $TotalRows  = $stmt->fetch();
    $TotalCategory = array_shift($TotalRows);
    echo $TotalCategory;
}


function TotalAdmins(){
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $connectingDB->query($sql);
    $TotalRows  = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}


function TotalComments(){
    global $connectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $connectingDB->query($sql);
    $TotalRows  = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}

function ApproveCommentsAccordingToPost($PostId){
    global $connectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
    $stmtApprove = $connectingDB->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

function DisApproveCommentsAccordingToPost($PostId){
    global $connectingDB;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
    $stmtDisApprove = $connectingDB->query($sqlDisApprove);
    $RowsTotal = $stmtDisApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
?>