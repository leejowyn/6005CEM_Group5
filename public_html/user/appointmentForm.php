<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['user_id'])){
    header("location: login.php");
  }
  ?>
<!-- Price box minimal--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Appointment Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .ie-panel{display: none;
      background: #212121;
      padding: 10px 0;
      box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);
      clear: both;
      text-align:center;
      position: relative;
      z-index: 1;
    } 
    html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}
    
    
    </style>

    <!--this is time picker de js-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.js"></script>
    <!--end of time picker de js-->
    
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
                  <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo.jpeg" alt="" width="232" height="67"/><img class="brand-logo-light" src="images/logo.jpeg" alt="" width="86" height="104"/></a>
                  </div>
                </div>
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                      <li class="rd-nav-item "><a class="rd-nav-link" href="index.php">Home</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="about-us.php">About</a>
                      </li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="portfolio.php">Portfolio</a>
                      </li>
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="appointmentForm.php">Consultation</a>
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
      


      <!-- Get in touch with us-->
      <section class="section section-md bg-default">
        <div class="container">
          <h4>Appointment Detail</h4>
          <p class="big">Please fill in all of the information below:</p>
          <!-- RD Mailform-->
          <form class="rd-form rd-mailform form-boxed" data-form-output="form-output-global" data-form-type="contact" method="post" action="savForm.php">
           
            <div class="row row-50">
                
                <p>Please click on the course to select the first course you like</p>
                <br>
                <div class="col-lg-12">
                  <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="mordernMinimalist" name="preferred_style[]" value="Modern Minimalist" />
                  <label class="form-check-label" for="mordernMinimalist">Mordern Minimalist</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Industrial" name="preferred_style[]" value="Industrial Style" />
                  <label class="form-check-label" for="Industrial">Industrial Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Traditional/Classic" name="preferred_style[]" value="Traditional/Classic Style"/>
                  <label class="form-check-label" for="Traditional/Classic">Traditional/Classic Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Art_Deco" name="preferred_style[]" value="Art Deco Style"/>
                  <label class="form-check-label" for="Art_Deco">Art Deco Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="English_Country" name="preferred_style[]" value="English Country Style"/>
                  <label class="form-check-label" for="English_Country">English Country Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Coastal" name="preferred_style[]" value="Coastal Style"/>
                  <label class="form-check-label" for="Coastal">Coastal Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Eclectic" name="preferred_style[]" value="Eclectic Style"/>
                  <label class="form-check-label" for="Eclectic">Eclectic Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Asian/Zen" name="preferred_style[]" value="Asian/Zen Style"/>
                  <label class="form-check-label" for="Asian/Zen">Asian/Zen Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Rustic" name="preferred_style[]" value="Rustic Style"/>
                  <label class="form-check-label" for="Rustic">Rustic Style</label>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="Hi-Tech" name="preferred_style[]" value="Hi-Tech Style"/>
                  <label class="form-check-label" for="Hi-Tech">Hi-Tech Style</label>
                </div>
                </div>

                <div class="col-lg-10">
                <div class="form-wrap form-wrap-icon">
                  <p>Consultation type</p>
                  <label class="form-label" for="consulType">Consultation type</label>
                  <select name="consulType" id="consulType" >
                    <option value="In Home">In Home</option>
                    <option value="Phone Call">Phone Call</option>
                    <option value="In Store">In Store</option>
                    <option value="Virtual Meeting">Virtual Meeting</option>
                  </select>
                </div>
                </div>
                
              <div class="col-12">
              <p>Appointment Date</p>
              <input id="date_picker" type="date" name="date">
              </div>

              <div class="col-12">
              <p>Appointment time</p>
              <input type="time" list="avail" name="time" >
              <datalist id="avail">
              <option value="09:00:00">
              <option value="10:00:00">
              <option value="11:00:00">
              <option value="14:00:00">
              <option value="15:00:00">
              <option value="16:00:00">
              </datalist>
              </div>

              <div class="col-12">
                <div class="form-wrap form-wrap-icon"></div>
                <input class="form-input" id="area" type="text" name="area" data-constraints="@Required">
                <label class="form-label" for="area">Design Area Eg: bathroom, bedroom, livingroom</label>
                </div>
              </div>

              <div class="col-12">
                <div class="form-wrap form-wrap-icon">
                  <label class="form-label" for="comment">Additional Comment</label>
                  <textarea class="form-input" id="comment" name="comment" data-constraints="@Required"></textarea>
                </div>
              </div>
                

              <div class="col-2 ">
              <div class="form-wrap form-wrap-icon">
              <div style="margin-top:25px;">
                <button class="button button-default" type="submit">Send</button>
              </div>
              </div>
              </div>
            </div>

           
          </form>
        </div>
      </section>


      
      
    </div>
    <div class="snackbars" id="form-output-global"></div>
     <script src="js/core.min.js"></script>
    <script src="js/script2.js"></script> 

    <!--disable past date-->
    <script language="javascript">
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#date_picker').attr('min',today);
    </script>
    <!--end disable past date-->
   
  </body>
</html>