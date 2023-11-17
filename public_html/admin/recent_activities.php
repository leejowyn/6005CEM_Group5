<?php

  function getActivitiesArray($activities, $type, $result) {
    $created_datetime = $last_modified_datetime = $datetime = $action = $payment_status = "";
    
    while ($row = mysqli_fetch_array($result)) {
      if ($type == "consultation" || $type == "project") {
        $created_datetime = (!empty($row['created_datetime'])) ? $row['created_datetime'] : "";
        $last_modified_datetime = (!empty($row['last_modified_datetime'])) ? $row['last_modified_datetime'] : "";

        if ($created_datetime == $last_modified_datetime) {
          $datetime = $created_datetime;
          $action = "create";
        }
        else {
          $datetime = $last_modified_datetime;
          $action = "update";
        }
      }
      else if ($type == "payment") {
        if (!empty($row['payment_datetime'])) {
          $payment = json_decode($row['payment_datetime']);

          if (!empty($payment->{'1'})) {
            $payment_status = "1st Payment";
            $datetime = $payment->{'1'};
          }
          if (!empty($payment->{'2'})) {
            $payment_status = "2nd Payment";
            $datetime = $payment->{'2'};
          }
          if (!empty($payment->{'3'})) {
            $payment_status = "3rd Payment";
            $datetime = $payment->{'3'};
          }
            
        }
      }
      else if ($type == "feedback") {
        $datetime = (!empty($row['feedback_date'])) ? $row['feedback_date'] : "";
      }

      $activity = array(
        "consultation_id" => (!empty($row['consultation_id'])) ? $row['consultation_id'] : "",
        "project_id" => (!empty($row['project_id'])) ? $row['project_id'] : "",
        "feedback_id" => (!empty($row['feedback_id'])) ? $row['feedback_id'] : "",
        "project_name" => (!empty($row['project_name'])) ? $row['project_name'] : "",
        "admin_name" => (!empty($row['admin_name'])) ? $row['admin_name'] : "",
        "cust_name" => (!empty($row['cust_name'])) ? $row['cust_name'] : "",
        "action" => $action,
        "type" => $type,
        "consultation_datetime" => (!empty($row['consultation_date']) && !empty($row['consultation_time'])) ? date("d M Y", strtotime($row['consultation_date'])) . ", " . date("g:i a", strtotime($row['consultation_time'])) : "",
        "payment_status" => $payment_status
      );
      $activities[$datetime] = $activity;

      if ($action == "update") {
        $datetime = (!empty($row['created_datetime'])) ? $row['created_datetime'] : "";
        $activity = array(
          "consultation_id" => (!empty($row['consultation_id'])) ? $row['consultation_id'] : "",
          "project_id" => (!empty($row['project_id'])) ? $row['project_id'] : "",
          "feedback_id" => (!empty($row['feedback_id'])) ? $row['feedback_id'] : "",
          "project_name" => (!empty($row['project_name'])) ? $row['project_name'] : "",
          "admin_name" => (!empty($row['admin_name'])) ? $row['admin_name'] : "",
          "cust_name" => (!empty($row['cust_name'])) ? $row['cust_name'] : "",
          "action" => "create",
          "type" => $type,
          "consultation_datetime" => (!empty($row['consultation_date']) && !empty($row['consultation_time'])) ? date("d M Y", strtotime($row['consultation_date'])) . ", " . date("g:i a", strtotime($row['consultation_time'])) : "",
          "payment_status" => $payment_status
        );
      }
      $activities[$datetime] = $activity;

    }

    return $activities;
  }

  function get_time_ago( $time ) {
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
  }

  $page = "recent_activities";
  $managerAccessOnly = true;

  session_start();
  date_default_timezone_set("Asia/Kuala_Lumpur");

  $activities = array();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  // select from consultation table
	$query = 'SELECT c.consultation_id, c.created_datetime, c.last_modified_datetime, c.consultation_date, c.consultation_time, 
            uc.name as cust_name, ua.name as admin_name 
            FROM consultation c, user ua, user uc 
            WHERE c.cust_id = uc.user_id 
            AND c.admin_id = ua.user_id';
	if (!$r = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}
  $activities = getActivitiesArray($activities, "consultation", $r);

  // select from project table
  $query = 'SELECT p.project_id, p.project_name, p.created_datetime, p.last_modified_datetime, 
            u.name as admin_name
            FROM project p, user u 
            WHERE p.admin_id = u.user_id';
	if (!$r = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}
  $activities = getActivitiesArray($activities, "project", $r);

  // select payment from project table
  $query = 'SELECT p.project_id, p.project_name, p.payment_datetime, 
            u.name as cust_name 
            FROM project p, user u 
            WHERE p.cust_id = u.user_id';
	if (!$r = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}
  $activities = getActivitiesArray($activities, "payment", $r);

  // select from feedback table
  $query = 'SELECT f.*, p.project_name, u.name as cust_name 
            FROM feedback f, project p, user u 
            WHERE f.project_id = p.project_id 
            AND p.cust_id = u.user_id';
	if (!$r = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}
  $activities = getActivitiesArray($activities, "feedback", $r);

  krsort($activities);

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
            <h1>Recent Activities</h1>
          </div>
          <div class="section-body">
            <!-- <h2 class="section-title">September 2022</h2> -->
            <div class="row">
              <div class="col-12">
                <div class="activities">
                  <?php foreach ($activities as $datetime => $details): ?>
                  <?php
                      $time_ago = get_time_ago(strtotime($datetime));

                      switch ($details['type']) {
                        case 'consultation':
                          $url = "consultation.php?consultation_id=" . $details['consultation_id'];
                          $icon = '<i class="fas fa-comments"></i>';

                          if ($details['action'] == "create") {
                            $bg = "bg-success";
                            $activity = sprintf('<span class="text-primary">%s</span> has made appointment for consultation on <span class="text-primary">%s</span>.', $details['cust_name'], $details['consultation_datetime']);
                          }
                          else if ($details['action'] == "update") {
                            $bg = "bg-primary";
                            $activity = sprintf('<span class="text-primary">%s</span> has updated the details for consultation <span class="text-primary">#%d</span>.', $details['admin_name'], $details['consultation_id']);
                          }
                          break;

                        case 'project':
                          $url = "project.php?project_id=" . $details['project_id'];
                          $icon = '<i class="fas fa-clipboard-list"></i>';

                          if ($details['action'] == "create") {
                            $bg = "bg-success";
                            $activity = sprintf('A new project <span class="text-primary">%s</span> has been confirmed by <span class="text-primary">%s</span>.', $details['project_name'], $details['admin_name']);
                          }
                          else if ($details['action'] == "update") {
                            $bg = "bg-primary";
                            $activity = sprintf('The details of project <span class="text-primary">%s</span> has been updated.', $details['project_name']);
                          }
                          break;

                        case 'payment':
                          $url = "project.php?project_id=" . $details['project_id'];
                          $icon = '<i class="fas fa-dollar-sign"></i>';
                          $bg = "bg-warning";

                          $activity = sprintf('<span class="text-primary">%s</span> has made <span class="text-primary">%s</span> for project <span class="text-primary">%s</span>.', $details['cust_name'], $details['payment_status'], $details['project_name']);
                          break;

                        case 'feedback':
                          $url = "feedback.php?feedback_id=" . $details['feedback_id'];
                          $icon = '<i class="fas fa-comment-dots"></i>';
                          $bg = "bg-primary";
                          
                          $activity = sprintf('<span class="text-primary">%s</span> has gave a feedback for project <span class="text-primary">%s</span>.', $details['cust_name'], $details['project_name']);
                          break;
                        
                        default:
                          
                          break;
                      }
                  ?>
                  <div class="activity">
                    <div class="activity-icon <?php echo $bg; ?> text-white shadow-primary">
                      <?php echo $icon; ?> 
                    </div>
                    <div class="activity-detail">
                      <div class="mb-2">
                        <span class="text-job text-primary"><?php echo $time_ago; ?></span>
                        <span class="bullet"></span>
                        <a class="text-job" href="<?php echo $url; ?>" target="_blank">View</a>
                      </div>
                      <p><?php echo $activity; ?></p>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
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

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>