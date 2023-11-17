<?php 
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $access_lvl = "Normal User";
    if(!empty($email) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}' AND access_level = '{$access_lvl}'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE user_id = {$row['user_id']}");
               
                if($sql2){
                    $_SESSION['user_id'] = $row['user_id'];
                    
                    echo "success";
                     
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
?>