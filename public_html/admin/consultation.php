<?php

  function insertProject($cust_id, $consultation_id, $admin_id, $okay) {
    $current_time = date("Y-m-d H:i:s", strtotime("now"));
    $project_status = "Waiting for Staff to Upload Contract";
    $payment_status = "Waiting for 1st Payment";
    $payment_datetime = json_encode(array("1" => "", "2" => "", "3" => ""));
    $insert_id = "";

    $dbc = mysqli_connect('localhost', 'root', '');
	  mysqli_select_db($dbc, 'in_haus');

    $query = "INSERT INTO project (project_id, created_datetime, last_modified_datetime, project_name, project_status, payment_status, payment_datetime, project_fee, project_remark, project_details, project_contract, cust_id, consultation_id, admin_id) 
              VALUES ('', '$current_time', '$current_time', '', '$project_status', '$payment_status', '$payment_datetime', '', '', '', '', '$cust_id', '$consultation_id', '$admin_id')";

    if (mysqli_query($dbc, $query)) {
      $insert_id = mysqli_insert_id($dbc);
    }
    else {
      $okay = false;
    }

    mysqli_close($dbc);

    return array("success" => $okay, "insert_id" => $insert_id);
  }

  $page = "consultations";
  session_start();

  date_default_timezone_set("Asia/Kuala_Lumpur");

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');
  
  $success_alert = $fail_alert = "";

  // assign consultation to project leader (update admin)
  if (isset($_POST['consultation_id']) && isset($_POST['admin_id'])) {
    $consultation_id = $_POST['consultation_id'];
    $admin_id = $_POST['admin_id'];
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));

		$query = "UPDATE consultation SET 
              last_modified_datetime = '$last_modified_datetime', 
              admin_id = '$admin_id' 
              WHERE consultation_id = '$consultation_id'";

    if (mysqli_query($dbc, $query)) {
      echo true;
    }
    else {
      echo false;
    }
    exit();
  }

  // get consultation details
  if (!empty($_GET['consultation_id'])) {
		$consultation_id = $_GET['consultation_id'];
		$url = "consultation.php?consultation_id=" . $consultation_id;

		$query = "SELECT * FROM consultation c, user u 
              WHERE consultation_id = '$consultation_id' 
              AND c.cust_id = u.user_id";
		
		if ($result = mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_assoc($result);
      $created_datetime = $row['created_datetime'];
      $last_modified_datetime = $row['last_modified_datetime'];
      $cust_id = $row['cust_id'];
      $cust_name = $row['name'];
      $cust_email = $row['email'];
      $cust_phone_no = $row['phone_no'];

      $consultation_status = $row['consultation_status'];
      $consultation_date = $row['consultation_date'];
      $consultation_time = $row['consultation_time'];
      $consultation_type = $row['consultation_type'];
      $preferred_style = explode(",", $row['preferred_style']);
      $design_range = $row['design_range'];
      $consultation_remark = $row['consultation_remark'];
      $admin_id = $row['admin_id'];
		}
		else {
			$fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
		}

    if ($_SESSION['admin_position'] != "Project Manager" && $admin_id != $_SESSION['admin_id'])
      header("Location: error_403.php");

    // get project leader list
    $query = 'SELECT user_id, name FROM user WHERE access_level = "Project Leader"';

    if ($staffs_result = mysqli_query($dbc, $query)) {
      $staffs = array();
      while ($staff = mysqli_fetch_array($staffs_result)) {
        $staffs[$staff['user_id']] = $staff['name'];
      }
    }
    else {
      $fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
    }
	}
	else {
		header("Location: error_404.php");
	}

  // update consultation status from ajax request
  if (isset($_POST['consultation_id']) && isset($_POST['consultation_status'])) {
    $consultation_id = $_POST['consultation_id'];
    $consultation_status = $_POST['consultation_status'];
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));
    $okay = true;
    $insertProjectResult = "";

		$query = "UPDATE consultation SET 
              last_modified_datetime = '$last_modified_datetime', 
              consultation_status = '$consultation_status' 
              WHERE consultation_id = '$consultation_id'";

    if (!mysqli_query($dbc, $query)) {
      $okay = false;
    }

    if ($consultation_status == "Project Confirmed") {
      // insert into project table
      $insertProjectResult = insertProject($cust_id, $consultation_id, $admin_id, $okay);
      echo json_encode($insertProjectResult);
    }
    else {
      echo json_encode(array("success" => $okay));
    }
    
    exit();
  }

  // update consultation details
  if (isset($_POST['updated'])) {
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));
    $consultation_status = $_POST['consultation_status'];
    $consultation_date = $_POST['consultation_date'];
    $consultation_time = $_POST['consultation_time'];
    $consultation_type = $_POST['consultation_type'];
    $preferred_style = $_POST['preferred_style'];
    $preferred_style_str = implode(",", $_POST['preferred_style']);
    $design_range = $_POST['design_range'];
    $consultation_remark = $_POST['consultation_remark'];
    $admin_id = $_POST['admin_id'];
    $okay = true;

    // update database
		$query = "UPDATE consultation SET 
              last_modified_datetime = '$last_modified_datetime', 
              consultation_status = '$consultation_status', 
              consultation_date = '$consultation_date', 
              consultation_time = '$consultation_time', 
              consultation_type = '$consultation_type', 
              preferred_style = '$preferred_style_str', 
              design_range = '$design_range', 
              consultation_remark = '$consultation_remark', 
              admin_id = '$admin_id' 
              WHERE consultation_id = '$consultation_id'";

    if (!mysqli_query($dbc, $query)) {
      $okay = false;
    }

    if ($consultation_status == "Project Confirmed") {
      // insert into project table
      $insertProjectResult = insertProject($cust_id, $consultation_id, $admin_id, $okay);
      $okay = $insertProjectResult['success'];
    }

    if ($okay) {
      if ($consultation_status == "Project Confirmed")
        $success_alert = 'Consultation has been updated successfully. You can update the project details <a class="text-primary" href="project.php?project_id='.$insertProjectResult['insert_id'].'" target="_blank"><u>here</u></a>.';
      else 
        $success_alert = "Consultation has been updated successfully.";
    }
    else {
      $fail_alert = "Could not update the consultation because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
    }
  }

  // if (isset($_POST['submitted'])) {
  //   $admin_name = $_POST['name'];
  //   $admin_email = $_POST['email'];
  //   $admin_password = $_POST['password'];
  //   $confirm_password = $_POST['confirm_password'];

  //   $query = "INSERT INTO admin (admin_id, admin_name, admin_email, admin_password, admin_position) 
  //             VALUES ('', '$admin_name', '$admin_email', MD5('$admin_password'), DEFAULT)";

  //   if (mysqli_query($dbc, $query)) {
  //     $admin_id = mysqli_insert_id($dbc);
  //     header('Location: staff.php?admin_id=' . $admin_id);
  //   }
  //   else {
  //     $fail_alert = "Could not add staff because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
  //   }
   
  // }

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
            <h1>Consultation</h1>
          </div>

          <div class="section-body">
            <form action="<?php echo $url; ?>" method="post">
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
                      <button type="submit" class="btn btn-icon icon-left btn-primary mr-2"><i class="fas fa-check"></i> Save Changes</button> 
                      <a href="consultations.php" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Close</a>
                      <input type="hidden" name="updated" value="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $consultation_id; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Created Datetime</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $created_datetime; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Last Modified</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $last_modified_datetime; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $cust_name; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer E-mail</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" value="<?php echo $cust_email; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer Contact</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" value="<?php echo $cust_phone_no; ?>" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card">
                      <div class="card-body">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Status</label>
                          <div class="col-sm-9">
                            <?php if ($consultation_status == "Project Confirmed"): ?>
                              <input type="text" name="consultation_status" class="form-control" value="<?php echo $consultation_status; ?>" disabled>
                            <?php else: ?>
                            <select class="form-control" name="consultation_status" required>
                                <option value="Pending" <?php echo ($consultation_status == "Pending") ? "selected" : ""; ?>>Pending</option>
                                <option value="Done" <?php echo ($consultation_status == "Done") ? "selected" : ""; ?>>Done</option>
                                <option value="Project Confirmed" <?php echo ($consultation_status == "Project Confirmed") ? "selected" : ""; ?>>Project Confirmed</option>
                                <option value="Cancelled" <?php echo ($consultation_status == "Cancelled") ? "selected" : ""; ?>>Cancelled</option>
                            </select>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date</label>
                          <div class="col-sm-9">
                            <input type="date" name="consultation_date" class="form-control" value="<?php echo $consultation_date; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Time</label>
                          <div class="col-sm-9">
                            <input type="time" name="consultation_time" class="form-control" value="<?php echo $consultation_time; ?>" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Consultation Type</label>
                          <div class="col-sm-9">
                              <select class="form-control" name="consultation_type" required>
                                <option value="Phone Call" <?php echo ($consultation_type == "Phone Call") ? "selected" : ""; ?>>Phone Call</option>
                                <option value="Virtual Meeting" <?php echo ($consultation_type == "Virtual Meeting") ? "selected" : ""; ?>>Virtual Meeting</option>
                                <option value="In Store" <?php echo ($consultation_type == "In Store") ? "selected" : ""; ?>>In Store</option>
                                <option value="In Home" <?php echo ($consultation_type == "In Home") ? "selected" : ""; ?>>In Home</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Preferred Style</label>
                          <div class="col-sm-9 selectgroup selectgroup-pills">
                          <?php 
                            $style_arr = array("Modern Minimalist", "Industrial Style", "Traditional / Classic Style", "Art Deco Style", 
                                      "English Country Style", "Coastal Style", "Eclectic Style", "Asian / Zen Style", "Rustic Style", "Hi-Tech Style");

                            if (empty($preferred_style))
                              $preferred_style = $style_arr[0];

                            foreach ($style_arr as $s) {
                              if (in_array($s, $preferred_style)) {
                                echo
                                '<label class="selectgroup-item">
                                  <input type="checkbox" name="preferred_style[]" value="' .  $s . '" class="selectgroup-input" checked>
                                  <span class="selectgroup-button">' . $s . '</span>
                                </label>';
                              }
                              else {
                                echo
                                '<label class="selectgroup-item">
                                  <input type="checkbox" name="preferred_style[]" value="' .  $s . '" class="selectgroup-input">
                                  <span class="selectgroup-button">' . $s . '</span>
                                </label>';
                              }
                            }
                          ?>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Design Range</label>
                          <div class="col-sm-9">
                              <textarea class="form-control" name="design_range" cols="30" rows="10" required><?php echo $design_range; ?></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Remark</label>
                          <div class="col-sm-9">
                              <textarea class="form-control" name="consultation_remark" cols="30" rows="10"><?php echo $consultation_remark; ?></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Project Leader</label>
                          <div class="col-sm-9">
                              <select class="form-control" name="admin_id" required>
                                <?php
                                  foreach ($staffs as $staff_id => $staff_name) {
                                    if ($staff_id == $admin_id) 
                                      echo '<option value="'.$staff_id.'" selected>'.$staff_name.'</option>';
                                    else 
                                      echo '<option value="'.$staff_id.'">'.$staff_name.'</option>';
                                  }
                                ?>  
                              </select>
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

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>