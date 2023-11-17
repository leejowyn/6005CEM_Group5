<?php 
    session_start();
    if(isset($_SESSION['admin_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['admin_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
            // Storingthe cipher method
            $ciphering = "AES-128-CTR";
            // Using OpenSSl Encryption method
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            // Non-NULL Initialization Vector for encryption
            $encryption_iv = '1234567891011121';
            // Storing the encryption key
            $encryption_key = "GrandClinic123";
            // Using openssl_encrypt() function to encrypt the data
            $encryption = openssl_encrypt($message, $ciphering, $encryption_key, $options, $encryption_iv);
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$encryption}')") or die();
        }
    }else{
        header("location: ../login.php");
    }


    
?>