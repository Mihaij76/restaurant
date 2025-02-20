<?php
include 'header.php';
include 'db.php';
require __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['email'])){
    $email = $conn->real_escape_string($_POST['email']);
    $res = $conn->query("SELECT user_id FROM users WHERE email='$email' LIMIT 1");
    if($res && $res->num_rows == 1){
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', time() + 3600); // token valabil 1 ora
        $conn->query("UPDATE users SET reset_token='$token', reset_expires='$expire' WHERE email='$email'");

        // Trimite email
        $resetLink = "https://safely-giving-terrapin.ngrok-free.app/restaurant/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = "mihaileduardcaltun@gmail.com"; 
            $mail->Password = "pkov tybw juln iazf";

            $mail->isHTML(true);
            $mail->setFrom("mihaileduardcaltun@gmail.com", "Yemeni Restaurant");
            $mail->addAddress($email);

            $mail->Subject = "Resetare parolă";
            $mail->Body = "<p>Bună,</p>
                           <p>Ai solicitat resetarea parolei. Dă click pe linkul de mai jos pentru a o reseta:</p>
                           <p><a href='$resetLink'>$resetLink</a></p>
                           <p>Dacă nu ai solicitat acest lucru, poți ignora acest email.</p>";

            $mail->send();
            echo "<div class='alert alert-success'>Un email a fost trimis către adresa ta pentru resetarea parolei.</div>";
        } catch(Exception $e){
            echo "<div class='alert alert-danger'>Eroare la trimiterea emailului. Mailer Error: ".$mail->ErrorInfo."</div>";
        }
    } else {
        echo "<div class='alert alert-info'>Dacă acest email există în sistemul nostru, vei primi un email de resetare.</div>";
    }
}
?>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<h2>Ai uitat parola?</h2>
<p>Introdu adresa de email și îți vom trimite un link de resetare a parolei.</p>
<form method="post">
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Trimite link resetare</button>
</form>

<?php include 'footer.php'; ?>
