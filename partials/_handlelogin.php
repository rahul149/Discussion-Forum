<?php
    $login=false;
    $showError=false;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        include '_dbconnect.php';
        $usermail = $_POST['loginmail'];
        $user_pass = $_POST['pass'];
       
   
            $sql= "SELECT * FROM `users` WHERE `user_mail` = '$usermail'  ";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num == 1){
                while($row = mysqli_fetch_assoc($result)){
                    if(password_verify($user_pass, $row['user_pass'])){
                        $login = true;  
                        session_start();
                        $_SESSION['loggedin']=true;
                        $_SESSION['username']=$row['user_name'];
                        $_SESSION['_userid']=$row['user_id'];
                        header("location: /forum/index.php?loginsuccess=true");
                        exit();
                    }else{
                        $showError = "Invalid Credentials";
                    }
                }
            } else{
                $showError = "User Does not exist.";
            }
            header("Location: /forum/index.php?loginsuccess=false&error=$showError");
    }

?>