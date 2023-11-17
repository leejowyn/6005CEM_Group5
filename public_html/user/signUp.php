<?php 
  session_start();
  if(isset($_SESSION['user_id'])){
    header("location: index.html");
  }
?>

<?php include_once "header.php"; ?>
<body>
    
<div class="body">
  <div class="wrapper">
    <section class="form signup">
      <header>In_Haus</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        
        <div class="field input">
          <label>Name</label>
          <input type="text" name="custname" placeholder="Name" required>
        </div>
        
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i>
        </div>
        
        <div class="field input">
          <label>Phone Number</label>
          <input type="text" name="phoneNo" placeholder="Phone number">
        </div>
        
        <!-- Checkbox for agreeing to terms and conditions -->
        <div class="field checkbox">
          <label for="agreeTerms">
            <input type="checkbox" id="agreeTerms" required>I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>
          </label>
        </div>

        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

  </div>
</body>
</html>
