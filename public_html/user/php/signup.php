<?php
session_start();
include_once "config.php";

// Function to sanitize and validate user input
function sanitizeAndValidate($conn, $input) {
    $input = mysqli_real_escape_string($conn, $input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to hash the password securely
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeAndValidate($conn, $_POST['custname']);
    $email = sanitizeAndValidate($conn, $_POST['email']);
    $password = sanitizeAndValidate($conn, $_POST['password']); // Sanitize password
    $phoneNo = sanitizeAndValidate($conn, $_POST['phoneNo']);
    $access_lvl = "Normal User";

    if (!empty($name) && !empty($email) && !empty($password) && !empty($phoneNo)) {
        // Validate name (should contain only letters and spaces)
        if (preg_match("/^[a-zA-Z ]*$/", $name)) {
            // Validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Validate phone number (should contain only numbers)
                if (ctype_digit($phoneNo)) {
                    // Validate password strength
                    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                    if (preg_match($passwordRegex, $password)) {
                        $hashedPassword = hashPassword($password);

                        // Use prepared statements to prevent SQL injection
                        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo htmlspecialchars("$email - This email already exists!");
                        } else {
                            $status = "Active now";

                            // Use prepared statements for insertion
                            $stmt = $conn->prepare("INSERT INTO user (user_id, name, email, password, phone_no, access_level, status)
                                VALUES (0, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $phoneNo, $access_lvl, $status);
                            $stmt->execute();

                            if ($stmt->affected_rows > 0) {
                                $_SESSION['user_id'] = $stmt->insert_id;
                                
                                echo htmlspecialchars("success");
                            } else {
                                echo htmlspecialchars("Something went wrong. Please try again!");
                            }
                        }

                        $stmt->close();
                    } else {
                        echo htmlspecialchars("Password must be at least 8 characters long and contain at least one number, one uppercase letter, one lowercase letter, and one special character.");
                    }
                } else {
                    echo htmlspecialchars("Phone number should contain only numbers!");
                }
            } else {
                echo htmlspecialchars("$email is not a valid email!");
            }
        } else {
            echo htmlspecialchars("Name should contain only letters and spaces!");
        }
    } else {
        echo htmlspecialchars("All input fields are required!");
    }
} else {
    // Redirect or handle the case where the form is not submitted
    echo htmlspecialchars("Form not submitted!");
}

$conn->close();
?>
