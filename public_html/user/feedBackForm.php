<?php

  if (!empty($_GET['cust_id']) && !empty($_GET['project_id'])) {
    $cust_id = $_GET['cust_id'];
    $project_id = $_GET['project_id'];
  }
  else {
    die();  
  }

?>

<!-- Price box minimal--><!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Feed Back Form</title>
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
                  <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo.jpeg" alt="" width="232" height="67"/><img class="brand-logo-light" src="images/logo.PNG" alt="" width="86" height="104"/></a>
                  </div>
                </div>
                
              </div>
            </div>
          </nav>
        </div>
      </header>
      


      <!-- Get in touch with us-->
      <section class="section section-md bg-default">
        <div class="container">
          <h4>Feedback Form</h4>
          <p class="big">Thank you for come to this feedback page. Ur feed back is important because will give a lot of help to us improve our service. </p>
          <!-- RD Mailform-->
          <form class="rd-form rd-mailform form-boxed" data-form-output="form-output-global" data-form-type="contact" method="post" action="submitFeedback.php">
           
            <div class="row row-50">
                <div class="col-lg-7">
                  <input type="hidden" name="cust_id" value="<?php echo $cust_id ;?>">
                  <input type="hidden" name="project_id" value="<?php echo $project_id ;?>">
                  <p>Did InHaus meet your overall expectations? *</p>
                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="ExceededExpectations" name="expectation" value="Exceeded Expectations" />
                    <label class="form-check-label" for="ExceededExpectations"> Exceeded Expectations</label>
                  </div>

                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="MetExpectations" name="expectation" value="Met Expectations" />
                    <label class="form-check-label" for="MetExpectations">Met Expectations</label>
                  </div>

                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="DidNotMeetExpectations" name="expectation" value="Did Not Meet Expectations" />
                    <label class="form-check-label" for="DidNotMeetExpectations">Did Not Meet Expectations</label>
                  </div>

                  <div class="form-check">
                    <input type="radio" class="form-check-input" id="N/A" name="expectation" value="N/A - Dont know what to expect" />
                    <label class="form-check-label" for="N/A">N/A - Didn't know what to expect</label>
                  </div>
                  </div>
                
                  
                  <div class="col-lg-7">
                    <p>Would you work with InHaus again? *</p>
                    <div class="form-check">
                      <input type="radio" class="form-check-input" id="ExtremelyLikely" name="workAgn" value="Extremely Likely" />
                      <label class="form-check-label" for="ExtremelyLikely">Extremely Likely</label>
                    </div>
  
                    <div class="form-check">
                      <input type="radio" class="form-check-input" id="ModeratelyLikely" name="workAgn" value="Moderately Likely"/>
                      <label class="form-check-label" for="ModeratelyLikely">Moderately Likely</label>
                    </div>
  
                    <div class="form-check">
                      <input type="radio" class="form-check-input" id="SlightlyLikely" name="workAgn" value="Slightly Likel"/>
                      <label class="form-check-label" for="SlightlyLikely">Slightly Likely</label>
                    </div>
  
                    <div class="form-check">
                      <input type="radio" class="form-check-input" id="NotLikely" name="workAgn" value="Not Likely" />
                      <label class="form-check-label" for="NotLikely">Not Likely</label>
                    </div>
                    </div>

                    <div class="col-lg-7">
                      <p>How does InHaus compare? *</p>
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="Superior" name="compare" value="Superior"/>
                        <label class="form-check-label" for="Superior">Superior</label>
                      </div>
    
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="SlightlySuperior" name="compare" value="Slightly Superior"/>
                        <label class="form-check-label" for="SlightlySuperior">Slightly Superior</label>
                      </div>
    
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="Equal" name="compare" value="Equal"/>
                        <label class="form-check-label" for="Equal">Equal</label>
                      </div>
    
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="SlightlyInferior" name="compare" value="Slightly Inferior"/>
                        <label class="form-check-label" for="SlightlyInferior">Slightly Inferior</label>
                      </div>

                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="Inferior" name="compare" value="Inferior"/>
                        <label class="form-check-label" for="Inferior">Inferior</label>
                      </div>

                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="N/A1" name="compare" value="N/A - No experience with another interior designer"/>
                        <label class="form-check-label" for="N/A1"> N/A - No experience with another interior designer</label>
                      </div>
                      </div>

                        <div class="col-lg-12">
                          <p>Rate your experience with InHaus? *</p>
                          <br>
                          <p>InHaus provided clear and consistent communication throughout the project.</p>

                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="communication" id="StronglyDisagree" value="Strongly Disagree">
                              <label class="form-check-label" for="StronglyDisagree">Strongly Disagree</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="communication" id="Disagree" value="Disagree">
                                <label class="form-check-label" for="Disagree">Disagree</label>
                              </div>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="communication" id="Neutra" value="Neutral">
                                <label class="form-check-label" for="Neutral">Neutral</label>
                              </div>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="communication" id="Agree" value="Agree">
                                <label class="form-check-label" for="Agree">Agree</label>
                              </div>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="communication" id="StronglyAgree" value="Strongly Agree">
                                <label class="form-check-label" for="StronglyAgree">Strongly Agree</label>
                              </div>

                              <br><br>

                              <p>InHaus's design process was easy to understand and/or explained appropriately as the project progressed.</p>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="explain" id="StronglyDisagree2" value="Strongly Disagree">
                                <label class="form-check-label" for="StronglyDisagree2">Strongly Disagree</label>
                              </div>
                              
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="explain" id="Disagree2" value="Disagree">
                                  <label class="form-check-label" for="Disagree2">Disagree</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="explain" id="Neutra2" value="Neutral">
                                  <label class="form-check-label" for="Neutra2">Neutral</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="explain" id="Agree2" value="Agree">
                                  <label class="form-check-label" for="Agree2">Agree</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="explain" id="StronglyAgree2" value="Strongly Agree">
                                  <label class="form-check-label" for="StronglyAgree2">Strongly Agree</label>
                                </div>

                                <p>The final result created by InHaus was exactly what I was envisioning or better.</p>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="goal" id="StronglyDisagree3" value="Strongly Disagree">
                                <label class="form-check-label" for="StronglyDisagree3">Strongly Disagree</label>
                              </div>
                              
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="goal" id="Disagree3" value="Disagree">
                                  <label class="form-check-label" for="Disagree3">Disagree</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="goal" id="Neutral3" value="Neutral">
                                  <label class="form-check-label" for="Neutral3">Neutral</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="goal" id="Agree3" value="Agree">
                                  <label class="form-check-label" for="Agree3">Agree</label>
                                </div>
  
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="goal" id="StronglyAgree3" value="Strongly Agree">
                                  <label class="form-check-label" for="StronglyAgree3">Strongly Agree</label>
                                </div>

                          </div>

            
              <div class="col-12">
                <div class="form-wrap form-wrap-icon">
                  <label class="form-label" for="comment">What could have made the project better? </label>
                  <textarea class="form-input" id="comment" name="comment" data-constraints="@Required"></textarea>
                </div>
              </div>

              <div class="col-12">
                <div class="form-wrap form-wrap-icon">
                  <label class="form-label" for="comment2">
                    In your opinion what we did to make you feel the best </label>
                  <textarea class="form-input" id="comment2" name="comment2" data-constraints="@Required"></textarea>
                </div>
              </div>


              <div class="col-md-12">
                <button class="button button-default" type="submit" value="submit">Send</button>
              </div>
            </div>

           
          </form>
        </div>
      </section>
      


      <!-- Page Footer-->
      <div class="pre-footer-classic bg-gray-700 context-dark">
        <div class="container">
          <div class="row row-30 justify-content-lg-between">
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
                <dd><a class="link-default" href="mailto:#">Info@demolink.org</a></dd>
              </dl>
              <ul class="list-inline list-inline-sm">
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-facebook" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-instagram" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-behance" href="#"></a></li>
                <li><a class="icon icon-sm icon-gray-filled icon-circle mdi mdi-twitter" href="#"></a></li>
              </ul>
            </div>
            <div class="col-lg-4">
              <h5>Newsletter</h5>
              <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                <div class="form-wrap form-wrap-icon">
                  <div class="form-icon mdi mdi-email-outline"></div>
                  <input class="form-input" id="footer-email" type="email" name="email" data-constraints="@Email @Required">
                  <label class="form-label" for="footer-email">E-mail</label>
                </div>
                <div class="button-wrap">
                  <button class="button button-default button-invariable" type="submit">Subscribe</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <footer class="section footer-classic context-dark text-center">
        <div class="container">
          <div class="row row-15 justify-content-lg-between">
            <div class="col-lg-4 col-xl-3 text-lg-left">
              <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span>. All Rights Reserved. Design by <a href="https://www.templatemonster.com">TemplateMonster</a></p>
            </div>
            <div class="col-lg-5 col-xl-6">
              <ul class="list-inline list-inline-lg text-uppercase">
                <li><a href="about-us.html">About us</a></li>
                <li><a href="#">Our Portfolio</a></li>
                <li><a href="#">Blog</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <div class="snackbars" id="form-output-global"></div>
    <script src="js/core.min.js"></script>
    <script src="js/script2.js"></script>


  </body>
</html>