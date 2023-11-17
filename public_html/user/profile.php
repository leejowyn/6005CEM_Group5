<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['user_id'])){
    header("location: login.php");
  }
?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>In Haus Interior + Staging</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}
    
    .button-74 {
        background-color: #fbeee0;
        border: 2px solid #422800;
        border-radius: 30px;
        box-shadow: #422800 4px 4px 0 0;
        color: #422800;
        cursor: pointer;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        padding: 0 18px;
        line-height: 50px;
        text-align: center;
        text-decoration: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        }

        .button-74:hover {
        background-color: #fff;
        }

        .button-74:active {
        box-shadow: #422800 2px 2px 0 0;
        transform: translate(2px, 2px);
        }

        @media (min-width: 768px) {
        .button-74 {
            min-width: 120px;
            padding: 0 25px;
        }
        }
    </style>
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
    <?php include 'nav.php'; ?>
      <section class="breadcrumbs-custom bg-image context-dark" style="background-image: url(images/profilepic2.jpg);">
        <div class="container">
          <h3 class="breadcrumbs-custom-title">Profile</h3>
          <pre-footer-classic class="breadcrumbs-custom-subtitle">Personal Information</pre-footer-classic>
        </div>
      </section>
<!-- Blurb minimal-->
      
    <!--Get in touch with us-->
      <section class="section section-md bg-default">
        <div class="container">
          <h2>Personal Information</h2>
          <!-- RD Mailform-->
          <div class="row row-50">
          <?php
                $query="SELECT * FROM user WHERE user_id='".$_SESSION['user_id']."' ";
                
                if($r = mysqli_query($conn, $query ) ) {
                
                    while ($row=mysqli_fetch_array($r)){
                    
                        echo '<div class="col-lg-8">';
                        print "<h3>Name: {$row['name']}</h3>";
                        echo '</div>';
                        echo '</div>';

                        echo '<div class="row row-50">';
                        echo '<div class="col-lg-8">';
                        print "<h3>Email: {$row['email']}</h3>";
                        echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="row row-50">';
                        echo '<div class="col-md-12">';
                        print" <button class='button-74' role='button'><a href='php/logout.php?logout_id= {$row['user_id']}' class='logout'>Logout</a></button>";
                        print"</div>";
                        echo '</div>';
                        
                            }
                        
                        
                    }else{
                        print'<p style="color:red;">Could not retrieve the data because :<br/>' .mysqli_error($conn).
                        '.</p><p>the query being run was : '.$query.'</p>';
                    }
                
                    mysqli_close($conn);
                
                ?>
      
      </div>
          
        
      </section>
<!-- Page Footer-->
      <div class="pre-footer-classic bg-gray-700 context-dark">
        <div class="container">
          <div class="row row-30 justify-content-lg-between">
              <div class="col-lg-4">
              <div class="img-wrap-1"><img src="images/signature.png" alt="" width="300" height="100"/>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3 col-xl-3">
              <h5>Location</h5>
              <ul class="list list-sm">
                <li>
                  <p>1418 Riverwood Drive,</p>
                </li>
                <li>
                  <p>Suite 3845 Cottonwood,</p>
                </li>
                <li>
                  <p>CA 96022</p>
                </li>
                <li>
                  <p>United States</p>
                </li>
              </ul>
            </div>
            <div class="col-sm-6 col-lg-4 col-xl-3">
              <h5>Contacts</h5>
              <dl class="list-terms-custom">
                <dt>Ph.</dt>
                <dd><a class="link-default" href="tel:#">1-300-123-1234</a></dd>
              </dl>
              <dl class="list-terms-custom">
                <dt>Email.</dt>
                <dd><a class="link-default" href="mailto:#">info@inhausinterior.com</a></dd>
              </dl>
              <ul class="list-inline list-inline-sm">
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-whatsapp" href="https://wa.link/l3cci2" target="_blank"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-facebook" href="https://www.facebook.com/" target="_blank"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-instagram" href="https://www.instagram.com/" target="_blank"></a></li>
              </ul>
            </div>
            
          </div>
        </div>
      </div>
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
  </body>
</html>
