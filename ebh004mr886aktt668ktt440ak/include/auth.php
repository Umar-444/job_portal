<?php
session_start();
require_once 'config.php';


class auth extends database{

    public function adminLogin($username, $password){
        //join query will be used
     $hPassword = $this->passwordHash($password);

        $query = $this->conn->prepare("SELECT * FROM job_portal_admin WHERE username=? AND pass=?");
        $query->execute(array($username , $hPassword));
        $control= $query->fetch(PDO::FETCH_ASSOC);
        $control_2 =$query->rowCount();
        if($control_2  > 0)
        {
              $_SESSION["username"] = $username;
              $_SESSION["password"] = $password;
              $_SESSION["id"] = $control['id'];
        }
    }

    public function adminRegister($username, $email, $password)
    {
     $hPassword = $this->passwordHash($password);

        $sql = "INSERT INTO job_portal_admin(username, email, pass) VALUES (:username, :email, :hPassword)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':username', $username ,PDO::PARAM_STR);
        $stmt->bindParam(':email', $email ,PDO::PARAM_STR);
        $stmt->bindParam(':hPassword', $hPassword ,PDO::PARAM_STR);
        $stmt->execute();
    }

    // validates the provided value against xss attacks.
    public function test_input($data)
    {
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
        }

    //for hash password insertion
    public function passwordHash($password)
    {
        $salt = ")(*&^%$#(*&^%$#*&^%$#";
        $hPassword = md5($password . $salt);
        return $hPassword;
    }
    
    public function check_Pass($username, $password)
    {
        $hPassword = $this->passwordHash($password);

        $sql = "SELECT * from job_portal_admin WHERE username =:username && pass=:hPassword";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':hPassword' => $hPassword,':username' => $username]);
        $count =  $stmt->rowCount();
        return $count;
    }
    
    // SESSION's in the User
    public function session_user($username)
    {
        $sql="SELECT id,username,email,pass from job_portal_admin where username=:username";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(":username",$username);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}  
?>