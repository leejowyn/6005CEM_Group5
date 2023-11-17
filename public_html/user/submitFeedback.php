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

<?php
include_once "php/config.php";

    if(!empty($_POST['expectation']) &&
    !empty($_POST['workAgn']) &&
    !empty($_POST['compare']) &&
    !empty($_POST['communication']) &&
    !empty($_POST['explain']) &&
    !empty($_POST['goal']) &&
    !empty($_POST['comment']) &&
    !empty($_POST['comment2']) ){
        
    
    $cust_id = $_POST['cust_id'];
    $expectation = $_POST['expectation'];
    $workAgn = $_POST['workAgn'];
    $compare = $_POST['compare'];
    $communication = $_POST['communication'];
    $explain = $_POST['explain'];
    $goal = $_POST['goal'];
    $comment = $_POST['comment'];
    $comment2 = $_POST['comment2'];
    $currentDate = date("d-m-y");

    $project_id = $_POST['project_id'];


$queryInsert = mysqli_query($conn, "INSERT INTO feedback(feedback_id, feedback_date, project_id, cust_id, expectation, workAgn, compare, communication, explanation, goal, comment, comment2)
                        VALUES (0, '$currentDate', '$project_id', '$cust_id', '$expectation', '$workAgn', '$compare', '$communication', '$explain', '$goal', '$comment', '$comment2')");

echo '<div class="container test">';
echo ' <div class="success-block">';
echo '<svg class="icon success-icon" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink">';
echo '<use xlink:href="#check"></use>';
echo '</svg>';
echo '<div class="title"><span>S</span><span>u</span><span>c</span><span>c</span><span>e</span><span>s</span><span>s</span>';
echo '<br><p style="font-size:2vw">Successfully ubmit ur feedback form! Thank you for you feedback, Have a nice day, bye!</p>';

echo '</div>';
  
echo '</div>';
echo '</div>';
 
echo '<div class="container test">';
echo ' <div class="success-block">';

echo '</div>';
echo '</div>';

}else{
echo "Please fill in all the information in the form! ";
}

mysqli_close($conn);
?>

</body>
</html>