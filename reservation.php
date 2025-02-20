<?php
// ... codul tău de început, include 'header.php', include 'db.php', etc.
require_once 'vendor/autoload.php'; // Autoload Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'header.php';
include 'db.php';
// Verificăm dacă userul este logat și dacă a trimis formularul de rezervare
if(isset($_SESSION['user_id']) && isset($_POST['make_reservation'])){
    $user_id = (int)$_SESSION['user_id'];

    // Preluăm emailul userului (pentru a trimite confirmarea)
    $u = $conn->query("SELECT email FROM users WHERE user_id=$user_id");
    $user_email = "";
    if($u && $u->num_rows > 0){
        $ur = $u->fetch_assoc();
        $user_email = $ur['email'];
    }

    // Preluăm datele din formular
    $date = $_POST['date'];
    $time = $_POST['time'];
    $persons = (int)$_POST['persons'];
    $details = $conn->real_escape_string($_POST['details']);

    // Exemplu logică simplă pentru disponibilitate
    $sqlCheck = "SELECT COUNT(*) as count FROM Reservations 
                 WHERE reservation_date='$date' 
                 AND reservation_time='$time'
                 AND status IN ('pending','confirmed')";
    $resCheck = $conn->query($sqlCheck);
    $countRow = $resCheck->fetch_assoc();
    
    // Să zicem că avem doar 10 mese per interval
    if($countRow['count'] >= 10){
        echo "<div class='alert alert-danger'>Ne pare rău, nu mai avem mese disponibile la data și ora selectată.</div>";
    } else {
        // Inserăm rezervarea
        $sqlIns = "INSERT INTO Reservations (user_id, reservation_date, reservation_time, persons, details, status, created_at)
                   VALUES ($user_id, '$date', '$time', $persons, '$details','pending', NOW())";
        if($conn->query($sqlIns)){
            $reservation_id = $conn->insert_id;

          

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = "smtp.gmail.com";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->Username   = "mihaileduardcaltun@gmail.com"; 
                $mail->Password   = "pkov tybw juln iazf";

                $mail->isHTML(true);
                $mail->setFrom("mihaileduardcaltun@gmail.com", "Yemeni Restaurant");
                $mail->addAddress($user_email);

                $mail->Subject = "Confirmare rezervare #$reservation_id";
                // Poți personaliza conținutul emailului după preferințe
                $mail->Body = "<p>Bună,</p>
                               <p>Rezervarea ta a fost înregistrată cu succes!</p>
                               <p><strong>ID rezervare:</strong> $reservation_id</p>
                               <p><strong>Data:</strong> $date</p>
                               <p><strong>Ora:</strong> $time</p>
                               <p><strong>Număr de persoane:</strong> $persons</p>
                               <p><em>Dacă nu ai solicitat această rezervare, te rugăm să ignori acest email.</em></p>";

                $mail->send();
                echo "<div class='alert alert-success'>Rezervarea a fost creată și un email de confirmare a fost trimis la $user_email.</div>";
            } catch (Exception $e){
                echo "<div class='alert alert-danger'>Eroare la trimiterea emailului. Mailer Error: ".$mail->ErrorInfo."</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Eroare la crearea rezervării: ".$conn->error."</div>";
        }
    }
}
?>


<div class="container my-5">
    <h2>Rezervă o masă</h2>
    <p>Completează detaliile de mai jos pentru a face o rezervare la restaurantul nostru.</p>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="date" class="form-label">Data:</label>
            <input type="date" name="date" id="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Ora:</label>
            <input type="time" name="time" id="time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="persons" class="form-label">Număr de persoane:</label>
            <input type="number" name="persons" id="persons" class="form-control" required min="1" max="20">
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Detalii suplimentare:</label>
            <textarea name="details" id="details" class="form-control" rows="3" placeholder="Ex: Preferințe meniu, scaun copil, etc."></textarea>
        </div>
        <button type="submit" name="make_reservation" class="btn btn-primary">Trimite rezervarea</button>
    </form>
</div>

<?php include 'footer.php'; ?>
