<?php
  include 'permissions.php';

  $page = "users";
  session_start();

  if (!hasPermission($_SESSION['admin_position'], 'view_user'))
    redirect403();

	$dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

	$query = "SELECT * FROM user";

	if (!$r = mysqli_query($dbc, $query)) {
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
        <?php include("navbar.php") ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header mb-0">
            <h1>Users</h1>
             <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="general_settings.php">Settings</a></div>
              <div class="breadcrumb-item">Users</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header p-1">
                    <a href="user_form.php" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> Add</a>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="users_table">
                          <thead>                                 
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Position</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <?php while ($row = mysqli_fetch_array($r)): ?>
                            <tr id="user-<?php echo $row['user_id']; ?>">                              
                                <td><a href="user_form.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $row['user_id']; ?></a></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <?php if ($row['access_level'] == "Admin"): ?>
                                <td><span class="badge badge-dark"><?php echo $row['access_level']; ?></span></td>
                                <?php elseif ($row['access_level'] == "Project Leader"): ?>
                                <td><span class="badge badge-secondary"><?php echo $row['access_level']; ?></span></td>
                                <?php elseif ($row['access_level'] == "Customer Service"): ?>
                                <td><span class="badge badge-primary"><?php echo $row['access_level']; ?></span></td>
                                <?php else: ?>
                                <td><span class="badge badge-light"><?php echo $row['access_level']; ?></span></td>
                                <?php endif; ?>

                                <td>
                                  <?php if ($row['access_level'] == "Project Leader" || $row['access_level'] == "Normal User"): ?>
                                    <button class="btn btn-danger" onclick="deleteUser(<?php echo $row['user_id']; ?>)">
                                      <i class="fas fa-trash"></i>
                                    </button>
                                  <?php endif; ?>
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
     function deleteUser(user_id) {
      Swal.fire({
        title: 'Are you sure you want to delete user #' + user_id + '?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it.',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'post',
            url: 'user_form.php?user_id=' + user_id,
            data: {
              user_id: user_id, 
              delete: 1
            },
            success: function(result) {
              console.log(result);
              result = JSON.parse(result);

              if (result.success == true) {
                Swal.fire(
                  'Successful', 
                  'User #' + user_id + ' has been successfully deleted.', 
                  'success'
                );
                document.getElementById('user-' + user_id).style.display = 'none';
              }
              else {
                Swal.fire(
                  'Oops!', 
                  'Something went wrong. Fail to delete user #' + user_id + '.', 
                  'error'
                );
              }
            }
          });
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  <script src="assets/js/page/modules-datatables.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>