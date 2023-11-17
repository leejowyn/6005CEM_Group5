<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit; // Ensure script stops execution after redirect
}
?>

<?php include_once "header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Add Content Security Policy (CSP) meta tag here if applicable -->
    <style>
        /* Your existing CSS styles */

        .password-strength {
            margin-top: 10px;
        }

        #password-strength-bar {
            height: 10px;
            border-radius: 5px;
            width: 0%;
            transition: width 0.3s;
        }

        #password-strength-text {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="body">
        <div class="wrapper">
            <section class="form signup">
                <header>In_Haus</header>

                <form action="signup1.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="error-text"></div>

                    <div class="field input">
                        <label for="custname">Name</label>
                        <input type="text" id="custname" name="custname" placeholder="Name" required maxlength="20">
                    </div>

                    <div class="field input">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required maxlength="255">
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password" required>
                        <i class="fas fa-eye" onclick="togglePassword()"></i>
                    </div>
                    <div class="password-strength">
                        <span id="password-strength-text">Password Strength: </span>
                        <div id="password-strength-bar"></div>
                    </div>

                    <div class="field input">
                        <label for="phoneNo">Phone Number</label>
                        <input type="tel" id="phoneNo" name="phoneNo" placeholder="Phone number" required maxlength="20">
                    </div>

                    <!-- Checkbox for agreeing to terms and conditions -->
                    <div class="field checkbox">
                        <label for="agreeTerms">
                            <input type="checkbox" id="agreeTerms" required> I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>
                        </label>
                    </div>

                    <div class="field button">
                        <input type="submit" name="submit" value="Continue to Chat">
                    </div>
                </form>
                <div class="link">Already signed up? <a href="login.php">Login now</a></div>
            </section>
        </div>

        <script src="javascript/pass-show-hide.js"></script>
        <script src="javascript/signup.js"></script>

        <script>
            function togglePassword() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

            document.getElementById("password").addEventListener("input", function () {
                var password = document.getElementById("password").value;
                var strengthText = document.getElementById("password-strength-text");
                var strengthBar = document.getElementById("password-strength-bar");
                var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                if (password.length === 0) {
                    strengthText.textContent = "Password Strength: ";
                    strengthBar.style.width = "0%";
                } else if (password.length < 6) {
                    strengthText.textContent = "Password Strength: Very Weak";
                    strengthBar.style.width = "20%";
                    strengthBar.style.backgroundColor = "#ff0000"; // Red color
                } else if (regex.test(password)) {
                    strengthText.textContent = "Password Strength: Strong";
                    strengthBar.style.width = "80%";
                    strengthBar.style.backgroundColor = "#4CAF50"; // Green color
                } else {
                    strengthText.textContent = "Password Strength: Weak";
                    strengthBar.style.width = "40%";
                    strengthBar.style.backgroundColor = "#ff9800"; // Orange color
                }
            });
        </script>

    </div>

</body>

</html>
