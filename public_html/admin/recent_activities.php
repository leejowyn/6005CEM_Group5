<?php

function getActivitiesArray($activities, $result)
{
  while ($row = mysqli_fetch_array($result)) {
    $activities[$row['datetime']] = array(
      'event_type' => $row['event_type'],
      'user_id' => $row['user_id'],
      'datetime' => $row['datetime']
    );
  }
  return $activities;
}

function get_time_ago($time)
{
  $time_difference = time() - $time;

  if ($time_difference < 1) {
    return 'less than 1 second ago';
  }
  $condition = array(
    12 * 30 * 24 * 60 * 60 =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach ($condition as $secs => $str) {
    $d = $time_difference / $secs;

    if ($d >= 1) {
      $t = round($d);
      return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
    }
  }
}

$page = "recent_activities";
$managerAccessOnly = true;

session_start();
date_default_timezone_set("Asia/Singapore");

$activities = array();

$dbc = mysqli_connect('localhost', 'root', '');
mysqli_select_db($dbc, 'in_haus');

// Select from log_activity table
$query = 'SELECT * FROM log_activity';
if (!$r = mysqli_query($dbc, $query)) {
  echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
} else {
  // Perform other operations with the fetched data
  $activities = getActivitiesArray($activities, $r);
  krsort($activities);
}
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

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
</head>

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
            <div class="row">
              <button onclick="exportToCSV()" class="btn btn-primary mb-3">
                <i class="fas fa-download"></i> Export to CSV
              </button>

              <div class="col-12">
                <div class="activities">
                  <?php
                  $dbc = mysqli_connect('localhost', 'root', '');
                  mysqli_select_db($dbc, 'in_haus');

                  if (!empty($activities)) {
                    foreach ($activities as $datetime => $details) {
                      // Initialize variables within the loop
                      $url = "";
                      $icon = '<i class="fas fa-sign-in-alt"></i>';
                      $bg = "bg-info";
                      $activity = "";

                      switch ($details['event_type']) {
                        case 'login':
                          // Fetch user details from the 'user' table based on user_id
                          $user_id = $details['user_id'];
                          $user_query = "SELECT * FROM user WHERE user_id = {$user_id}";
                          $user_result = mysqli_query($dbc, $user_query);

                          if ($user_result && mysqli_num_rows($user_result) > 0) {
                            $user_data = mysqli_fetch_assoc($user_result);
                            $user_name = $user_data['name'];

                            // Regular user login
                            $activity = sprintf(
                              'User <span class="text-primary">%s</span> logged in at <span class="text-primary">%s</span>.',
                              $user_name,
                              date("d M Y, h:i A", strtotime($details['datetime']))
                            );
                          } else {
                            $activity = "Unknown user logged in";
                          }
                          break;
                        case 'admin_login':
                          // Fetch admin details based on user_id
                          $user_id = $details['user_id'];
                          $admin_query = "SELECT * FROM user WHERE user_id = {$user_id}";
                          $admin_result = mysqli_query($dbc, $admin_query);

                          if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                            $admin_data = mysqli_fetch_assoc($admin_result);
                            $admin_name = $admin_data['name'];

                            $bg = "bg-danger";
                            $icon = '<i class="fas fa-user-lock"></i>'; // Admin icon
                            $activity = sprintf(
                              'Admin <span class="text-primary">%s</span> logged in at <span class="text-primary">%s</span>.',
                              $admin_name,
                              date("d M Y, h:i A", strtotime($details['datetime']))
                            );
                          } else {
                            $activity = "Unknown admin logged in";
                          }
                          break;
                        case 'consultation':
                          // Fetch user details from the 'user' table based on user_id
                          $user_id = $details['user_id'];
                          $user_query = "SELECT * FROM user WHERE user_id = {$user_id}";
                          $user_result = mysqli_query($dbc, $user_query);

                          // get the consultation ID
                          $consultation_query = "SELECT consultation_id FROM log_activity WHERE event_type='consultation' AND user_id = {$details['user_id']}";
                          $consultation_result = mysqli_query($dbc, $consultation_query);
                          if ($consultation_result && mysqli_num_rows($consultation_result) > 0)
                            $consultation_data = mysqli_fetch_assoc($consultation_result);
                          $consultation_id = $consultation_data['consultation_id'];
                          $url = "consultation.php?consultation_id=" . $consultation_id;
                          // get the user name
                          if ($user_result && mysqli_num_rows($user_result) > 0) {
                            $user_data = mysqli_fetch_assoc($user_result);
                            $user_name = $user_data['name'];

                            // Customize display for consultation event
                            $bg = "bg-warning"; // Background for consultation event
                            $icon = '<i class="fas fa-file-alt"></i>'; // Icon for consultation event
                            $activity = sprintf(
                              '<span class="text-primary">%s</span> has submitted a consultation form at <span class="text-primary">%s</span>.',
                              $user_name,
                              date("d M Y, h:i A", strtotime($details['datetime']))
                            ); // Message for consultation event including user's name and time
                          } else {
                            $activity = "User has submitted a consultation form";
                          }
                          break;

                        default:
                          break;
                      }
                  ?>
                      <!-- Activity display -->
                      <div class="activity">
                        <div class="activity-icon <?php echo $bg; ?> text-white shadow-primary">
                          <?php echo $icon; ?>
                        </div>
                        <div class="activity-detail">
                          <div class="mb-2">
                            <span class="text-job text-primary"><?php echo get_time_ago(strtotime($datetime)); ?></span>
                            <span class="bullet"></span>
                            <a class="text-job" href="<?php echo $url; ?>" target="_blank">View</a>
                          </div>
                          <p><?php echo $activity; ?></p>
                        </div>
                      </div>
                  <?php } // End of foreach loop
                  } else {
                    // Handle case where $activities is empty
                    echo "No activities found.";
                  }
                  ?>

                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- Main Content end -->
      <!-- Footer and other content -->
    </div>
  </div>
  <script>
    function exportToCSV() {
      let csvContent = 'data:text/csv;charset=utf-8,';
      csvContent += 'Event Type,User,Date\n';

      <?php
      // Loop through activities to generate CSV content
      if (!empty($activities)) {
        foreach ($activities as $datetime => $details) {
          $event_type = $details['event_type'];
          $user_id = $details['user_id'];
          $event_date = date("d M Y, h:i A", strtotime($details['datetime']));

          // Fetch user details from the 'user' table based on user_id
          $user_query = "SELECT * FROM user WHERE user_id = {$user_id}";
          $user_result = mysqli_query($dbc, $user_query);
          if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $user_name = $user_data['name'];

            // Construct CSV row
            echo "csvContent += '$event_type,$user_name,$event_date\\n';";
          }
        }
      }
      ?>
      // Create link to initiate download
      const encodedUri = encodeURI(csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      link.setAttribute('download', 'activities.csv');
      document.body.appendChild(link);
      link.click();
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
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>