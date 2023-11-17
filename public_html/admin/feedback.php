<?php
  $page = "feedbacks";
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  if (!empty($_GET['feedback_id'])) {
		$feedback_id = $_GET['feedback_id'];
		$url = "feedback.php?feedback_id=" . $feedback_id;

		$query = 'SELECT f.*, p.admin_id, u.* FROM feedback f, project p, user u 
              WHERE f.project_id = p.project_id 
              AND f.cust_id = u.user_id 
              AND feedback_id = ' . $feedback_id;
		
		if ($result = mysqli_query($dbc, $query)) {
			$feedback = mysqli_fetch_assoc($result);
      $admin_id = $feedback['admin_id'];
		}
		else {
			$fail_alert = '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
		}

    if ($_SESSION['admin_position'] != "Project Manager" && $admin_id != $_SESSION['admin_id'])
      header("Location: error_403.php");
	}
	else {
		header("Location: error_404.php");
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
        <?php include("navbar.php"); ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Feedback</h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header" style="min-height:0px;">
                <a href="feedbacks.php" class="btn btn-icon icon-left btn-danger"><i class="fas fa-times"></i> Close</a>
              </div>
            </div>
          
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Feedback Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['feedback_id'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Date</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['feedback_date'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Project ID</label>
                      <div class="col-sm-9">
                        <a href="project.php?project_id=<?php echo $feedback['project_id']; ?>" target="_blank"><?php echo $feedback['project_id']; ?></a>
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
                          <input type="text" class="form-control" value="<?php echo $feedback['name']; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer E-mail</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" value="<?php echo $feedback['email']; ?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Customer Contact</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" value="<?php echo $feedback['phone_no']; ?>" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Feedback Details</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Expectation</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['expectation'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Work Again</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['workAgn'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Comparison</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['compare'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Communication</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['communication'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Explanation</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['explanation'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Goal</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?php echo $feedback['goal'];?>" disabled>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Comment</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" name="project_remark" cols="30" rows="10" disabled><?php echo $feedback['comment'];?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Additional Comment</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" name="project_remark" cols="30" rows="10" disabled><?php echo $feedback['comment2'];?></textarea>
                      </div>
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
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>