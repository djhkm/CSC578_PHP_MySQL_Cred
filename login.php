<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script>
    function myFunction() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</head>
<?php
$db_connect = "";
include "db_connect.php";

if (isset($_SESSION['user_id']) != "") {
  header("Location: index.php");
}
if (isset($_POST['login'])) {
  $email = $db_connect -> real_escape_string($_POST['email']);
  $password = $db_connect -> real_escape_string($_POST['password']);
  $result = $db_connect -> query("SELECT * FROM user WHERE email = '" . $email. "' and password = '" . password_verify($password, PASSWORD_DEFAULT). "'");
  if ($result -> num_rows == 1) {
    $row = $result -> fetch_object();
    $_SESSION['user_id'] = $row -> uid;
    $_SESSION['user_name'] = $row -> username;
    header("Location: index.php");
  }
  else if ($result -> num_rows >= 2) {
    $error_message = "Duplicated Account Found!!!";
  }
  else {
    $error_message = "Incorrect Email or Password!!!";
  }
}
?>
<body>
<div class="container">
<!--  <h2>Example: Login and Registration Script with PHP, MySQL</h2>-->
  <div class="row">
    <div class="col-2"></div>
    <div class="col-md-8 col-md-offset-8 well">
      <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="loginform">
        <fieldset>
          <legend>Login</legend>
          <div class="form-group">
            <label for="name">Email</label>
            <input type="text" name="email" placeholder="Your Email" required class="form-control" />
          </div>
          <div class="form-group">
            <label for="name">Password</label>
            <input type="password" name="password" id="password" placeholder="Your Password" required class="form-control" />
            <input type="checkbox" onclick="myFunction()"> Show Password
          </div>
          <div class="form-group pt-3">
            <input type="submit" name="login" value="Login" class="btn btn-primary" />
          </div>
        </fieldset>
      </form>
      <span class="text-danger"><?php if (isset($error_message)) { echo $error_message; }?></span>
    </div>
    <div class="col-2"></div>
  </div>
  <div class="row">
    <div class="col-2"></div>
    <div class="col-md-8 col-md-offset-8 text-center">
      New User? <a href="register.php">Sign Up Here</a>
    </div>
    <div class="col-2"></div>
  </div>
</div>
</body>
</html>