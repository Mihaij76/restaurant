<?php
include 'header.php';
include 'db.php';

if(!isset($_GET['token'])){
    echo "<div class='alert alert-danger'>Token invalid!</div>";
    include 'footer.php';
    exit;
}

$token = $conn->real_escape_string($_GET['token']);
$res = $conn->query("SELECT user_id, reset_expires FROM users WHERE reset_token='$token' LIMIT 1");
if(!$res || $res->num_rows==0){
    echo "<div class='alert alert-danger'>Token invalid sau expirat!</div>";
    include 'footer.php';
    exit;
}
$row = $res->fetch_assoc();
if(strtotime($row['reset_expires']) < time()){
    echo "<div class='alert alert-danger'>Token expirat!</div>";
    include 'footer.php';
    exit;
}

if(isset($_POST['reset_password'])){
    $pass = $_POST['password'];
    $conf = $_POST['confirm_password'];

    if($pass === $conf){
        // Validare parolă
        if(strlen($pass)<8 || !preg_match('/[A-Z]/',$pass) || !preg_match('/[a-z]/',$pass) || !preg_match('/\d/',$pass)){
            echo "<div class='alert alert-danger'>Parola trebuie să aibă minim 8 caractere, o literă mare, una mică și o cifră.</div>";
        } else {
            $hashed = password_hash($pass, PASSWORD_BCRYPT);
            $uid = $row['user_id'];
            $conn->query("UPDATE users SET password='$hashed', reset_token=NULL, reset_expires=NULL WHERE user_id=$uid");
            echo "<div class='alert alert-success'>Parola a fost resetată cu succes! <a href='account.php'>Loghează-te</a></div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Parolele nu coincid!</div>";
    }
}
?>

<h2>Resetează parola</h2>
<form method="post">
    <div class="mb-3" style="position:relative;">
        <label>Parolă nouă:</label>
        <input type="password" name="password" id="newPass" class="form-control" required>
        <button type="button" class="toggle-password-btn" style="position:absolute;right:10px;top:35px;background:none;border:none;" onclick="togglePassword('newPass', this)">👁</button>
    </div>
    <div class="mb-3" style="position:relative;">
        <label>Confirmă parola:</label>
        <input type="password" name="confirm_password" id="confirmPass" class="form-control" required>
        <button type="button" class="toggle-password-btn" style="position:absolute;right:10px;top:35px;background:none;border:none;" onclick="togglePassword('confirmPass', this)">👁</button>
    </div>
    <button type="submit" name="reset_password" class="btn btn-primary">Resetează parola</button>
</form>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
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

<?php include 'footer.php'; ?>
