<html>
<head>
  <title>Front Page</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<?php include "db_connect.php";?>
<body>
<div class="container">
<!--  <h2>Example: Login and Registration Script with PHP, MySQL</h2>-->
  <div class="row">
    <div class="col-12">
      <div class="card border-0">
       <div class="card-body text-center"> <!--align-self-center-->
          <?php
          if (isset($_SESSION['user_id'])) {
            ?>
            <p class="text-bg-info"><strong>Welcome!</strong> You're signed in as <strong><?php echo $_SESSION['user_name'];?></strong></p>
            <a href="logout.php">Log Out</a>
            <?php
          }
          else {
            ?>
            <a class="page-link" href="login.php">Login</a>
            <a class="page-link" href="register.php">Sign Up</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>