<?php 
  session_start();
  include_once "config.php";
  if(!isset($_SESSION['admin_id'])){
    header("location: login.php");
  }
  else {
    $outgoing_id = $_SESSION['admin_id'];
  }
?>

<?php include_once "header.php"; ?>
<style>
  
  ul{
  background-color: #c4a27f;
	display: flex;
	width: 100%;
	height: 10vh;
	margin: auto;
	justify-content: space-between;
	text-align: center;
}
li {
	padding: 1rem 2rem 1.15rem;
  text-transform: uppercase;
  cursor: pointer;
  color: #ebebeb;
	min-width: 80px;
	margin: auto;
}

li:hover {
  background-image: url('https://scottyzen.sirv.com/Images/v/button.png');
  background-size: 100% 100%;
  color: #27262c;
  animation: spring 300ms ease-out;
  text-shadow: 0 -1px 0 #ef816c;
	font-weight: bold;
}
li:active {
  transform: translateY(4px);
}

</style>
<body>

  <div class="body" >
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM user WHERE user_id = {$_SESSION['admin_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <div class="details">
            <span><?php echo $row['name']?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="login.php" class="logout">Logout</a>
      </header>
      <br/>
      <div class="users-list">
  
      </div>
    </section>
  </div>


<script>
  const usersList = document.querySelector(".users-list");
  var outgoing_id = "<?php echo $outgoing_id; ?>";

  setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../admin/adminUser.php?outgoing_id=" + outgoing_id, true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
            usersList.innerHTML = data;
        }
    }
  }
  xhr.send();
  }, 500);

</script>

  </div>

</body>
</html>
