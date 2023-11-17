<?php
    session_start();
    include_once "config.php";
    $name = mysqli_real_escape_string($conn, $_POST['custname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phoneNo = mysqli_real_escape_string($conn, $_POST['phoneNo']);
    $access_lvl = "Normal User";
    if(!empty($name) && !empty($email) && !empty($password) && !empty($phoneNo)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                echo "$email - This email already exist!";
            }else{
                        $status = "Active now";
                        $encrypt_pass = md5($password);
                        $insert_query = mysqli_query($conn, "INSERT INTO user (user_id, name, email, password, phone_no, access_level, status)
                        VALUES (0, '{$name}', '{$email}', '{$encrypt_pass}', '{$phoneNo}', '{$access_lvl}', '{$status}')");
                        if($insert_query){
                            $select_sql2 = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
                            if(mysqli_num_rows($select_sql2) > 0){
                                $result = mysqli_fetch_assoc($select_sql2);
                                $_SESSION['user_id'] = $result['user_id'];
                                echo "success";
                            }else{
                                echo "This email address not Exist!";
                            }
                        }else{
                            echo "Something went wrong. Please try again!";
                        }
                    }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>
