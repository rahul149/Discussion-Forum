<?php
    $showAlert=false;
    $showError=false;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        include '_dbconnect.php';
        $useremail = $_POST['signmail'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $exists=false;
        //check wheather this username exists
        $existsql = "SELECT * FROM `users` WHERE `user_mail` = '$username'"; 
        $result = mysqli_query($conn, $existsql);
        $userExist = mysqli_num_rows($result);
        if($userExist > 0)
        {
            $showError = "User mail id Already Exists!!";
        }else if($password == $cpassword)
                {   $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql= "INSERT INTO `users` (`user_id`, `user_mail`, `user_name`, `user_pass`, `timestamp`) VALUES (NULL, '$useremail', '$username', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);
                // echo $result;
                if($result){
                    $showAlert = true;
                   header("Location: /forum/index.php?signupsuccess=true");
                   exit();
                    }
                 }else{
                        $showError = "Passwords did not matched";
                    }
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");
        
    }
?>
