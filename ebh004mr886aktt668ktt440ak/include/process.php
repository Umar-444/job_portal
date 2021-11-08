<?php
   include "auth.php" ;
   $cuser = new auth();

       // Administrator Login
   if(isset($_POST['login']))
   {
    
      $username = $cuser->test_input($_POST["username"]);
      $password = $cuser->test_input($_POST["password"]);

      if(empty($username) || empty($password)){
         
         header("location:../index.php?error=empty");
         exit(); 
      }elseif(strlen($password) > 12 || strlen($password) < 6){

         header("location:../index.php?error=pass");
         exit(); 
      }else{
         $cuser->adminLogin($username,$password);
      
            header("location:../dashboard.php?success=welcome");
            exit(); 
      }
   }

       // Administrator Register
   if(isset($_POST['register']))
   {
       $username = $cuser->test_input($_POST['username']);
       $email = $cuser->test_input($_POST['email']);
       $password = $cuser->test_input($_POST['password']);

      if(empty($username) || empty($email) || empty($password)){

         header("location:../auth_register.php?error=empty");
         exit();

      }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

         header("location:../auth_register.php?error=verification");
         exit();

      }elseif(strlen($password) > 12 || strlen($password) < 6){

         header("location:../auth_register.php?error=pass");
         exit();

      }else{  
       $cuser->adminRegister($username, $email, $password);

         header("location:../index.php");
         exit(); 
      }
   }

?>

    