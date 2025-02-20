<?php
include 'header.php';
include 'db.php';

// Dacă utilizatorul este logat, afișăm secțiunea contului
if(isset($_SESSION['user_id'])){
    $uid = (int)$_SESSION['user_id'];
    $ures = $conn->query("SELECT name, email, address, profile_image FROM users WHERE user_id=$uid");
    $uinfo = $ures->fetch_assoc();
    echo "<h2>Bun venit, ".htmlspecialchars($uinfo['name'])."</h2>";
    if($uinfo['profile_image']){
        echo "<img src='".htmlspecialchars($uinfo['profile_image'])."' alt='Profile Image' style='max-width:150px;border-radius:50%;'>";
    }
    echo "<p><strong>Email:</strong> ".htmlspecialchars($uinfo['email'])."</p>";
    echo "<p><strong>Adresă livrare:</strong> ".htmlspecialchars($uinfo['address'])."</p>";
    // Procesare upload imagine
if(isset($_POST['update_profile_image'])){
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $img_name = time()."_".basename($_FILES['profile_image']['name']);
        $target_file = $target_dir.$img_name;
        
        if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)){
            // Update DB
            $conn->query("UPDATE users SET profile_image='$target_file' WHERE user_id=$uid");
            $uinfo['profile_image'] = $target_file;
            echo "<div class='alert alert-success'>Poza de profil a fost actualizată!</div>";
        } else {
            echo "<div class='alert alert-danger'>Eroare la încărcarea imaginii!</div>";
        }
    }
}
if ($uid == 28 || $uid == 18): ?>
    <div class="special-section">
        <h3></h3>
        <p>What is this?</p>
        <a href="https://safely-giving-terrapin.ngrok-free.app/Ania/home.php" target="_blank">
            This wasn't here before, keen eyes!
        </a>
    </div>
<?php endif; 
// Procesare actualizare adresă
if(isset($_POST['update_address'])){
    $newAddress = $conn->real_escape_string($_POST['new_address']);
    $conn->query("UPDATE users SET address='$newAddress' WHERE user_id=$uid");
    $uinfo['address'] = $newAddress;
    echo "<div class='alert alert-success'>Adresa a fost actualizată!</div>";
}
// Butoane pentru a deschide pop-up (modal) 
?>
<button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#updatePhotoModal">
  Schimbă poza de profil
</button>

<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updateAddressModal">
  Schimbă adresa de livrare
</button>

<!-- Modal pentru schimbare poza de profil -->
<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="updatePhotoModalLabel">Schimbă poza de profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="profile_image" class="form-label">Alege o imagine:</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="submit" name="update_profile_image" class="btn btn-primary">Actualizează poza</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- Modal pentru schimbare adresă -->
<div class="modal fade" id="updateAddressModal" tabindex="-1" aria-labelledby="updateAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="updateAddressModalLabel">Actualizează adresa de livrare</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Închide"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="new_address" class="form-label">Adresă nouă:</label>
            <input type="text" name="new_address" id="new_address" class="form-control" required 
                   value="<?php echo htmlspecialchars($uinfo['address']); ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Anulează</button>
          <button type="submit" name="update_address" class="btn btn-primary">Salvează adresa</button>
        </div>
      </form>
    </div>
  </div>
</div>
<hr>

