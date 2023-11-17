<?php
  $page = "feedbacks";
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  if ($_SESSION['admin_position'] == "Project Manager") {
    $query = "SELECT f.*, u.name FROM feedback f, user u 
              WHERE f.cust_id = u.user_id";
  }
  else {
    $query = "SELECT f.*, u.name FROM feedback f, user u, project p 
              WHERE f.cust_id = u.user_id 
              AND f.project_id = p.project_id 
              AND p.admin_id = " . $_SESSION['admin_id'];
  }

  $feedbacks = mysqli_query($dbc, $query);

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
            <h1>Feedbacks</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="staffs_table">
                          <thead>                                 
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Expectation</th>
                                <th>Work Again</th>
                                <th>Comparison</th>
                                <th>Communication</th>
                                <th>Explanation</th>
                                <th>Goal</th>
                                <th>Comment</th>
                                <th>Additional Comment</th>
                                <th>Project ID</th>
                                <th>Customer ID</th>
                            </tr>
                          </thead>
                          <tbody>  
                            <?php while ($feedback = mysqli_fetch_array($feedbacks)): ?>
                            <tr>                              
                                <td><a href="feedback.php?feedback_id=<?php echo $feedback['feedback_id']; ?>"><?php echo $feedback['feedback_id']; ?></a></td>
                                <td><?php echo $feedback['feedback_date']; ?></td>
                                <td><?php echo $feedback['expectation']; ?></td>
                                <td><?php echo $feedback['workAgn']; ?></td>
                                <td><?php echo $feedback['compare']; ?></td>
                                <td><?php echo $feedback['communication']; ?></td>
                                <td><?php echo $feedback['explanation']; ?></td>
                                <td><?php echo $feedback['goal']; ?></td>
                                <td><?php echo $feedback['comment']; ?></td>
                                <td><?php echo $feedback['comment2']; ?></td>
                                <td><a href="project.php?project_id=<?php echo $feedback['project_id']; ?>" target="_blank"><?php echo $feedback['project_id']; ?></a></td>
                                <td><?php echo $feedback['name']; ?></td>
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

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  <script src="assets/js/page/modules-datatables.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>