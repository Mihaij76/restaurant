<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "restaurant_db";
?>