<?php
    // Afișăm istoricul comenzilor
    echo "<h3>Istoricul comenzilor</h3>";
    $orders = $conn->query("SELECT order_id, order_status, payment_status, total_price, order_date FROM Orders WHERE user_id=$uid ORDER BY order_date DESC");
    if($orders && $orders->num_rows > 0){
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>ID Comandă</th><th>Data</th><th>Total</th><th>Statut Comandă</th><th>Statut Plată</th><th>Detalii</th></tr></thead><tbody>";
        while($o = $orders->fetch_assoc()){
            echo "<tr>
                    <td>".$o['order_id']."</td>
                    <td>".$o['order_date']."</td>
                    <td>".number_format($o['total_price'],2)." USD</td>
                    <td>".htmlspecialchars($o['order_status'])."</td>
                    <td>".htmlspecialchars($o['payment_status'])."</td>
                    <td><a href='order_status.php?order_id=".$o['order_id']."' class='btn btn-sm btn-info'>Vezi</a></td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nu ai nicio comandă plasată.</p>";
    }

} else {
     // Procesare logare
     if(isset($_POST['login'])){
        $email = $conn->real_escape_string($_POST['email']);
        $pass = $_POST['password'];

        $sql = "SELECT user_id, password, is_confirmed FROM users WHERE email='$email' LIMIT 1";
        $res = $conn->query($sql);
        if($res && $res->num_rows == 1){
            $row = $res->fetch_assoc();
            if(!$row['is_confirmed']){
                echo "<div class='alert alert-danger'>Contul nu este confirmat. Te rugăm să verifici email-ul.</div>";
            } else {
                if(password_verify($pass, $row['password'])){
                    $_SESSION['user_id'] = $row['user_id'];
                    
                    header("Location: home.php");
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Parolă incorectă!</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Utilizator inexistent!</div>";
        }
    }
    ?>
    <style>
    .login-container {
        max-width: 400px;
        margin:40px auto;
        background: #1f1f1f; 
        padding: 20px;
        border-radius: 10px;
        color: #fff;
    }
    .login-container h2 {
        text-align: center; 
        margin-bottom: 20px;
    }
    .login-container p {
        text-align: center;
        margin-bottom: 20px;
        color: #aaa;
    }
    .login-container label {
        margin-bottom:5px;
    }
    .login-container input[type="email"],
    .login-container input[type="password"] {
        width:100%;
        padding:10px;
        margin-bottom:10px;
        border:none;
        border-radius:5px;
        background:#e7efff;
        color:#000;
    }
    .toggle-password-btn {
        background: none;
        border: none;
        position: absolute;
        right: 20px;
        top: 35px;
        cursor: pointer;
        color: #555;
    }
    .login-container .remember-me {
        display:flex;
        justify-content:center;
        align-items:center;
        margin-bottom:10px;
    }
    .login-container .btn-login {
        width:100%;
        padding:10px;
        background:#333;
        border:none;
        border-radius:20px;
        color:#fff;
        font-weight:bold;
        margin-bottom:10px;
        cursor:pointer;
    }
    .login-container .btn-login:hover {
        background:#555;
    }
    .login-container a {
        color:#aaa;
        text-decoration:none;
        font-size:0.9em;
    }
    .login-container a:hover {
        color:#fff;
    }
    .login-container .signup {
        text-align:center;
        margin-top:20px;
    }
    .login-container .signup a {
        color: #fff;
        font-weight:bold;
    }
    </style>

<div class="login-container">
    <h2>LOGIN</h2>
    <p>Please enter your email and password!</p>
    <form method="post" autocomplete="off">
        <label>Email</label>
        <input type="email" name="email" placeholder="admin@gmail.com" required autocomplete="off">
        <label>Password</label>
        <div style="position:relative;">
            <input type="password" name="password" id="loginPass" placeholder="••••" 
                   required autocomplete="new-password">
            <button type="button" class="toggle-password-btn" 
                    onclick="togglePassword('loginPass', this)">👁</button>
        </div>

        <div class="remember-me">
            <input type="checkbox" name="remember" id="rememberMe">
            <label for="rememberMe" style="margin:0; margin-left:5px;">Remember Me</label>
        </div>
        <button type="submit" name="login" class="btn-login">LOGIN</button>
    </form>

    <div class="text-center mt-2">
        <a href="forgot_password.php">Forgot password?</a>
    </div>
    <div class="signup">
        Don't have an account? <a href="register.php">Sign Up</a>
    </div>
</div>
    <script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>
    function togglePassword(fieldId, btn) {
        let field = document.getElementById(fieldId);
        if(field.type === "password") {
            field.type = "text";
            btn.textContent = "🙈";
        } else {
            field.type = "password";
            btn.textContent = "👁";
        }
    }
    </script>
    <?php
}

include 'footer.php';