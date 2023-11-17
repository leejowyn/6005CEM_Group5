<?php
  $page = "projects";
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  // get all project record
  if ($_SESSION['admin_position'] == "Project Manager") {
    $query = 'SELECT p.*, uc.name as cust_name, uc.email as cust_email, ua.name as admin_name 
              FROM project p, user uc, user ua  
              WHERE p.cust_id = uc.user_id 
              AND p.admin_id = ua.user_id';
  }
  else {
    $query = 'SELECT p.*, uc.name as cust_name, uc.email as cust_email, ua.name as admin_name 
              FROM project p, user uc, user ua  
              WHERE p.cust_id = uc.user_id 
              AND p.admin_id = ua.user_id 
              AND p.admin_id = ' . $_SESSION['admin_id'];
  }

	if (!$projects = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
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
  <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

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
            <h1>Projects</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="projects_table">
                          <thead>                                 
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Fee (RM)</th>
                                <th style="width:23%">Remark</th>
                                <th>Contract</th>
                                <th style="width:17%">Project Status</th>
                                <th style="width:17%">Payment Status</th>
                                <th>Consultation ID</th>
                                <th>Customer</th>
                                <th>Project Leader</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <?php while ($row = mysqli_fetch_array($projects)): ?>
                            <tr>                              
                                <td><a href="project.php?project_id=<?php echo $row['project_id']; ?>"><?php echo $row['project_id']; ?></a></td>
                                <td><?php echo $row['project_name']; ?></td>
                                <td><?php echo number_format($row['project_fee']); ?></td>
                                <td><?php echo $row['project_remark']; ?></td>
                                <td><a href="assets/file/contract/<?php echo $row['project_contract']; ?>" target="_blank"><?php echo $row['project_contract']; ?></a></td>
                                <td id="project_status_<?php echo $row['project_id']; ?>">
                                  <?php 
                                    if ($row['project_status'] == "Waiting for Staff to Upload Contract") {
                                        echo $row['project_status'];
                                    } 
                                    else if ($row['project_status'] == "Waiting for Admin Approval (Contract)") {
                                      echo $row['project_status'];

                                      if ($logged_in_admin_position == "Project Manager") {
                                        echo '<div class="pt-2" id="project_status_approval_'.$row['project_id'].'">
                                            <button class="btn btn-icon icon-left btn-success mr-2" onclick="updateProjectStatus('.$row['project_id'].',\'Contract Approved\', \''.$row['cust_name'].'\', \''.$row['cust_email'].'\')"><i class="fas fa-check"></i> Approve</a> 
                                            <button class="btn btn-icon icon-left btn-danger" onclick="updateProjectStatus('.$row['project_id'].',\'Waiting for Staff to Upload Contract\', \''.$row['cust_name'].'\', \''.$row['cust_email'].'\')"><i class="fas fa-times"></i> Reject</a>
                                          </div>
                                        ';
                                      }
                                    }
                                    else {
                                      echo '<select class="form-control" onchange="updateProjectStatus('.$row['project_id'].',this.value, \''.$row['cust_name'].'\', \''.$row['cust_email'].'\')">';

                                      $project_status_arr = array("Contract Approved", "Waiting for Customer to Sign Contract", "Contract Signed",
                                                                  "In Progress - Designing", "Release Design to Customer", 
                                                                  "Waiting for Customer Review", "Design Revision",
                                                                  "In Progress - Building", "Completed", "Cancelled");

                                      foreach ($project_status_arr as $project_status) {
                                        if ($project_status == $row['project_status'])
                                          echo '<option value="'.$project_status.'" selected>'.$project_status.'</option>';
                                        else 
                                          echo '<option value="'.$project_status.'">'.$project_status.'</option>';
                                      }

                                      echo '</select>';
                                    }
                                  ?>
                                </td>
                                <td>
                                  <select class="form-control" onchange="updatePaymentStatus(<?php echo $row['project_id']; ?>,this.value)">
                                    <option value="Waiting for 1st Payment" <?php echo ($row['payment_status'] == "Waiting for 1st Payment") ? "selected" : ""; ?>>Waiting for 1st Payment (<?php echo $first_payment; ?>%)</option>
                                    <option value="1st Payment Done" <?php echo ($row['payment_status'] == "1st Payment Done") ? "selected" : ""; ?>>1st Payment Done</option>
                                    <option value="Waiting for 2nd Payment" <?php echo ($row['payment_status'] == "Waiting for 2nd Payment") ? "selected" : ""; ?>>Waiting for 2nd Payment (<?php echo $second_payment; ?>%)</option>
                                    <option value="2nd Payment Done" <?php echo ($row['payment_status'] == "2nd Payment Done") ? "selected" : ""; ?>>2nd Payment Done</option>
                                    <option value="Waiting for 3rd Payment" <?php echo ($row['payment_status'] == "Waiting for 3rd Payment") ? "selected" : ""; ?>>Waiting for 3rd Payment (<?php echo $third_payment; ?>%)</option>
                                    <option value="3rd Payment Done" <?php echo ($row['payment_status'] == "3rd Payment Done") ? "selected" : ""; ?>>3rd Payment Done</option>
                                  </select>
                                </td>
                                <td><a href="consultation.php?consultation_id=<?php echo $row['consultation_id']; ?>" target="_blank"><?php echo $row['consultation_id']; ?></a></td>
                                <td><?php echo $row['cust_name']; ?></td>
                                <td><?php echo $row['admin_name']; ?></td>
                            </tr> 
                            <?php endwhile; ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script>
    function updatePaymentStatus(project_id, payment_status) {
      $.ajax({
        type: 'post',
        url: 'project.php?project_id=' + project_id,
        data: {
          project_id: project_id, 
          payment_status: payment_status
        },
        success: function(result) {
          console.log(result);
          if (result == 1) {
            swal(
              'Successful', 
              'Payment status of project #' + project_id + ' has been successfully updated.', 
              'success'
            );
          }
          else {
            swal(
              'Oops!', 
              'Something went wrong. Fail to update payment status of project.', 
              'error'
            );
          }
        }
      });
    }

    function updateProjectStatus(project_id, project_status, cust_name, cust_email) {
      $.ajax({
        type: 'post',
        url: 'project.php?project_id=' + project_id,
        data: {
          project_id: project_id, 
          project_status: project_status,
          cust_name: cust_name,
          cust_email: cust_email
        },
        success: function(result) {
          console.log("result: " + result);
          if (result == 1) {
            swal(
              'Successful', 
              'Status of project #' + project_id + ' has been successfully updated.', 
              'success'
            );

            document.getElementById("project_status_" + project_id).innerHTML = project_status;
          }
          else {
            swal(
              'Oops!', 
              'Something went wrong. Fail to update status of project.', 
              'error'
            );
          }
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
  <script src="assets/modules/datatables/datatables.min.js"></script>
  <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
  <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="assets/modules/sweetalert/sweetalert.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  <script src="assets/js/page/modules-datatables.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>