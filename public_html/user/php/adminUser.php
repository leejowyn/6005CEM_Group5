<!--this is only for admin to see user who is online or choose who is going to reply or chata -->
<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE NOT user_id = {$outgoing_id} AND access_level ='Normal User'";
    
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>