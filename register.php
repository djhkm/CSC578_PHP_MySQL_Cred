<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.6.0.min.js"></script>

</head>
<script>

  // $('#signupform').on('submit', function (event) {
  //   event.preventDefault();
  //   var email = $('#email').val();
  //   $.ajax({
  //     url: 'function.php',
  //     method:'POST',
  //     data:{
  //       type:'read_a_user',
  //       email:email
  //     },
  //     cache:false,
  //     success:function (readData) {
  //       var dataResult = JSON.parse(readData);
  //       if (dataResult.statusCode === 200) {
  //         $('#email_error').html('Email existed...Please use another email!');
  //       }
  //     }
  //   });
  // });

  function read_a_user() {
    $("#email_error").html("");
    var email = $("#email").val();
    $.ajax({
      url:"function.php",
      method:"POST",
      data:{
        type:"read_a_user",
        email:email
      },
      cache:false,
      success:function (readData) {
        var dataResult = JSON.parse(readData);
        if (dataResult.statusCode === 200) {
          $('#signup').attr('disabled', 'disabled');
          $("#email_error").html("Email existed...Please use another email!");
        }
      }
    });
  }

  // function check_password () {
  //   var password = $("#password").val();
  //   var settings = {
  //     "async": true,
  //     "crossDomain": true,
  //     "url": "https://strong-password-generator-and-checker.p.rapidapi.com/api/password_check",
  //     "method": "POST",
  //     "headers": {
  //       "content-type": "application/json",
  //       "X-RapidAPI-Key": "5c2baa9c1cmshc641e1dba79beb7p132b9cjsnff3c06634aca",
  //       "X-RapidAPI-Host": "strong-password-generator-and-checker.p.rapidapi.com"
  //     },
  //     "processData": false,
  //     "data": JSON.stringify({
  //       "password": password
  //     })
  //   };
  //
  //   $.ajax(settings).done(function (response) {
  //     console.log(response);
  //     var dataResult = JSON.parse(response);
  //     $("#password_error").html(dataResult.password.value);
  //   });
  // }

  function check_password () {
    $("#password_error").html("");
    $("#password_pending").html("");
    $("#password_success").html("");
    var password = $("#password").val();
    if (password != "") {
      $.ajax({
        crossDomain: true,
        url: "https://strong-password-generator-and-checker.p.rapidapi.com/api/password_check",
        method: "POST",
        dataType: "html",
        headers: {
          "content-type": "application/json",
          "X-RapidAPI-Key": "5c2baa9c1cmshc641e1dba79beb7p132b9cjsnff3c06634aca",
          "X-RapidAPI-Host": "strong-password-generator-and-checker.p.rapidapi.com"
        },
        processData: false,
        data: JSON.stringify({
          password: password
        }),
        beforeSend:function () {
          $('#signup').attr('disabled', 'disabled');
          $("#password_pending").html("Validating...");
          $("#password_error").html("");
          $("#password_success").html("");
        },
        success:function (readData) {
          var dataResult = JSON.parse(readData);
          $("#password_error").html("");
          $("#password_pending").html("");
          $("#password_success").html("");
          if (dataResult.password.value == "Too weak") {
            $("#password_error").html("Too weak");
          }
          else if (dataResult.password.value == "Weak") {
            $('#signup').attr('disabled', false);
            $("#password_pending").html("Weak");
          }
          else if (dataResult.password.value == "Strong") {
            $('#signup').attr('disabled', false);
            $("#password_success").html("Strong");
          }
          else {
            $('#signup').attr('disabled', false);
            $("#password_success").html("Very Strong");
          }
        }
      });
    }
  }

</script>
<?php
$db_connect = "";
include "db_connect.php";

if(isset($_SESSION['user_id'])) {
  header("Location: index.php");
}
$error = false;
if (isset($_POST['signup'])) {
  $name = $db_connect -> real_escape_string($_POST['name']);
  $email = $db_connect -> real_escape_string($_POST['email']);
  $password = $db_connect -> real_escape_string($_POST['password']);
  $cpassword = $db_connect -> real_escape_string($_POST['cpassword']);
  if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = true;
    $uname_error = "Name must contain only alphabets and space";
  }
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $email_error = "Please Enter Valid Email ID";
  }

//  $checkExistingEmail = $db_connect -> query("SELECT * FROM user WHERE email = '" . $email. "'");
//  if ($checkExistingEmail -> num_rows > 0) {
//    $error = true;
//    $email_error = "Email existed...Please use another email!";
//  }

  if (strlen($password) < 6) {
    $error = true;
    $password_error = "Password must be minimum of 6 characters";
  }
  if ($password != $cpassword) {
    $error = true;
    $cpassword_error = "Password and Confirm Password doesn't match";
  }
  if (!$error) {
    if ($db_connect -> query("INSERT INTO user(username, email, password) VALUES('" . $name . "', '" . $email . "', '" . password_hash($password, PASSWORD_DEFAULT) . "')")) {
      $success_message = "Successfully Registered! <a href='login.php'>Click here to Login</a>";
    }
    else {
      $error_message = "Error in registering...Please try again later!";
    }
  }
}
?>
<body>
<div class="container">
<!--  <h2>Example: Login and Registration Script with PHP, MySQL</h2>-->
  <div class="row">
    <div class="col-2"></div>
    <div class="col-md-8 col-md-offset-8 well">
      <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="signupform" id="signupform">
<!--      <form method="post" id="signupform">-->
        <fieldset>
          <legend>Sign Up</legend>
          <div class="form-group">
            <label for="name">Name</label>
            <div class="row">
              <div class="col-8">
                <input type="text" name="name" placeholder="Enter Full Name" required value="<?php if($error) echo $name;?>" class="form-control" />
              </div>
              <div class="col-4">
                <span class="text-danger"><?php if (isset($uname_error)) echo $uname_error;?></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="name">Email</label>
            <div class="row">
              <div class="col-8">
                <input type="text" name="email" id="email" placeholder="Email" required value="<?php if($error) echo $email;?>" class="form-control" onchange="read_a_user()" />
              </div>
              <div class="col-4">
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error;?></span>
                <span class="text-danger" id="email_error"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="name">Password</label>
            <div class="row">
              <div class="col-8">
                <input type="password" name="password" id="password" placeholder="Password" required class="form-control" onchange="check_password()" />
              </div>
              <div class="col-4">
                <span class="text-danger"><?php if (isset($password_error)) echo $password_error;?></span>
                <span class="text-warning" id="password_pending"></span>
                <span class="text-success" id="password_success"></span>
                <span class="text-danger" id="password_error"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="name">Confirm Password</label>
            <div class="row">
              <div class="col-8">
                <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
              </div>
              <div class="col-4">
                <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error;?></span>
              </div>
            </div>
          </div>
          <div class="form-group pt-3">
            <input type="submit" name="signup" id="signup" value="Sign Up" class="btn btn-primary" disabled/>
          </div>
        </fieldset>
      </form>
      <span class="text-success"><?php if (isset($success_message)) { echo $success_message; }?></span>
      <span class="text-danger"><?php if (isset($error_message)) { echo $error_message; }?></span>
    </div>
    <div class="col-2"></div>
  </div>
  <div class="row">
    <div class="col-2"></div>
    <div class="col-md-8 col-md-offset-8 text-center">
      Already Registered? <a href="login.php">Login Here</a>
    </div>
    <div class="col-2"></div>
  </div>
</div>
</body>
</html>