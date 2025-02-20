<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Restaurant Yemeni online">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabaya Yemeni Kitchen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background.jpg') no-repeat center center/cover;
        color: #fff;
        padding: 120px 0;
        text-align: center;
    }
    .hero h1 {
        font-size: 4rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }
    .hero p {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    .navbar {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .navbar-brand img {
        margin-right: 10px;
    }
    .navbar-nav .nav-link:hover {
        color: #ffc107;
    }
    .card {
        border: none;
        border-radius: 10px;
        background-color: #ffffff;
    }
    .card-title {
        font-weight: bold;
        color: #333;
    }
    footer {
        background-color: #343a40;
        color: #ffffff;
    }
    footer a {
        color: #ffc107;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <img src="img/logo.jpg" alt="Logo" style="height:40px;vertical-align:middle;"> Sabaya Yemeni Kitchen
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Comutare navigare">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!--<li class="nav-item"><a class="nav-link" href="home.php">Acasă</a></li>-->
                <li class="nav-item"><a class="nav-link" href="menu.php">Meniu</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="about.php">Despre noi</a></li> -->
                <li class="nav-item"><a class="nav-link" href="reservation.php">Rezervare</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Coș</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="account.php">Contul meu</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Delogare</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="account.php">Logare</a></li>
                <?php endif; ?>
                <li class="nav-item">
                    <div id="google_translate_element" style="margin-left:15px;"></div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">