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

  function getChartData($year, $month) {

    $dbc = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($dbc, 'in_haus');
    
    if (empty($month)) {
      $query = "SELECT MONTH(created_datetime) AS month, SUM(project_fee) as sales 
                FROM project 
                WHERE YEAR(created_datetime) = '$year' 
                GROUP BY MONTH(created_datetime)";
    }
    else {
      $query = "SELECT DAY(created_datetime) AS day, SUM(project_fee) as sales 
                FROM project 
                WHERE MONTH(created_datetime) = '$month' 
                AND YEAR(created_datetime) = '$year' 
                GROUP BY DAY(created_datetime)";
    }

    $result = mysqli_query($dbc, $query);

    if (empty($month)) {
        $chartData = array_fill(1, 12, 0);
        $title = "Total Sales ($year)";

        while ($row = mysqli_fetch_array($result)) {
          if (!empty($result)) {
              $chartData[$row['month']] = $row['sales'];
          }
        }
        
    }
    else {
        $chartData = array_fill(1, 31, 0);
        $dateObj = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        $monthName = substr($monthName, 0, 3);
        $title = "Total Sales ($monthName $year)";

        while ($row = mysqli_fetch_array($result)) {
          if (!empty($result)) {
              $chartData[$row['day']] = $row['sales'];
          }
        }
        
    }
    $chartData_x_axis = implode(", ", array_keys($chartData));
    $chartData_y_axis = implode(", ", $chartData);

    mysqli_close($dbc);

    return array(
        "chart_title" => $title,
        "x_axis" => $chartData_x_axis, 
        "y_axis" => $chartData_y_axis
    );
  }

  $page = "dashboard";
  session_start();

  $dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

  date_default_timezone_set("Asia/Kuala_Lumpur");

  $sales = array();
  $project = array();
  $consultation = array();
  $activities = array();


  # SALES
  $last_month = date("m", strtotime("-1 month"));
  $this_month = date("m", strtotime("now"));
  $last_year = date("Y", strtotime("-1 year"));
  $this_year = date("Y", strtotime("now"));

  // Sales (Last Month)
  $result = mysqli_query($dbc, "SELECT SUM(project_fee) AS count FROM project 
                                WHERE MONTH(created_datetime) = '$last_month' AND YEAR(created_datetime) = '$this_year'");
  $row = mysqli_fetch_assoc($result);
  $sales['last_month'] = $row['count'];

  // Sales (This Month)
  $result = mysqli_query($dbc, "SELECT SUM(project_fee) AS count FROM project 
                                WHERE MONTH(created_datetime) = '$this_month' AND YEAR(created_datetime) = '$this_year'");
  $row = mysqli_fetch_assoc($result);
  $sales['this_month'] = $row['count'];

  // Sales (Last Year)
  $result = mysqli_query($dbc, "SELECT SUM(project_fee) AS count FROM project WHERE YEAR(created_datetime) = '$last_year'");
  $row = mysqli_fetch_assoc($result);
  $sales['last_year'] = $row['count'];

  // Sales (This Year)
  $result = mysqli_query($dbc, "SELECT SUM(project_fee) AS count FROM project WHERE YEAR(created_datetime) = '$this_year'");
  $row = mysqli_fetch_assoc($result);
  $sales['this_year'] = $row['count'];

  // Sales Improvement
  if (empty($sales['last_month'])) 
    $sales['improvement_this_month'] = " - ";
  else
    $sales['improvement_this_month'] = number_format((($sales['this_month'] - $sales['last_month']) / $sales['last_month'] * 100), 2);
  
  if (empty($sales['last_year']))
    $sales['improvement_this_year'] = " - ";
  else 
    $sales['improvement_this_year'] = number_format((($sales['this_year'] - $sales['last_year']) / $sales['last_year']) * 100, 2);


  # PROJECT
  // Total Pending Project (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM project 
                                WHERE project_status != 'Completed' 
                                AND project_status != 'Cancelled' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $project['pending'] = $row['count'];

  // Total Completed Project (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM project 
                                WHERE project_status = 'Completed' 
                                AND project_status != 'Cancelled' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $project['completed'] = $row['count'];

  // Total Project (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM project 
                                WHERE project_status != 'Cancelled' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $project['total'] = $row['count'];


  # CONSULTATION 
  // Total Pending Consultation (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM consultation 
                                WHERE consultation_status = 'Pending' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $consultation['pending'] = $row['count'];

  // Total Completed Consultation (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM consultation 
                                WHERE consultation_status = 'Done' 
                                OR consultation_status = 'Project Confirmed' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $consultation['completed'] = $row['count'];

  // Total Consultation (This Month)
  $result = mysqli_query($dbc, "SELECT COUNT(*) as count FROM consultation 
                                WHERE consultation_status != 'Cancelled' 
                                AND MONTH(created_datetime) = '$this_month'");
  $row = mysqli_fetch_assoc($result);
  $consultation['total'] = $row['count'];


  # DASHBOARD
  $this_month_chart_data = getChartData($this_year, $this_month);
  $last_month_chart_data = getChartData($this_year, $last_month);
  $this_year_chart_data = getChartData($this_year, "");
  $last_year_chart_data = getChartData($last_year, "");

  // $print['this_month_chart_data'] = $this_month_chart_data;
  // $print['last_month_chart_data'] = $last_month_chart_data;
  // $print['this_year_chart_data'] = $this_year_chart_data;
  // $print['last_year_chart_data'] = $last_year_chart_data;

  // echo '<pre>';
  // print_r($print);
  // echo '</pre>';


  # RECENT ACTIVITIES
  // select from consultation table
  $query = 'SELECT c.consultation_id, c.created_datetime, c.last_modified_datetime, c.consultation_date, c.consultation_time, 
            uc.name as cust_name, ua.name as admin_name 
            FROM consultation c, user ua, user uc 
            WHERE c.cust_id = uc.user_id 
            AND c.admin_id = ua.user_id';
  $result = mysqli_query($dbc, $query);
  $activities = getActivitiesArray($activities, "consultation", $result);

  // select from project table
  $query = 'SELECT p.project_id, p.project_name, p.created_datetime, p.last_modified_datetime, 
            u.name as admin_name
            FROM project p, user u 
            WHERE p.admin_id = u.user_id';
  $result = mysqli_query($dbc, $query);
  $activities = getActivitiesArray($activities, "project", $result);

  // select payment from project table
  $query = 'SELECT p.project_id, p.project_name, p.payment_datetime, 
            u.name as cust_name 
            FROM project p, user u 
            WHERE p.cust_id = u.user_id';
  $result = mysqli_query($dbc, $query);
  $activities = getActivitiesArray($activities, "payment", $result);

  // select from feedback table
  $query = 'SELECT f.*, p.project_name, u.name as cust_name 
            FROM feedback f, project p, user u 
            WHERE f.project_id = p.project_id 
            AND p.cust_id = u.user_id';
  $result = mysqli_query($dbc, $query);
  $activities = getActivitiesArray($activities, "feedback", $result);

  krsort($activities);
  $activities = array_slice($activities, 0, 5, true);


  # LATEST PROJECTS
  $query = "SELECT p.project_id, p.project_name, p.project_status, 
            u.name as admin_name 
            FROM project p, user u 
            WHERE p.admin_id = u.user_id 
            ORDER BY p.project_id DESC LIMIT 4";
  $projects = mysqli_query($dbc, $query);


  # LATEST CONSULTATIONS
  $query = "SELECT consultation_id, consultation_date, consultation_time, admin_id FROM consultation 
            ORDER BY consultation_id DESC LIMIT 5";
  $consultations = mysqli_query($dbc, $query);

  // get staff list
  $query = "SELECT user_id, name FROM user WHERE access_level = 'Project Leader'";
  $staffs_result = mysqli_query($dbc, $query);
  $staffs = array();
  while ($staff = mysqli_fetch_array($staffs_result)) {
    $staffs[$staff['user_id']] = $staff['name'];
  }


  # MOST VIEWED PORTFOLIO
  $query = "SELECT portfolio_id, portfolio_thumbnail, portfolio_style, portfolio_views FROM portfolio 
            ORDER BY portfolio_views DESC LIMIT 3";
  $portfolios = mysqli_query($dbc, $query);


  # FEEDBACK FROM CUSTOMERS

  $query = "SELECT COUNT(*) AS total FROM feedback";
  $result = mysqli_query($dbc, $query);
  $row = mysqli_fetch_assoc($result);
  $total_feedback = $row['total'];

  $query = "SELECT f.feedback_id, f.feedback_date, f.comment2, u.name FROM feedback f, user u 
            WHERE f.cust_id = u.user_id 
            ORDER BY f.feedback_id DESC LIMIT 3";
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
  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
   <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
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
      <?php include("navbar.php") ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <!-- Total Sales, Project, Consultations -->
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2" style="border-radius: 25px;">
                <div class="card-stats pt-4 pb-2">
                  <div class="card-stats-items d-flex justify-content-center">
                    <div class="card-stats-item" style="padding: 5px 0px">
                    <div class="card-stats-item-count">
                      <?php if (strpos($sales['improvement_this_month'], "-") === false): ?>
                      <span class="text-success">
                        <i class="fas fa-caret-up" style="font-size: 20px; padding-right: 5px;"></i>
                      </span>
                      <?php else: ?>
                      <span class="text-danger">
                        <i class="fas fa-caret-down" style="font-size: 20px; padding-right: 5px;"></i>
                      </span>
                      <?php endif; ?>
                      <?php echo $sales['improvement_this_month']; ?>%
                    </div>
                    <div class="card-stats-item-label">This Month</div>
                    </div>
                    <div class="card-stats-item" style="padding: 5px 0px">
                    <div class="card-stats-item-count">
                      <?php if (strpos($sales['improvement_this_year'], "-") === false): ?>
                      <span class="text-success">
                        <i class="fas fa-caret-up" style="font-size: 20px; padding-right: 5px;"></i>
                      </span>
                      <?php else: ?>
                      <span class="text-danger">
                        <i class="fas fa-caret-down" style="font-size: 20px; padding-right: 5px;"></i>
                      </span>
                      <?php endif; ?>
                      <?php echo $sales['improvement_this_year']; ?>%
                    </div>
                    <div class="card-stats-item-label">This Year</div>
                    </div>
                  </div>
                </div>
                <div class="card-icon shadow-primary bg-primary rounded-circle">
                  <i class="fas fa-dollar-sign" style="font-size: 16px;"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Sales (This Month)</h4>
                  </div>
                  <div class="card-body">
                    RM <?php echo number_format($sales['this_month'], 2); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2" style="border-radius: 25px;">
                <div class="card-stats pt-4 pb-2">
                  <div class="card-stats-items d-flex justify-content-center">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo $project['pending']; ?></div>
                      <div class="card-stats-item-label">Pending</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo $project['completed']; ?></div>
                      <div class="card-stats-item-label">Completed</div>
                    </div>
                  </div>
                </div>
                <div class="card-icon shadow-primary bg-primary rounded-circle">
                  <i class="fas fa-paint-roller" style="font-size: 16px;"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Projects (This Month)</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $project['total']; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2" style="border-radius: 25px;">
                <div class="card-stats pt-4 pb-2">
                  <div class="card-stats-items d-flex justify-content-center">
                    <div class="card-stats-item">
                    <div class="card-stats-item-count"><?php echo $consultation['pending']; ?></div>
                    <div class="card-stats-item-label">Pending</div>
                    </div>
                    <div class="card-stats-item">
                    <div class="card-stats-item-count"><?php echo $consultation['completed']; ?></div>
                    <div class="card-stats-item-label">Completed</div>
                    </div>
                  </div>
                </div>
                <div class="card-icon shadow-primary bg-primary rounded-circle">
                  <i class="fas fa-comments-dollar" style="font-size: 16px;"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Consultation (This Month)</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $consultation['total']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Chart & Recent Activities -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                <h4 id="chart_title">Total Sales (<?php echo $this_year; ?>)</h4>
                <div class="card-header-action dropdown">
                  <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Period</a>
                  <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right shadow">
                    <li class="dropdown-title">Select Period</li>
                    <li><a class="dropdown-item" onclick="showChart('month')">Month</a></li>
                    <li><a class="dropdown-item" onclick="showChart('year')">Year</a></li>
                  </ul>
                </div>
                </div>
                <div class="card-body">
                <canvas id="chart" height="158"></canvas>
                </div>
              </div>
			      </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recent Activities</h4>
                </div>
                <div class="card-body">             
                  <ul class="list-unstyled list-unstyled-border">
                    <?php foreach ($activities as $datetime => $details): ?>
                    <?php 
                      $time_ago = get_time_ago(strtotime($datetime));
                      $title = "";
                      
                      switch ($details['type']) {
                        case 'consultation':
                          $url = "consultation.php?consultation_id=" . $details['consultation_id'];
                          $icon = "fas fa-comments";

                          if ($details['action'] == "create") {
                            $bg = "bg-success";
                            $title = "New Consultation Made";
                            $activity = sprintf('%s has made appointment for consultation on %s.', $details['cust_name'], $details['consultation_datetime']);
                          }
                          else if ($details['action'] == "update") {
                            $bg = "bg-primary";
                            $title = "Consultation Details Updated";
                            $activity = sprintf('%s has updated the details for consultation #%d.', $details['admin_name'], $details['consultation_id']);
                          }
                          break;

                        case 'project':
                          $url = "project.php?project_id=" . $details['project_id'];
                          $icon = "fas fa-clipboard-list";

                          if ($details['action'] == "create") {
                            $bg = "bg-success";
                            $title = "New Project Confirmed";
                            $activity = sprintf('A new project %s has been confirmed by %s.', $details['project_name'], $details['admin_name']);
                          }
                          else if ($details['action'] == "update") {
                            $bg = "bg-primary";
                            $title = "Project Details Updated";
                            $activity = sprintf('The details of project %s has been updated.', $details['project_name']);
                          }
                          break;

                        case 'payment':
                          $url = "project.php?project_id=" . $details['project_id'];
                          $icon = "fas fa-dollar-sign";
                          $title = "Payment Made";
                          $bg = "bg-warning";

                          $activity = sprintf('%s has made %s for project %s.', $details['cust_name'], $details['payment_status'], $details['project_name']);
                          break;

                        case 'feedback':
                          $url = "feedback.php?feedback_id=" . $details['feedback_id'];
                          $icon = "fas fa-comment-dots";
                          $title = "New Feedback Received";
                          $bg = "bg-primary";
                          
                          $activity = sprintf('%s has gave a feedback for project %s.', $details['cust_name'], $details['project_name']);
                          break;
                        
                        default:
                          
                          break;
                      }
                    
                    ?>
                    <li class="media">
                      <div class="mr-3 rounded-circle <?php echo $bg; ?> d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                        <i class="<?php echo $icon; ?>" style="color: #fff; font-size: 16px;"></i>
                      </div>
                      <div class="media-body">
                        <div class="float-right text-primary"><?php echo $time_ago; ?></div>
                        <div class="media-title">
                          <a href="<?php echo $url; ?>" target="_blank">
                            <?php echo $title; ?>
                          </a>
                        </div>
                        <span class="text-small text-muted"><?php echo $activity; ?></span>
                      </div>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php if ($logged_in_admin_position == "Project Manager"): ?>
                  <div class="text-center pt-1 pb-1">
                    <a href="recent_activities.php" class="btn btn-primary btn-lg btn-round">
                      View All
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Latest Projects & Latest Consultations -->
          <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="d-inline">Latest Projects</h4>
                  <div class="card-header-action">
                  <a href="projects.php" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body">             
                  <ul class="list-unstyled list-unstyled-border">
                  <?php while ($project = mysqli_fetch_array($projects)): ?>
                  <?php
                      $badge_color = "badge-primary";
                      $bg = "bg-primary";
                      $icon = "";

                      if ($project['project_status'] == "In Progress - Designing" || 
                          $project['project_status'] == "Release Design to Customer" || 
                          $project['project_status'] == "Waiting for Customer Review" || 
                          $project['project_status'] == "Design Revision" || 
                          $project['project_status'] == "In Progress - Building")  {
                          $badge_color = "badge-warning";
                          $bg = "bg-warning";
                      }
                      if ($project['project_status'] == "Completed") {
                        $badge_color = "badge-success";
                        $bg = "bg-success";
                      }
                      if ($project['project_status'] == "Cancelled") {
                        $badge_color = "badge-danger";
                        $bg = "bg-danger";
                      }

                      if (strpos($project['project_status'], "Contract") !== false)
                        $icon = "fas fa-file-signature";
                      if (strpos($project['project_status'], "Design") !== false)
                        $icon = "fas fa-pencil-ruler";
                      if (strpos($project['project_status'], "Review") !== false)
                        $icon = "fas fa-comment-dots";
                      if (strpos($project['project_status'], "Building") !== false)
                        $icon = "fas fa-hammer";
                      if (strpos($project['project_status'], "Completed") !== false)
                        $icon = "fas fa-check";
                      if (strpos($project['project_status'], "Cancelled") !== false)
                        $icon = "fas fa-ban";

                      if (empty($project['project_name'])) $project['project_name'] = "N/A";
                  ?>
                  <li class="media">
                    <div class="mr-3 rounded-circle <?php echo $bg; ?> d-flex justify-content-center align-items-center" style="width:50px; height:50px;">
                      <i class="<?php echo $icon; ?>" style="color: #fff; font-size: 16px;"></i>
                    </div>
                    <div class="media-body">
                    <div class="badge badge-pill <?php echo $badge_color; ?> mb-1 float-right"><?php echo $project['project_status']; ?></div>
                    <h6 class="media-title"><a href="project.php?project_id=<?php echo $project['project_id']; ?>"><?php echo $project['project_name']; ?></a></h6>
                    <div class="text-small text-muted"><?php echo $project['admin_name']; ?>
                    </div>
                  </li>
                  <?php endwhile; ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Latest Consultations</h4>
                  <div class="card-header-action">
                  <a href="consultations.php" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Datetime</th>
                      <th>Staff</th>
                    </tr>
                    </thead>
                    <tbody>           
                      <?php while ($consultation = mysqli_fetch_array($consultations)): ?> 
                      <tr>
                        <td><a href="consultation.php?consultation_id=<?php echo $consultation['consultation_id']; ?>"><?php echo $consultation['consultation_id']; ?></a></td>
                        <td><?php echo date("d M Y", strtotime($consultation['consultation_date'])); ?>, <?php echo date("g:i a", strtotime($consultation['consultation_time'])); ?></td>
                        <td class="text-primary" id="project_leader_<?php echo $consultation['consultation_id']; ?>">
                          <?php 
                            if (empty($consultation['admin_id'])) {
                              echo '<select class="form-control" onchange="updateStaff('.$consultation['consultation_id'].',this.value)">';
                              echo '<option value="" selected disabled>Select Staff</option>';
                              foreach ($staffs as $staff_id => $staff_name) {
                                echo '<option value="'.$staff_id.'">'.$staff_name.'</option>';
                              }
                              echo '</select>';
                            }
                            else {
                              echo $staffs[$consultation['admin_id']];
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

          <!-- Most Viewed Portfolio & Customers need help -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header pb-5">
                  <h4>Most Viewed</h4>
                </div>
                <div class="card-body">
                  <div class="row pb-5">
                    <?php while ($portfolio = mysqli_fetch_array($portfolios)): ?>
                    <div class="col text-center">
                      <div class="gallery gallery-fw d-flex justify-content-center align-items-center" data-item-height="160">
                        <div class="gallery-item" data-image="assets/img/<?php echo $portfolio['portfolio_thumbnail']; ?>" data-title="" href="assets/img/<?php echo $portfolio['portfolio_thumbnail']; ?>" title="" style="width: 200px; height:160px; margin-right: 0; background-image: url(&quot;assets/img/<?php echo $portfolio['portfolio_thumbnail']; ?>&quot;);"></div>
                      </div>
                      <div class="mt-2 font-weight-bold"><a style="font-weight:700; color:var(--gray)" href="portfolio.php?portfolio_id=<?php echo $portfolio['portfolio_id']; ?>"><?php echo $portfolio['portfolio_style']; ?></a></div>
                      <div class="text-muted text-small"><?php echo number_format($portfolio['portfolio_views']); ?> views</div>
                    </div>
                    <?php endwhile; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-hero">
                <div class="card-header">
                  <div class="card-icon">
                    <i class="far fa-comment-dots"></i>
                  </div>
                  <h4><?php echo $total_feedback; ?></h4>
                  <div class="card-description">Feedback from customers</div>
                </div>
                <div class="card-body p-0">
                  <div class="tickets-list">
                    <?php while ($feedback = mysqli_fetch_array($feedbacks)): ?> 
                    <?php $time_ago = get_time_ago(strtotime($feedback['feedback_date'])); ?>
                    <a href="feedback.php?feedback_id=<?php echo $feedback['feedback_id']; ?>" class="ticket-item">
                      <div class="ticket-title">
                        <h4><?php echo substr($feedback['comment2'], 0, 95) . " ..."; ?></h4>
                      </div>
                      <div class="ticket-info">
                        <div><?php echo $feedback['name']; ?></div>
                        <div class="bullet"></div>
                        <div class="text-primary"><?php echo $time_ago; ?></div>
                      </div>
                    </a>
                    <?php endwhile; ?>
                    <a href="feedbacks.php" class="ticket-item ticket-more">
                      View All <i class="fas fa-chevron-right"></i>
                    </a>
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
  <script src="assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
  <script src="assets/modules/chart.min.js"></script>
  <script src="assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <script src="assets/modules/sweetalert/sweetalert.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/index-0.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
    var ctx = document.getElementById("chart").getContext('2d');

    showChart("year");

    function showChart(period) {
      var label = "This " + period.charAt(0).toUpperCase() + period.slice(1);
      var label2 = "Last " + period.charAt(0).toUpperCase() + period.slice(1);

      switch (period) {
        case "month":
          var labels = [<?php echo $this_month_chart_data['x_axis']; ?>];
          var data = [<?php echo $this_month_chart_data['y_axis']; ?>];
          var data2 = [<?php echo $last_month_chart_data['y_axis']; ?>];
          document.getElementById("chart_title").innerHTML = "<?php echo $this_month_chart_data['chart_title']; ?>";
          break;

        case "year":
          var labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
          var data = [<?php echo $this_year_chart_data['y_axis']; ?>];
          var data2 = [<?php echo $last_year_chart_data['y_axis']; ?>];
          document.getElementById("chart_title").innerHTML = "<?php echo $this_year_chart_data['chart_title']; ?>";
          break;
      }

      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: label,
            data: data,
            borderWidth: 2,
            backgroundColor: 'rgba(63,82,227,.8)',
            borderWidth: 0,
            borderColor: 'transparent',
            pointBorderWidth: 0,
            pointRadius: 3.5,
            pointBackgroundColor: 'transparent',
            pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
          },
          {
            label: label2,
            data: data2,
            borderWidth: 2,
            backgroundColor: 'rgba(254,86,83,.7)',
            borderWidth: 0,
            borderColor: 'transparent',
            pointBorderWidth: 0 ,
            pointRadius: 3.5,
            pointBackgroundColor: 'transparent',
            pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                // display: false,
                drawBorder: false,
                color: '#f2f2f2',
              },
              ticks: {
                beginAtZero: true,
                // stepSize: 1500,
                callback: function(value, index, values) {
                  return '$' + value;
                }
              }
            }],
            xAxes: [{
              gridLines: {
                display: false,
                tickMarkLength: 15,
              }
            }]
          },
        }
      });

    }

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
    
  </script>
</body>
</html>