<?php 
include "auth.php";
if(!isset($_SESSION['username'])){
    header("Location:./index.php");
    exit();
}else{
    $cuser=new auth();
    $result=$cuser->session_user($_SESSION['username']);
    $_SESSION['id'] = $result['id'];
    $_SESSION['username'] = $result['username'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['password'] = $result['pass'];    
}
?>