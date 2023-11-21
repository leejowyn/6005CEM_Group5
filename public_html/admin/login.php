<?php

$page = "admin_login";

$err = "";

session_start();

if (isset($_SESSION['admin_id'])) {
  session_destroy();
} else {
  if (isset($_POST['submitted'])) {
    // Validate and sanitize user input
    $admin_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $admin_password = $_POST['password']; // No need to sanitize password for SQL queries

    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
      $err = "Invalid email format";
    } else {
      $dbc = mysqli_connect('localhost', 'root', '');
      mysqli_select_db($dbc, 'in_haus');

      // Use prepared statements to prevent SQL injection
      $query = "SELECT * FROM user 
                        WHERE email = ? 
                        AND access_level != 'Normal User'";

      $stmt = mysqli_prepare($dbc, $query);
      mysqli_stmt_bind_param($stmt, "s", $admin_email);
      mysqli_stmt_execute($stmt);
      $r = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($r)) {
        // Use password_verify to check if the entered password matches the stored hashed password
        if (password_verify($admin_password, $row['password'])) {
          $_SESSION['admin_id'] = $row['user_id'];
          $_SESSION['admin_name'] = $row['name'];
          $_SESSION['admin_email'] = $row['email'];
          $_SESSION['admin_position'] = $row['access_level'];

          date_default_timezone_set("Asia/Singapore");
          // Log admin login activity into log_activity table
          $user_id = $row['user_id']; 
          $current_datetime = date("Y-m-d H:i:s"); 

          // Insert into log_activity table
          $insert_query = "INSERT INTO log_activity (event_type, user_id, datetime) VALUES ('admin_login', ?, ?)";
          $insert_stmt = mysqli_prepare($dbc, $insert_query);
          mysqli_stmt_bind_param($insert_stmt, "ss", $user_id, $current_datetime);
          mysqli_stmt_execute($insert_stmt);

          if ($_SESSION['admin_position'] == "Customer Service") {
            header("Location: users.php");
          } else {
            header("Location: dashboard.php");
          }
        } else {
          $err = "The e-mail or password that you've entered is incorrect. Please try again.";
        }
      } else {
        $err = "$admin_email - This email does not exist!";
      }

      mysqli_close($dbc);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("head.php"); ?>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <!-- <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <img src="../user/images/logo.png" alt="logo" width="130" class=" ">
            </div>

            <div class="card card-primary">
              <h4 class="text-center pt-5 pb-4">Login</h4>

              <div class="card-body">
                <form method="POST" action="login.php" class="needs-validation" novalidate="">
                  <!-- Use htmlspecialchars to escape special characters in the error message -->
                  <div class="text-danger pb-3"><?php echo htmlspecialchars($err); ?></div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <!-- <div class="mb-4">
                    <a href="auth-forgot-password.php" class="text-small">
                      Forgot Password?
                    </a>
                  </div> -->

                  <div class="form-group">
                    <button type="submit" name="submitted" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; In Haus 2022
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>