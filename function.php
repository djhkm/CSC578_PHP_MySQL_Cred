<?php
$db_connect = "";
include "db_connect.php";

if ($_POST['type'] == 'read_a_user') {

  $email = $db_connect -> real_escape_string($_POST['email']);

  $checkExistingEmail = $db_connect -> query("SELECT * FROM user WHERE email = '" . $email. "'");
  if ($checkExistingEmail -> num_rows > 0) {
    echo json_encode(array(
        "statusCode" => 200
    ));
  }
  else {
    echo json_encode(array(
        "statusCode" => 404
    ));
  }
}
?>