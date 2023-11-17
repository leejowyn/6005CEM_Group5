<?php
  $page = "consultations";
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  if ($_SESSION['admin_position'] == "Project Manager") {
    $query = "SELECT c.*, u.name as cust_name 
              FROM consultation c, user u 
              WHERE c.cust_id = u.user_id ";
  }
  else {
    $query = "SELECT c.*, u.name as cust_name 
              FROM consultation c, user u 
              WHERE c.cust_id = u.user_id 
              AND c.admin_id = " . $_SESSION['admin_id'];
  }

	if (!$consultations = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}

  $query = 'SELECT user_id, name FROM user WHERE access_level = "Project Leader"';

	if ($staffs_result = mysqli_query($dbc, $query)) {
    $staffs = array();
    while ($staff = mysqli_fetch_array($staffs_result)) {
      $staffs[$staff['user_id']] = $staff['name'];
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
            <h1>Consultations</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                <!-- <div class="card-header p-1">
                    <a href="consultation.php" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> Add</a>
                  </div> -->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="consultations_table">
                          <thead>                                 
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Datetime</th>
                                <th>Preferred Style</th>
                                <th>Design Range</th>
                                <th>Remark</th>
                                <th style="width:14%">Status</th>
                                <th>Customer</th>
                                <th style="width:14%">Product Leader</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <?php while ($row = mysqli_fetch_array($consultations)): ?>
                            <tr>                              
                                <td><a href="consultation.php?consultation_id=<?php echo $row['consultation_id']; ?>"><?php echo $row['consultation_id']; ?></a></td>
                                <td><?php echo $row['consultation_type']; ?></td>
                                <td><?php echo date("d M Y", strtotime($row['consultation_date'])); ?>, <?php echo date("g:i a", strtotime($row['consultation_time'])); ?></td>
                                <td><?php echo str_replace(",", ", ", $row['preferred_style']); ?></th>
                                <td><?php echo $row['design_range']; ?></td>
                                <td><?php echo $row['consultation_remark']; ?></td>
                                <td id="consultation_status_<?php echo $row['consultation_id']; ?>">
                                <?php if ($row['consultation_status'] == "Project Confirmed"): ?>
                                <?php echo $row['consultation_status']; ?>
                                <?php else: ?>
                                    <select class="form-control" onchange="updateStatus(<?php echo $row['consultation_id']; ?>,this.value)">
                                        <option value="Pending" <?php echo ($row['consultation_status'] == "Pending") ? "selected" : ""; ?>>Pending</option>
                                        <option value="Done" <?php echo ($row['consultation_status'] == "Done") ? "selected" : ""; ?>>Done</option>
                                        <option value="Project Confirmed" <?php echo ($row['consultation_status'] == "Project Confirmed") ? "selected" : ""; ?>>Project Confirmed</option>
                                        <option value="Cancelled" <?php echo ($row['consultation_status'] == "Cancelled") ? "selected" : ""; ?>>Cancelled</option>
                                    </select>
                                <?php endif; ?>
                                </td>
                                <td><?php echo $row['cust_name']; ?></td>
                                <td id="project_leader_<?php echo $row['consultation_id']; ?>">
                                    <?php 
                                      if (empty($row['admin_id'])) {
                                        echo '<select class="form-control" onchange="updateStaff('.$row['consultation_id'].',this.value)">';
                                        echo '<option value="" selected disabled>Select Staff</option>';
                                        foreach ($staffs as $staff_id => $staff_name) {
                                          echo '<option value="'.$staff_id.'">'.$staff_name.'</option>';
                                        }
                                        echo '</select>';
                                      }
                                      else {
                                        echo $staffs[$row['admin_id']];
                                        // $dbc = mysqli_connect('localhost', 'root', '');
                                        // mysqli_select_db($dbc, 'in_haus');
                                      
                                        // $query = "SELECT admin_name FROM admin WHERE admin_id = " . $row['admin_id'] . "";
                                      
                                        // if ($admin_name = mysqli_query($dbc, $query)) {
                                        //   $row = mysqli_fetch_assoc($admin_name);
			                                  //   $admin_name = $row['admin_name'];
                                        //   echo $admin_name;
                                        // }
                                        // else {
                                        //   echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
                                        // }
                                        // mysqli_close($dbc);
                                      }
                                    ?>
                                </td>
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
    function updateStaff(consultation_id, admin_id) {
      $.ajax({
        type: 'post',
        url: 'consultation.php',
        data: {
          consultation_id: consultation_id, 
          admin_id: admin_id
        },
        success: function(result) {
          console.log(result);
          if (result == 1) {
            swal(
              'Successful', 
              'Project leader of consultation #' + consultation_id + ' has been successfully updated.', 
              'success'
            );
            var staff = <?php echo json_encode($staffs); ?>;
            document.getElementById("project_leader_" + consultation_id).innerHTML = staff[admin_id];
          }
          else {
            swal(
              'Oops!', 
              'Something went wrong. Fail to update project leader of consultation.', 
              'error'
            );
          }
        }
      });
    }

    function updateStatus(consultation_id, consultation_status) {
      $.ajax({
        type: 'post',
        url: 'consultation.php?consultation_id=' + consultation_id,
        data: {
          consultation_id: consultation_id, 
          consultation_status: consultation_status
        },
        success: function(result) {
          console.log(result);
          result = JSON.parse(result);
          
          if (result.success == 1) {
            swal(
              'Successful', 
              'Status of consultation #' + consultation_id + ' has been successfully updated.', 
              'success'
            ).then(function() {
              if (consultation_status == "Project Confirmed")
                window.location = "project.php?project_id=" + result.insert_id;
            });
            if (consultation_status == "Project Confirmed") {
              document.getElementById("consultation_status_" + consultation_id).innerHTML = consultation_status;
            }
          }
          else {
            swal(
              'Oops!', 
              'Something went wrong. Fail to update consultation status.', 
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