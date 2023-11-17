<?php

  use PHPMailer\PHPMailer\PHPMailer;

  require_once 'phpmailer/Exception.php';
  require_once 'phpmailer/PHPMailer.php';
  require_once 'phpmailer/SMTP.php';

  function sendFeedbackEmail($cust_id, $cust_name, $cust_email, $project_id) {

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'p20012398@student.newinti.edu.my'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'jrbggwlluwqsjiny'; // Gmail address Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom('p20012398@student.newinti.edu.my'); // Gmail address which you used as SMTP server
    $mail->addAddress($cust_email); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

    $mail->isHTML(true);
    $mail->Subject = 'In Haus - Feedback Form';
    $mail->Body = "<p>Hi ".$cust_name."! .Thank you for choosing out company! Below is the feedback form link, Please click in for feedback. Thank you<p><a href='http://localhost/public_html/user/feedBackForm.php?project_id=".$project_id."&cust_id=".$cust_id."'>Click here</a>";
    $mail->send();

    // if ($mail->send()) {
    //   $myfile = fopen("sendEmailDebug.txt", "w") or die("Unable to open file!");
    //   fwrite($myfile,print_r("email sent", true));
    //   fclose($myfile);
    // }
    // else {
    //   $myfile = fopen("sendEmailDebug.txt", "w") or die("Unable to open file!");
    //   fwrite($myfile,print_r("email fail to send", true));
    //   fclose($myfile);
    // }

  }

  $page = "projects";
  session_start();

  $success_alert = $fail_alert = "";

  date_default_timezone_set("Asia/Kuala_Lumpur");

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  // get project details
  if (!empty($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $url = "project.php?project_id=" . $project_id;

    $query = "SELECT * FROM project p, user u 
              WHERE project_id = '$project_id' 
              AND p.cust_id = u.user_id";
    
    if ($result = mysqli_query($dbc, $query)) {
      $row = mysqli_fetch_assoc($result);

      // project information
      $created_datetime = $row['created_datetime'];
      $last_modified_datetime = $row['last_modified_datetime'];
      $consultation_id = $row['consultation_id'];
      $admin_id = $row['admin_id'];

      // project details
      $project_name = $row['project_name'];
      $project_status = $row['project_status'];
      $project_contract = $row['project_contract'];
      $project_remark = $row['project_remark'];
      $project_details = $row['project_details'];

      // payment details
      $project_fee= $row['project_fee'];
      $payment_status = $row['payment_status'];
      $payment_datetime = json_decode($row['payment_datetime']);

      // customer details
      $cust_id = $row['cust_id'];
      $cust_name = $row['name'];
      $cust_email = $row['email'];
      $cust_phone_no = $row['phone_no'];

    }
    else {
      $fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
    }

    if ($_SESSION['admin_position'] == "Project Leader" && $admin_id != $_SESSION['admin_id'])
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

    // get payment settings
    $query = 'SELECT * FROM settings';
    
    if ($result = mysqli_query($dbc, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        switch ($row['settings_name']) {
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
      echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
    }
  }
  else {
    header("Location: error_404.php");
  }

  // update payment status from ajax request
  if (isset($_POST['project_id']) && isset($_POST['payment_status'])) {
    $project_id = $_POST['project_id'];
    $payment_status = $_POST['payment_status'];
    $payment_datetime_encode = json_encode($payment_datetime);
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));
    
    if (strpos($payment_status, "Done")) {
      if ($payment_status == "1st Payment Done")
        $payment_datetime->{'1'} = date("Y-m-d H:i:s", strtotime("now"));
      if ($payment_status == "2nd Payment Done")
        $payment_datetime->{'2'} = date("Y-m-d H:i:s", strtotime("now"));
      if ($payment_status == "3rd Payment Done")
        $payment_datetime->{'3'} = date("Y-m-d H:i:s", strtotime("now"));
      $payment_datetime_encode = json_encode($payment_datetime);
    }

    $query = "UPDATE project SET 
              last_modified_datetime = '$last_modified_datetime', 
              payment_status = '$payment_status',
              payment_datetime = '$payment_datetime_encode' 
              WHERE project_id = '$project_id'";

    if (mysqli_query($dbc, $query)) {
      echo true;
    }
    else {
      echo false;
    }
    exit();
  }

  // update project status for ajax request
  if (isset($_POST['project_id']) && isset($_POST['project_status']) && isset($_POST['cust_name']) && isset($_POST['cust_email'])) {
    $project_id = $_POST['project_id'];
    $project_status = $_POST['project_status'];
    $cust_name = $_POST['cust_name'];
    $cust_email = $_POST['cust_email'];
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));

    $query = "UPDATE project SET 
              last_modified_datetime = '$last_modified_datetime', 
              project_status = '$project_status' 
              WHERE project_id = '$project_id'";

    if (mysqli_query($dbc, $query)) {
      echo true;

      if ($project_status == "Completed")
        sendFeedbackEmail($cust_id, $cust_name, $cust_email, $project_id);
    }
    else {
      echo false;
    }
    
    exit();
  }

  // update project details
  if (isset($_POST['updated'])) {

    if (isset($_POST['project_status']))
      $project_status = $_POST['project_status'];

    $admin_id = $_POST['admin_id'];
    $project_name = $_POST['project_name'];
    
    $project_remark = $_POST['project_remark'];
    $project_details = $_POST['project_details'];
    $project_fee = $_POST['project_fee'];
    $payment_status = $_POST['payment_status'];
    $payment_datetime_encode = json_encode($payment_datetime);
    $last_modified_datetime = date("Y-m-d H:i:s", strtotime("now"));
    
    // payment datetime
    if (strpos($payment_status, "Done")) {
      if ($payment_status == "1st Payment Done")
        $payment_datetime->{'1'} = date("Y-m-d H:i:s", strtotime("now"));
      if ($payment_status == "2nd Payment Done")
        $payment_datetime->{'2'} = date("Y-m-d H:i:s", strtotime("now"));
      if ($payment_status == "3rd Payment Done")
        $payment_datetime->{'3'} = date("Y-m-d H:i:s", strtotime("now"));
      $payment_datetime_encode = json_encode($payment_datetime);
    }

    // upload contract
    if (!empty($_FILES['project_contract']['name'])) {
      $contract = $_FILES['project_contract'];
      $contract_name = $contract['name'];
      $target = "assets/file/contract/".basename($contract_name); 
      move_uploaded_file($contract['tmp_name'], $target);
      $project_contract = $contract_name;

      $project_status = "Waiting for Admin Approval (Contract)";
    }

    // update database
		$query = "UPDATE project SET 
              last_modified_datetime = '$last_modified_datetime', 
              project_name = '$project_name', 
              project_status = '$project_status', 
              project_contract = '$project_contract', 
              project_remark = '$project_remark', 
              project_details = '$project_details', 
              project_fee = '$project_fee', 
              payment_status = '$payment_status', 
              payment_datetime = '$payment_datetime_encode', 
              admin_id = '$admin_id' 
              WHERE project_id = '$project_id'";

    if (mysqli_query($dbc, $query)) {
      if ($project_status == "Completed") 
        sendFeedbackEmail($cust_id, $cust_name, $cust_email, $project_id);

      $success_alert = "Project has been updated successfully.";
    }
    else {
      $fail_alert = "Could not update the project because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
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
            <h1>Project</h1>
          </div>

          <div class="section-body">
            <form action="<?php echo $url; ?>" method="post" enctype="multipart/form-data">
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
                      <a href="projects.php" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Close</a>
                      <input type="hidden" name="updated" value="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card">
                    <div class="card-header">
                      <h4>Project Information</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Project ID</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $project_id; ?>" disabled>
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
                        <label class="col-sm-3 col-form-label">Consultation ID</label>
                        <div class="col-sm-9">
                          <a href="consultation.php?consultation_id=<?php echo $consultation_id; ?>" target="_blank"><?php echo $consultation_id; ?></a>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Project Leader</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="admin_id">
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
                  <div class="card">
                    <div class="card-header">
                      <h4>Project Details</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Project Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="project_name" class="form-control" value="<?php echo $project_name; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Project Status</label>
                        <div class="col-sm-9">
                          <?php 
                            if ($project_status == "Waiting for Staff to Upload Contract") {
                              echo '<input type="text" name="project_status" class="form-control" value="'.$project_status.'" disabled>';
                            } 
                            else if ($project_status == "Waiting for Admin Approval (Contract)") {
                              echo '<input type="text" name="project_status" class="form-control" value="'.$project_status.'" disabled>';
                              echo '<div class="pt-2">
                                  <button class="btn btn-icon icon-left btn-success mr-2" onclick="updateProjectStatus('.$project_id.',\'Contract Approved\', '.$cust_name.', '.$cust_email.')"><i class="fas fa-check"></i> Approve</a> 
                                  <button class="btn btn-icon icon-left btn-danger" onclick="updateProjectStatus('.$project_id.',\'Waiting for Staff to Upload Contract\', '.$cust_name.', '.$cust_email.')"><i class="fas fa-times"></i> Reject</a>
                                </div>
                              ';
                            }
                            else {
                              echo '<select class="form-control" name="project_status">';

                              $project_status_arr = array("Contract Approved", "Waiting for Customer to Sign Contract", "Contract Signed",
                                                          "In Progress - Designing", "Release Design to Customer", 
                                                          "Waiting for Customer Review", "Design Revision",
                                                          "In Progress - Building", "Completed", "Cancelled");

                              foreach ($project_status_arr as $status) {
                                if ($status == $project_status)
                                  echo '<option value="'.$status.'" selected>'.$status.'</option>';
                                else 
                                  echo '<option value="'.$status.'">'.$status.'</option>';
                              }

                              echo '</select>';
                            }
                          ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Contract</label>
                        <div class="col-sm-3 d-flex align-items-center">
                          <a href="assets/file/contract/<?php echo $project_contract; ?>" target="_blank"><?php echo $project_contract; ?></a>
                        </div>
                        <div class="col-sm-5 custom-file ml-4">
                          <input type="file" name="project_contract" class="custom-file-input" id="project_contract" accept=".pdf" onchange="changeFileLabel(this.id)">
                          <label class="custom-file-label" for="project_contract">Choose file</label>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Remark</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_remark" cols="30" rows="10"><?php echo $project_remark; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Details</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_details" cols="30" rows="10" style="min-height: 450px"><?php echo $project_details; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="card">
                    <div class="card-header">
                      <h4>Payment Details</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Project Fee</label>
                        <div class="col-sm-9">
                          <input type="number" name="project_fee" class="form-control" value="<?php echo $project_fee; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Payment Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="payment_status">
                              <option value="Waiting for 1st Payment" <?php echo ($payment_status == "Waiting for 1st Payment") ? "selected" : ""; ?>>Waiting for 1st Payment (<?php echo $first_payment; ?>%)</option>
                              <option value="1st Payment Done" <?php echo ($payment_status == "1st Payment Done") ? "selected" : ""; ?>>1st Payment Done</option>
                              <option value="Waiting for 2nd Payment" <?php echo ($payment_status == "Waiting for 2nd Payment") ? "selected" : ""; ?>>Waiting for 2nd Payment (<?php echo $second_payment; ?>%)</option>
                              <option value="2nd Payment Done" <?php echo ($payment_status == "2nd Payment Done") ? "selected" : ""; ?>>2nd Payment Done</option>
                              <option value="Waiting for 3rd Payment" <?php echo ($payment_status == "Waiting for 3rd Payment") ? "selected" : ""; ?>>Waiting for 3rd Payment (<?php echo $third_payment; ?>%)</option>
                              <option value="3rd Payment Done" <?php echo ($payment_status == "3rd Payment Done") ? "selected" : ""; ?>>3rd Payment Done</option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">1st Payment Datetime</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $payment_datetime->{'1'}; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">2nd Payment Datetime</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $payment_datetime->{'2'}; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">3rd Payment Datetime</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="<?php echo $payment_datetime->{'3'}; ?>" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h4>Customer Details</h4>
                    </div>
                    <div class="card-body">
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
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script>
    function changeFileLabel(id) {
			var label = document.querySelector('label[for="' + id + '"]');
			label.textContent = document.getElementById(id).files.item(0).name;
		}

    function updateProjectStatus(project_id, project_status, cust_name, cust_email) {
      $.ajax({
        type: 'post',
        url: 'project.php',
        data: {
          project_id: project_id, 
          project_status: project_status,
          cust_name: cust_name,
          cust_email: cust_email
        }
      });
    }
  </script>

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
