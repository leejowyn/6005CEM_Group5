<?php
  $page = "staffs";
  $managerAccessOnly = true;
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');
  
  $admin_name = $admin_email = "";
  $emailInvalid = $pwInvalid = $success_alert = $fail_alert = "";
  $okay = true;

  if (!empty($_GET['admin_id'])) {
		$admin_id = $_GET['admin_id'];
		$url = "staff.php?admin_id=" . $admin_id;

		$query = 'SELECT * FROM user WHERE user_id = ' . $admin_id . ' AND access_level != "Normal User"';
		$result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);

		if (!empty($row)) {
			$admin_name = $row['name'];
      $admin_email = $row['email'];
		}
		else {
      header("Location: error_404.php");
			// $fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
		}
	}
	else {
		$url = "staff.php";
	}

  if (isset($_POST['updated'])) {
    $admin_name = $_POST['name'];
    $admin_email = $_POST['email'];

    // check if email exist
    $query = "SELECT * FROM user WHERE email = '$admin_email' AND access_level != 'Normal User'";

    $r = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($r);

    if (isset($row)) {
      $emailInvalid = true;
      $okay = false;
    }

    if ($okay) {
      // update database
      $query = "UPDATE user SET 
      name = '$admin_name', 
      email = '$admin_email'
      WHERE user_id = '$admin_id'";

      if (mysqli_query($dbc, $query)) {
        $success_alert = "Staff has been updated successfully.";
      }
      else {
        $fail_alert = "Could not update the staff because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
      }

    }

  }

  if (isset($_POST['submitted'])) {
    $admin_name = $_POST['name'];
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // check if email exist
    $query = "SELECT * FROM user WHERE email = '$admin_email' AND access_level != 'Normal User'";

    $r = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($r);

    if (isset($row)) {
      $emailInvalid = true;
      $okay = false;
    }

    if ($admin_password != $confirm_password) {
      $pwInvalid = true;
      $okay = false;
    }

    if ($okay) {
      $query = "INSERT INTO user (user_id, name, email, password, phone_no, access_level, status) 
                VALUES ('', '$admin_name', '$admin_email', MD5('$admin_password'), DEFAULT, 'Project Leader', DEFAULT)";

      if (mysqli_query($dbc, $query)) {
        $admin_id = mysqli_insert_id($dbc);
        header('Location: staff.php?admin_id=' . $admin_id);
      }
      else {
        $fail_alert = "Could not add staff because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
      }
    }
   
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
  <link rel="stylesheet" href="assets/modules/chocolat/dist/css/chocolat.css">

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
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <?php include("navbar.php") ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Staff</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <form action="<?php echo $url; ?>" method="post">
                  <div class="card">
                    <?php if (!empty($success_alert)): ?>
                    <div class="alert alert-success alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
                        <?php echo $success_alert; ?>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($fail_alert)): ?>
                    <div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
                        <?php echo $fail_alert; ?>
                      </div>
                    </div>
                    <?php endif; ?>
                    <div class="card-header">
                      <?php if (!empty($admin_id)): ?>
                      <button type="submit" class="btn btn-icon icon-left btn-primary mr-2"><i class="fas fa-check"></i> Save Changes</button> 
                      <input type="hidden" name="updated" value="true">
                      <?php else: ?>
                      <button type="submit" class="btn btn-icon icon-left btn-primary mr-2"><i class="fas fa-check"></i> Save</button> 
                      <input type="hidden" name="submitted" value="true">
                      <?php endif; ?>
                      <a href="staffs.php" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Close</a>
                    </div>
                      <div class="card-body">
                        <?php if (!empty($admin_id)): ?>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">ID</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $admin_id; ?>" disabled>
                          </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" value="<?php echo $admin_name; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">E-mail</label>
                          <div class="col-sm-9">
                            <input type="email" name="email" class="form-control <?php if ($emailInvalid) echo "is-invalid"; ?>" value="<?php echo $admin_email; ?>" required>
                            <div class="invalid-feedback">
                              This e-mail address is registered with another account.
                            </div>
                          </div>
                        </div>
                        <?php if (empty($admin_id)): ?>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password</label>
                          <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Confirm Password</label>
                          <div class="col-sm-9">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php if ($pwInvalid) echo "is-invalid"; ?>" required>
                            <div class="invalid-feedback">
                              Password not match.
                            </div>
                          </div>
                        </div>
                        <?php endif; ?>
                        </form>
                        <?php if (!empty($admin_id)): ?>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                              <form action="change_password.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $admin_id; ?>">
                                <input type="hidden" name="email" value="<?php echo $admin_email; ?>">
                                <input type="submit" name="info" value="Change Password" class="btn btn-primary" style="border-radius: 30px;">
                              </form>
                            </div>
                          </div>
                        <?php endif; ?>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
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
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->


  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>