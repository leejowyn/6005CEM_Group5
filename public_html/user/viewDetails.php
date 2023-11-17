
<!-- Price box minimal--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>In Haus Interior + Staging</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../admin/assets/modules/bootstrap-icons/bootstrap-icons.css">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../admin/assets/modules/glightbox/css/glightbox.min.css">
  <link rel="stylesheet" href="../admin/assets/modules/aos/aos.css">
  <link rel="stylesheet" href="../admin/assets/modules/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="../admin/assets/modules/chocolat/dist/css/chocolat.css">
  <link rel="stylesheet" href="css/lightbox.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aframe/0.7.1/aframe.min.js"></script>
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
  </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container">
          <div class="cssload-speeding-wheel"></div>
        </div>
        <p>Loading...</p>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-wide" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo.png" alt="" width="232" height="67"/><img class="brand-logo-light" src="images/logo-inverse-86x104.png" alt="" width="86" height="104"/></a>
                  </div>
                </div>
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                      <li class="rd-nav-item"><a class="rd-nav-link" href="index.php">Home</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="about-us.php">About</a>
                      </li>
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="portfolio.php">Portfolio</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="appointmentForm.php">Consultation</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.php">Contacts</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="users.php">Chat</a>
                    </li>
                    <li class="rd-nav-item"><a class="rd-nav-link" href="profile.php">Profile</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      
      <?php

	$dbc = mysqli_connect('localhost', 'root', '');
	mysqli_select_db($dbc, 'in_haus');
        
        
        if (isset($_GET['portfolio_id'])){
            $portfolio_id = $_GET['portfolio_id'];
        }
        
	$query = 'SELECT * FROM portfolio WHERE portfolio_id= '.$portfolio_id;
        
	if (!$r = mysqli_query($dbc, $query)) {
		echo '<p style="color:red;">Could not retrieve the data because: <br/>' . mysqli_error($dbc) . '</p><p>The query being run was: ' . $query . '</p>';
	}
        
        $count = 0;
        
	mysqli_close($dbc);

    ?>
      <?php while ($row = mysqli_fetch_array($r)): ?>
      <section class="breadcrumbs-custom bg-image context-dark" style="background-image: url(<?php echo "../admin/assets/img/" . $row['portfolio_thumbnail']; ?>);">
        <div class="container">
          <h3 class="breadcrumbs-custom-title"><?php echo $row['portfolio_style']; ?></h3>
        </div>
      </section>
      
    <!-- Main Content -->

    <section class="section section-lg bg-default section-lined">
        <div class="container container-lined">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
          </div>
        </div>
        
        <div class="container container-custom-width">
            <?php
                $portfolio_images = explode(",",$row['portfolio_images']);
            ?>
            
            <style>
        .overlay {
            position: absolute;
            height: 100%;
            width: 100%;
            background-color: transparent;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .overlay:hover {
            opacity: 0.5;
            background-color: black;
        }
        
        .image {
            width: 100%;
            height: 100%;
        }
        
        .icon {
            position: absolute;
            left: 50%;
            bottom: 50%;
            font-size: 25px;
            cursor: pointer;
            border-radius: 10rem;
            background-color: transparent;
            border: transparent;
            color: #be985f;
        }
        
            </style>


                <?php 
                foreach ($portfolio_images as $img) {
                    if ($count % 3 == 0)
                        echo '<div class="row row-custom-width row-30 row-xxl-100 row-flex" >';
                    
                    echo '<div class="col-sm-6 col-lg-4 wow fadeInRight" >
                        
                        <img src="../admin/assets/img/'.$img.'" class="image">
                            <div class="overlay">
                                <a href ="../admin/assets/img/'.$img.'" class="icon" ;">
                                    <i class="bi bi-zoom-in"></i>
                                </a>
                            </div>
                       </div>
                ';

                    if ($count % 3 == 2)
                        echo '</div>';
                    
                    $count++;
                }   
                ?>
    </div>
      </section>
    
        <?php
            $panorama = $row['portfolio_panorama'];
        ?>
    
    <?php endwhile; ?>
    
     <style>

    .main-container {
      display: flex;
      height: 100vh;
      align-items: center;
      background: #262626;
      padding: 0 100px;
    }

    .main-container .image-container {
      flex: 1;
      height: 80%;
    }

    </style>
    
    <div class="main-container">
      <div class="image-container"></div>
    </div>
    
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/three.js/105/three.min.js"
      integrity="sha512-uWKImujbh9CwNa8Eey5s8vlHDB4o1HhrVszkympkm5ciYTnUEQv3t4QHU02CUqPtdKTg62FsHo12x63q6u0wmg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="js/panolens.min.js"></script>
    
    <script>
        
    const panoramaImage = new PANOLENS.ImagePanorama("../admin/assets/img/" + "<?php echo $panorama; ?>");
    const imageContainer = document.querySelector(".image-container");

    const viewer = new PANOLENS.Viewer({
      container: imageContainer,
      autoRotate: true,
      autoRotateSpeed: 1.0,
      controlBar: false,
      zoom: 14,
      zoomControl: false,
    });

    viewer.add(panoramaImage);

    </script>
  
    
      <footer class="section footer-classic context-dark text-center">
        <div class="container">
          <div class="row row-15 justify-content-lg-between">
            <div class="col-lg-5 col-xl-6">
              <ul class="list-inline list-inline-lg text-uppercase">
                <li><a href="about-us.php">About us</a></li>
                <li><a href="portfolio.php">Our Portfolio</a></li>
                <li><a href="faq.php">FAQ</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
    
    <div class="snackbars" id="form-output-global"></div>
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
    <script src="../admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="../admin/assets/modules/aos/aos.js"></script>
    <script src="../admin/assets/modules/glightbox/js/glightbox.min.js"></script>
    <script src="../admin/assets/modules/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../admin/assets/modules/swiper/swiper-bundle.min.js"></script>
    <script src="../admin/assets/modules/purecounter/purecounter_vanilla.js"></script>
    <script src="../admin/assets/js/custom.js"></script>
  </body>
</html>
