<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id'])){
    echo "<div class='alert alert-info'>Trebuie să fii logat pentru a alege metoda de plată.</div>";
    include 'footer.php';
    exit;
}

if(!isset($_SESSION['current_order_id'])){
    echo "<div class='alert alert-warning'>Nu există nicio comandă pentru care să alegeți metoda de plată.</div>";
    include 'footer.php';
    exit;
}

$order_id = (int)$_SESSION['current_order_id'];

// Verificăm dacă există comanda
$res = $conn->query("SELECT * FROM Orders WHERE order_id=$order_id AND user_id=".$_SESSION['user_id']);
if(!$res || $res->num_rows == 0){
    echo "<div class='alert alert-danger'>Comanda nu există sau nu aparține acestui utilizator.</div>";
    include 'footer.php';
    exit;
}
?>

<h2>Alege metoda de plată</h2>
<form method="post" action="payment_process.php" class="mb-4">
    <div class="mb-3">
        <label for="payment_method" class="form-label">Metoda de plată:</label>
        <select name="payment_method" id="payment_method" class="form-select" required>
            <option value="" selected disabled>Alege</option>
            <option value="cash">Numerar la livrare</option>
            <option value="card">Card</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>
    <div id="cardDetails" style="display:none;">
        <h5>Detalii card</h5>
        <div class="mb-3">
            <label for="card_number" class="form-label">Număr card</label>
            <input type="text" name="card_number" id="card_number" class="form-control" placeholder="1234 5678 9012 3456">
        </div>
        <div class="mb-3">
            <label for="card_expiry" class="form-label">Data expirare (MM/YY)</label>
            <input type="text" name="card_expiry" id="card_expiry" class="form-control" placeholder="12/25">
        </div>
        <div class="mb-3">
            <label for="card_cvv" class="form-label">CVV</label>
            <input type="text" name="card_cvv" id="card_cvv" class="form-control" placeholder="123">
        </div>
    </div>
    <div id="paypalDetails" style="display:none;">
        <h5>Cont PayPal</h5>
        <div class="mb-3">
            <label for="paypal_email" class="form-label">Email PayPal</label>
            <input type="email" name="paypal_email" id="paypal_email" class="form-control" placeholder="ex: user@paypal.com">
        </div>
    </div>
    <button type="submit" name="confirm_payment" class="btn btn-primary">Confirmă plata</button>
</form>

<script>
document.getElementById('payment_method').addEventListener('change', function(){
    var method = this.value;
    document.getElementById('cardDetails').style.display = (method=='card')?'block':'none';
    document.getElementById('paypalDetails').style.display = (method=='paypal')?'block':'none';
});
</script>
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<?php include 'footer.php'; ?>
