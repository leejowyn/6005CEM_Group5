<?php
  $page = "portfolios";
  session_start();

	$dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');

	$query = 'SELECT * FROM portfolio';

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
  <link rel="stylesheet" href="assets/modules/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/chocolat/dist/css/chocolat.css">
	<link rel="stylesheet" href="assets/modules/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="assets/modules/aos/aos.css">
  <link rel="stylesheet" href="assets/modules/swiper/swiper-bundle.min.css">

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
            <h1>Portfolios</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="general_settings.php">Settings</a></div>
              <div class="breadcrumb-item">Portfolios</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header p-1">
                    <a href="portfolio.php" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> Add</a>
                  </div>
                  <div class="card-body">
                    <section id="projects" class="projects">
                      <div class="container aos-init aos-animate" data-aos="fade-up">

                        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

                          <ul class="portfolio-flters aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-commercial">Commercial</li>
                            <li data-filter=".filter-residential">Residential</li>
                          </ul><!-- End Projects Filters -->

                          <div class="row gy-4 portfolio-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" style="position: relative; height: 1163.94px;">

                            <?php while ($row = mysqli_fetch_array($r)): ?>
                            <div class="col-lg-4 col-md-6 py-3 portfolio-item filter-<?php echo strtolower($row['portfolio_category']); ?>" style="position: absolute; ">
                              <div class="portfolio-content h-100">
                                <img src="assets\img\<?php echo $row['portfolio_thumbnail']; ?>" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                  <h4><?php echo $row['portfolio_category']; ?></h4>
                                  <p><?php echo $row['portfolio_style']; ?></p>
                                  <a href="assets\img\<?php echo $row['portfolio_thumbnail']; ?>" title="<?php echo $row['portfolio_category'] . " | " . $row['portfolio_style']; ?>" data-gallery="portfolio-gallery-<?php echo strtolower($row['portfolio_category']); ?>" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                                  <a href="portfolio.php?portfolio_id=<?php echo $row['portfolio_id']; ?>" title="Edit Details" class="details-link" target="_blank"><i class="bi bi-pencil"></i></a>
                                </div>
                              </div>
                            </div><!-- End Projects Item -->
                            <?php endwhile; ?>
                          </div><!-- End Projects Container -->

                        </div>

                      </div>
                    </section>
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
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
  <script src="assets/modules/aos/aos.js"></script>
  <script src="assets/modules/glightbox/js/glightbox.min.js"></script>
  <script src="assets/modules/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/modules/swiper/swiper-bundle.min.js"></script>
   <script src="assets/modules/purecounter/purecounter_vanilla.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  <script src="assets/js/page/modules-datatables.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>