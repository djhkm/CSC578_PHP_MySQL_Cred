<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'csc578_php_mysql_login';

$db_connect = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ($db_connect -> connect_errno) {
  echo 'Failed to connect to MySQL: ' . $db_connect -> connect_error;
  exit();
}
?>