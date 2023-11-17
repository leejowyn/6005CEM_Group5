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
    <title>Save Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/js.css">

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
      <defs>
        <symbol id="check" viewBox="0 0 16 16">
          <path fill="currentColor" d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M7,11.4L3.6,8L5,6.6l2,2l4-4L12.4,6L7,11.4z"></path>
        </symbol>
      </defs>
    </svg>

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

      .smallT{
        text-size-adjust: 20dp;
      }
    </style>


</head>
<body>
<?php
    if(
    !empty($_POST['preferred_style']) &&
    !empty($_POST['consulType']) &&
    !empty($_POST['comment']) &&
    !empty($_POST['date']) &&
    !empty($_POST['time']) &&
    !empty($_POST['area'])){

   $custID = $_SESSION['user_id'];
    $course = implode(',', $_POST['preferred_style']);
    $type = $_POST['consulType'];
    $comment = $_POST['comment'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $area = $_POST['area'];
    $currentdate =  date("Y-m-d");
    $var=NULL;

    
            
    $queryInsert = mysqli_query($conn, "INSERT INTO consultation(consultation_id, created_datetime, 
        consultation_date, consultation_time, consultation_type, preferred_style, design_range, 
         consultation_remark, cust_id)
                        VALUES (0, '$currentdate', '$date', '$time', '$type',' $course','$area','$comment','$custID')");
            
       
            echo '<div class="container test">';
            echo ' <div class="success-block">';
            echo '<svg class="icon success-icon" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink">';
            echo '<use xlink:href="#check"></use>';
            echo '</svg>';
            echo '<div class="title"><span>S</span><span>u</span><span>c</span><span>c</span><span>e</span><span>s</span><span>s</span>';
            echo '<br><p style="font-size:2vw">Successfully place an appointment! please click the link below back to homepage</p>';
            echo '<a href="index.php" style="font-size:2vw">Home Page </a>';
            echo '</div>';
              
            echo '</div>';
            echo '</div>';
             
            echo '<div class="container test">';
            echo ' <div class="success-block">';
            
            echo '</div>';
            echo '</div>';
  

   }else{
   echo "Please fill in all the information to place an appointment! ";
   }

   mysqli_close($conn);



?>
</body>
</html>