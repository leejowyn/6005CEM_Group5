<?php

  $page = "admin_login";

  $err = "";

  session_start();

  if (isset($_SESSION['admin_id'])) {
    session_destroy();
  }
  else {
    if (isset($_POST['submitted'])) {
      $dbc = mysqli_connect('localhost', 'root', '');
      mysqli_select_db($dbc, 'in_haus');
      
      $admin_email = $_POST['email'];
      $admin_password = md5($_POST['password']);
  
      $query = "SELECT * FROM user 
                WHERE email = '$admin_email' 
                AND password = '$admin_password' 
                AND access_level != 'Normal User'";
  
      $r = mysqli_query($dbc, $query);
      $row = mysqli_fetch_assoc($r);
  
      if (isset($row)) {
        $_SESSION['admin_id'] = $row['user_id'];
        $_SESSION['admin_name'] = $row['name'];
        $_SESSION['admin_email'] = $row['email'];
        $_SESSION['admin_position'] = $row['access_level'];

        if ($_SESSION['admin_position'] == "Customer Service")
          header("Location: users.php");
        else
          header("Location: dashboard.php");
      }
      else {
        $query = "SELECT * FROM user 
                  WHERE email = '$admin_email'  
                  AND access_level != 'Normal User'";

        $r = mysqli_query($dbc, $query);
        $row = mysqli_fetch_assoc($r);

        if (isset($row))
          $err = "The e-mail or password that you've entered is incorrect. Please try again.";
        else
          $err = "The e-mail that you've entered does not match any account.";
      }
  
      mysqli_close($dbc);
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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

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
                  <div class="text-danger pb-3"><?php echo $err; ?></div>
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