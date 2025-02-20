<?php
require_once 'config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if($conn->connect_error){
    die("Conexiunea la BD a eșuat: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
