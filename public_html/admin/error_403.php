<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>404 &mdash; Stisla</title>

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
    <section class="section d-flex align-items-center" style="height:100vh">
        <div class="container mt-5 my-auto">
        <div class="page-error">
            <div class="page-inner">
              <h1>403</h1>
              <div class="page-description">
                  You do not have access to this page.
              </div>
              <?php if ($_SESSION['admin_position'] != 'Customer Service'): ?>
                <div class="page-search">
                  <div class="mt-3">
                  <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                  </div>
                </div>
              <?php else: ?>
                <div class="page-search">
                  <div class="mt-3">
                  <a href="users.php" class="btn btn-primary">Back to Live Chat</a>
                  </div>
                </div>
              <?php endif; ?>
            </div>
        </div>
        <div class="simple-footer mt-5">
            &copy; In Haus 2022
        </div>
        </div>
    </section>

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