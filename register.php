<?php
include 'header.php';
include 'db.php';
require __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Procesare înregistrare
if(isset($_POST['register'])){
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    $address = $conn->real_escape_string($_POST['address']);
    
    // Validare email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<div class='alert alert-danger'>Email invalid!</div>";
    } else {
        // Verifică dacă există deja email
        $check = $conn->query("SELECT user_id FROM users WHERE email='$email' LIMIT 1");
        if($check && $check->num_rows>0){
            echo "<div class='alert alert-danger'>Adresa de email este deja utilizată!</div>";
        } else {
            // Validare parolă
            if(strlen($pass)<8 || !preg_match('/[A-Z]/',$pass) || !preg_match('/[a-z]/',$pass) || !preg_match('/\d/',$pass)){
                echo "<div class='alert alert-danger'>Parola trebuie să aibă minim 8 caractere, o literă mare, una mică și o cifră.</div>";
            } else {
                $hashed = password_hash($pass, PASSWORD_BCRYPT);
                
                // Procesare imagine de profil (opțional)
                $profile_image = NULL;
                if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
                    $target_dir = "uploads/";
                    if(!is_dir($target_dir)){
                        mkdir($target_dir, 0777, true);
                    }
                    $img_name = time()."_".basename($_FILES['profile_image']['name']);
                    $target_file = $target_dir.$img_name;
                    if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)){
                        $profile_image = $target_file;
                    }
                }

                // Generare token confirmare
                $token = bin2hex(random_bytes(32));

                // Insert utilizator cu is_confirmed=0
                $sql = "INSERT INTO users (name, email, password, address, role, profile_image, is_confirmed, confirmation_token, created_at, updated_at) 
                        VALUES ('$name','$email','$hashed','$address','customer',".($profile_image?"'$profile_image'":"NULL").",0,'$token',NOW(),NOW())";
                if($conn->query($sql)){
                    // Trimite email de confirmare
                    $user_id = $conn->insert_id;
                    $activationLink = "https://safely-giving-terrapin.ngrok-free.app/restaurant/activate.php?token=".$token;

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

                        $mail->Subject = "Confirma contul";
                        $mail->Body = "<p>Bună, $name!</p>
                                       <p>Te rugăm să dai click pe acest <a href='$activationLink'>link</a> pentru a-ți confirma contul:</p>
                                       <p>Dacă nu ai solicitat acest cont, poți ignora acest email.</p>
                                       <p>Iți urăm o zi superbă in continuare,</p>
                                       <p>Echipa restaurantului Sabaya</p>";
                        $mail->send();
                        echo "<div class='alert alert-success'>Cont creat! Te rugăm să verifici email-ul pentru a-ți confirma contul. <a href='account.php'>Loghează-te</a></div>";
                    } catch (Exception $e) {
                        echo "<div class='alert alert-warning'>Cont creat, dar nu am putut trimite emailul de confirmare. Mailer Error: ".$mail->ErrorInfo."</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Eroare la crearea contului: ".$conn->error."</div>";
                }
            }
        }
    }
}

?>

<h2>Creare cont</h2>
<form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label>Nume:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Parolă:</label>
        <input type="password" name="password" class="form-control" required>
        <small class="text-muted">Parola trebuie să aibă minim 8 caractere, o literă mare, una mică și o cifră.</small>
    </div>
    <div class="mb-3">
        <label>Adresă livrare:</label>
        <input type="text" name="address" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Imagine profil (opțional):</label>
        <input type="file" name="profile_image" class="form-control">
    </div>
    <button type="submit" name="register" class="btn btn-primary">Creează cont</button>
</form>

<?php include 'footer.php'; ?>
