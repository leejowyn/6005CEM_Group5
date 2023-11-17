<?php

    $page = "change_password";
    $pwInvalid = $pwChanged = false;

    session_start();

    $dbc = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($dbc, 'in_haus');

    if (isset($_POST['info'])) {
      $id = $_POST['id'];
      $email = $_POST['email'];
    }

    if (isset($_POST['submitted'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
          $pwInvalid = true;
        }
        else {
          $password = md5($_POST['password']);
          // update database
          $query = "UPDATE user SET 
                  password = '$password' 
                  WHERE email = '$email' 
                  AND access_level != 'Normal User'";

          if (mysqli_query($dbc, $query)) {
            $pwChanged = true;

            if ($_SESSION['admin_position'] == "Project Manager") {
              $alert_msg = "Password has been changed successfully.";
              $url = "staff.php?admin_id=" . $id;
            }
            else {
              $alert_msg = "Password has been changed successfully. Please login again.";
              $url = "login.php";
            }
          }
        }
    }

    if (empty($id) && empty($email)) {
      header("Location: staffs.php");
    }

    mysqli_close($dbc);

?>
<!DOCTYPE html>
<html lang="en">
<head>
 
  <?php include("head.php"); ?>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  
  <script src="assets/modules/sweetalert/sweetalert.min.js"></script>
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
  <?php 
    if ($pwChanged) {
      echo '<script type="text/javascript">
        swal(
          "Successful", 
          "'.$alert_msg.'", 
          "success"
        ).then(function() {
            window.location = "'.$url.'";
        });
      </script>';
    }
  ?>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Reset Password</h4></div>

              <div class="card-body">
                <!-- <p class="text-muted">We will send a link to reset your password</p> -->
                <form action="change_password.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="email" value="<?php echo $email; ?>">

                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                    <div id="pwindicator" class="pwindicator">
                      <div class="bar"></div>
                      <div class="label"></div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <div>
                      <input type="password" class="form-control <?php if ($pwInvalid) echo "is-invalid"; ?>" name="confirm_password" required>
                      <div class="invalid-feedback">
                        Password not match.
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="submitted" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Reset Password
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