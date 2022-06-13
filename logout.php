<html>
<head>
  <title>Logout</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<?php
ob_start();
include "db_connect.php";

if(isset($_SESSION['user_id'])) {
  session_destroy();
  unset($_SESSION['user_id']);
  unset($_SESSION['user_name']);
  header("Location: index.php");
} else {
  header("Location: index.php");
}
?>
<body>

</body>
</html>