<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['token'])) {
    echo "No token provided!";
    exit();
}

$token = $_GET['token'];

// Verificăm tokenul
$stmt = $conn->prepare("SELECT user_id FROM users WHERE confirmation_token = ? AND is_confirmed = 0 LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Confirmăm contul
    $stmt->close();

    $updateStmt = $conn->prepare("UPDATE users SET is_confirmed = 1, confirmation_token = NULL WHERE confirmation_token = ?");
    $updateStmt->bind_param("s", $token);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Your account has been successfully confirmed! You can now <a href='account.php'>log in</a>.";
    } else {
        echo "An error occurred while confirming your account.";
    }
    $updateStmt->close();

} else {
    echo "Invalid or already used token!";
}

$conn->close();
