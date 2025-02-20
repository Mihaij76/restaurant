<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id']) || !isset($_SESSION['current_order_id'])){
    header("Location: home.php");
    exit;
}

$order_id = (int)$_SESSION['current_order_id'];
$user_id = (int)$_SESSION['user_id'];

if(!isset($_POST['payment_method'])){
    header("Location: checkout.php");
    exit;
}

$method = $_POST['payment_method'];

// Verificăm dacă comanda există și aparține userului logat
$res = $conn->query("SELECT * FROM Orders WHERE order_id=$order_id AND user_id=$user_id");
if(!$res || $res->num_rows==0){
    header("Location: home.php");
    exit;
}

// În funcție de metodă, procesăm
$amount = 0;
$order = $res->fetch_assoc();
$amount = $order['total_price'];

$payment_status = 'pending'; 
// Dacă e card sau PayPal, considerăm că plata a fost cu succes.
if($method=='card' || $method=='paypal'){
    $payment_status = 'paid';
}

// Inserăm în Payments
$sql = "INSERT INTO Payments (order_id,payment_method,payment_date,amount,status) 
        VALUES ($order_id,'$method',CURDATE(),$amount,'$payment_status')";
$conn->query($sql);

// Actualizăm și Orders.payment_status
$conn->query("UPDATE Orders SET payment_status='$payment_status' WHERE order_id=$order_id");

// După ce am procesat plata, curățăm sesiunea
unset($_SESSION['current_order_id']);

// Redirecționăm către pagina de statut
header("Location: order_status.php?order_id=$order_id");
exit;
