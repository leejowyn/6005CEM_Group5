<?php 
    session_start();
    if(isset($_SESSION['admin_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['admin_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN user ON user.user_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $encryption = $row['msg'];
                    // Storingthe cipher method
                    $ciphering = "AES-128-CTR";
        
                    // Using OpenSSl Encryption method
                    $iv_length = openssl_cipher_iv_length($ciphering);
                    $options = 0;
        
                    // Storing the encryption key
                    $decryption_key = "GrandClinic123";
        
                    $decryption_iv = '1234567891011121';
                
                    
                    // Using openssl_decrypt() function to decrypt the data
                    $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
                
                    if ($decryption === false) {
                        // Handle decryption error
                        echo "Decryption failed: " . openssl_error_string();
                    } else {
                        // Display the decrypted value
                        $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'.  $decryption .'</p>
                                </div>
                                </div>';
                    }

                    
                }else{
                    $encryption = $row['msg'];
                    // Storingthe cipher method
                    $ciphering = "AES-128-CTR";
        
                    // Using OpenSSl Encryption method
                    $iv_length = openssl_cipher_iv_length($ciphering);
                    $options = 0;
        
                    // Storing the encryption key
                    $decryption_key = "GrandClinic123";
        
                    $decryption_iv = '1234567891011121';
                
                    
                    // Using openssl_decrypt() function to decrypt the data
                    $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
                
                    if ($decryption === false) {
                        // Handle decryption error
                        echo "Decryption failed: " . openssl_error_string();
                    } else {
                        // Display the decrypted value
                        $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $decryption .'</p>
                                </div>
                                </div>';
                    }
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>