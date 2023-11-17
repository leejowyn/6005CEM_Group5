<?php

  if (isset($_SESSION['admin_id'])) {
    $dbc = mysqli_connect('localhost', 'root', '');
	  mysqli_select_db($dbc, 'in_haus');

    $logged_in_admin_id = $_SESSION['admin_id'];
		// $query = 'SELECT admin_name, admin_position FROM admin WHERE admin_id = ' . $logged_in_admin_id;

		// if ($result = mysqli_query($dbc, $query)) {
		// 	$row = mysqli_fetch_assoc($result);
		// 	$logged_in_admin_name = $row['admin_name'];
    //   $logged_in_admin_position = $row['admin_position'];
    // }

    $logged_in_admin_name = $_SESSION['admin_name'];
    $logged_in_admin_email = $_SESSION['admin_email'];
    $logged_in_admin_position = $_SESSION['admin_position'];

    if (empty($managerAccessOnly))
      $managerAccessOnly = false;

    if ($logged_in_admin_position != "Project Manager" && $managerAccessOnly) 
      echo "<script>window.location = 'error_403.php';</script>";

    mysqli_close($dbc);
  }
  else {
    echo "<script>window.location = 'login.php';</script>";
  }
?>
<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $logged_in_admin_name; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right shadow">
              <div class="dropdown-divider"></div>
              <form id="form_change_password" action="change_password.php" method="post">
                <input type="hidden" name="id" value="<?php echo $logged_in_admin_id; ?>">
                <input type="hidden" name="email" value="<?php echo $logged_in_admin_email; ?>">
                <input type="hidden" name="info" value="true">
              </form>
              <a style="cursor:pointer;" class="dropdown-item has-icon text-muted" onclick="document.getElementById('form_change_password').submit();">
                <i class="fas fa-lock"></i> Change Password
              </a>
              
              <a href="login.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="dashboard.php">In Haus</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard.php">IH</a>
          </div>
          <ul class="sidebar-menu">
            <li class="<?php if ($page == "dashboard") echo "active"; ?>"><a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
            <?php if ($logged_in_admin_position == "Project Manager"): ?>
            <li class="<?php if ($page == "recent_activities") echo "active"; ?>"><a class="nav-link" href="recent_activities.php"><i class="fas fa-history"></i> <span>Recent Activities</span></a></li>
            <?php endif; ?>
            <li class="<?php if ($page == "consultations") echo "active"; ?>"><a class="nav-link" href="consultations.php"><i class="fas fa-handshake"></i> <span>Consultations</span></a></li>
            <li class="<?php if ($page == "projects") echo "active"; ?>"><a class="nav-link" href="projects.php"><i class="fas fa-clipboard-list"></i> <span>Projects</span></a></li>
            <li class="<?php if ($page == "feedbacks") echo "active"; ?>"><a class="nav-link" href="feedbacks.php"><i class="fas fa-comment-dots"></i> <span>Feedbacks</span></a></li>
            <li class="<?php if ($page == "general_settings" || $page == "portfolios" || $page == "staffs") echo "active"; ?>">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-cog"></i><span>Settings</span></a>
              <ul class="dropdown-menu">
                <?php if ($logged_in_admin_position == "Project Manager"): ?>
                <li class="<?php if ($page == "general_settings") echo "active"; ?>"><a class="nav-link" href="general_settings.php">General</a></li>
                <?php endif; ?>
                <li class="<?php if ($page == "portfolios") echo "active"; ?>"><a class="nav-link" href="portfolios.php">Portfolios</a></li>
                <?php if ($logged_in_admin_position == "Project Manager"): ?>
                <li class="<?php if ($page == "staffs") echo "active"; ?>"><a class="nav-link" href="staffs.php">Staffs</a></li>
                <?php endif; ?>
              </ul>
            </li>
          </ul>
        </aside>
      </div>