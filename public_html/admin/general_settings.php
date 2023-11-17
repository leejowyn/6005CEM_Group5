<?php
  $page = "general_settings";
  $managerAccessOnly = true;
  session_start();

  $email = $contact_no = $address = $first_payment = $second_payment = $third_payment = "";
  $success_alert = $fail_alert = "";
  $okay = true;

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  $query = 'SELECT * FROM settings';
		
  if ($result = mysqli_query($dbc, $query)) {
    while ($row = mysqli_fetch_array($result)) {
      switch ($row['settings_name']) {
        case 'email':
          $email = $row['settings_value'];
          break;

        case 'contact_no':
          $contact_no = $row['settings_value'];
          break;

        case 'address':
          $address = $row['settings_value'];
          break;

        case 'first_payment':
          $first_payment = $row['settings_value'];
          break;

        case 'second_payment':
          $second_payment = $row['settings_value'];
          break;

        case 'third_payment':
          $third_payment = $row['settings_value'];
          break;
        
        default:
          break;
      }
    }
  }
  else {
    $fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
  }

  if (isset($_POST['updated'])) {

    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];
    $first_payment = $_POST['first_payment'];
    $second_payment = $_POST['second_payment'];
    $third_payment = $_POST['third_payment'];

    $settings_name = array("email", "contact_no", "address", "first_payment", "second_payment", "third_payment");

    // validate contact no
    // if ((substr($phone, 0, 3) == "011" && strlen($phone) == "11") ||
    //     (substr($phone, 0, 2) == "01" && strlen($phone) == "10") ||
    //     (substr($phone, 0, 2) == "04" && strlen($phone) == "9")) {
      
    //   echo "correct";
    // }
    // else {
    //   echo "wrong";
    // }

    // update database
    foreach ($settings_name as $name) {
      $value = $_POST[$name];
      $query = "UPDATE settings SET settings_value = '$value' WHERE settings_name = '$name'";

      if (!mysqli_query($dbc, $query)) {
        $okay = false;
        $fail_alert = "Could not update the settings because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
        break;
      }
    }

    if ($okay) {
      $success_alert = "Settings has been updated successfully.";
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
  <link rel="stylesheet" href="assets/modules/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="assets/modules/codemirror/theme/duotone-dark.css">

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
        <?php include("navbar.php"); ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <div class="section-header">
            <div class="section-header-back">
              <!-- <a href="features-settings.php" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a> -->
            </div>
            <h1>General Settings</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="general_settings.php">Settings</a></div>
              <div class="breadcrumb-item">General Settings</div>
            </div>
          </div>

          <div class="section-body">
            <div id="output-status"></div>
            <form action="general_settings.php" method="post">
              <!-- Success Alert and Save Button -->
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card shadow-none">
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
                    <div class="card-header" style="min-height:0px;">
                      <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-check"></i> Save Changes</button> 
                      <input type="hidden" name="updated" value="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Contact Settings -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                          <h4>Contact</h4>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                          </div>
                          <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" name="contact_no" class="form-control" value="<?php echo $contact_no; ?>" required>
                          </div>
                          <div class="form-group mb-0">
                            <label>Address</label>
                            <textarea class="form-control" name="address" required><?php echo $address; ?></textarea>
                          </div>
                        </div>
                    </div>
                </div>
                <!-- Payment Settings -->
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card">
                    <div class="card-header">
                      <h4>Payment</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group row align-items-end">
                        <label>1st Payment</label>
                        <div class="col-sm-6 col-md-3 input-group">
                            <input type="number" name="first_payment" class="form-control" value="<?php echo $first_payment; ?>" required>
                            <span class="input-group-addon d-flex align-items-end pl-2">%</span>
                        </div>
                      </div>
                      <div class="form-group row align-items-end">
                        <label>2nd Payment</label>
                        <div class="col-sm-6 col-md-3 input-group">
                            <input type="number" name="second_payment" class="form-control" value="<?php echo $second_payment; ?>" required>
                            <span class="input-group-addon d-flex align-items-end pl-2">%</span>
                        </div>
                      </div>
                      <div class="form-group row align-items-end">
                        <label>3rd Payment</label>
                        <div class="col-sm-6 col-md-3 input-group">
                            <input type="number" name="third_payment" class="form-control" value="<?php echo $third_payment; ?>" required>
                            <span class="input-group-addon d-flex align-items-end pl-2">%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
  		    </div>

      	</section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
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
  <script src="assets/modules/codemirror/lib/codemirror.js"></script>
  <script src="assets/modules/codemirror/mode/javascript/javascript.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/features-setting-detail.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>