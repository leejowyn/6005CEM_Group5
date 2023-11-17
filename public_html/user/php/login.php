<?php
session_start();
include_once "config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$access_lvl = "Normal User";

if (!empty($email) && !empty($password)) {
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}' AND access_level = '{$access_lvl}'");

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $enc_pass = $row['password'];

        // Use password_verify to check if the entered password matches the stored hashed password
        if (password_verify($password, $enc_pass)) {
            $status = "Active now";
            $sql2 = mysqli_query($conn, "UPDATE user SET status = '{$status}' WHERE user_id = {$row['user_id']}");

            if ($sql2) {
                $_SESSION['user_id'] = $row['user_id'];
                echo htmlspecialchars("success");
            } else {
                echo htmlspecialchars("Something went wrong. Please try again!");
            }
        } else {
            echo htmlspecialchars("Email or Password is Incorrect!");
        }
    } else {
        echo htmlspecialchars("$email - This email does not exist!");
    }
} else {
    echo htmlspecialchars("All input fields are required!");
}
?>
