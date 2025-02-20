<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id'])){
    echo "<div class='alert alert-info'>Trebuie să fii logat pentru a vedea statutul comenzii.</div>";
    include 'footer.php';
    exit;
}

if(!isset($_GET['order_id'])){
    echo "<div class='alert alert-warning'>Nicio comandă specificată.</div>";
    include 'footer.php';
    exit;
}

$order_id = (int)$_GET['order_id'];
$user_id = (int)$_SESSION['user_id'];

$res = $conn->query("SELECT order_status, payment_status, total_price, order_date, delivery_address FROM Orders WHERE order_id=$order_id AND user_id=$user_id");
if(!$res || $res->num_rows==0){
    echo "<div class='alert alert-danger'>Comanda nu există sau nu aparține acestui utilizator.</div>";
    include 'footer.php';
    exit;
}

$order = $res->fetch_assoc();

// Afișăm statutul
?>
<h2>Statut Comandă #<?php echo $order_id; ?></h2>
<p><strong>Data comenzii:</strong> <?php echo $order['order_date']; ?></p>
<p><strong>Adresa de livrare:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
<p><strong>Total:</strong> <?php echo number_format($order['total_price'],2); ?> USD</p>
<p><strong>Statut comandă:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
<p><strong>Statut plată:</strong> <?php echo htmlspecialchars($order['payment_status']); ?></p>

<?php
// Produsele din comandă
$item_res = $conn->query("SELECT oi.quantity, oi.subtotal_price, m.name FROM Order_Items oi
                          JOIN Menu_Items m ON m.menu_item_id=oi.menu_item_id
                          WHERE oi.order_id=$order_id");
if($item_res && $item_res->num_rows > 0):
?>
<h3>Produse din comandă</h3>
<table class="table table-bordered">
    <thead><tr><th>Produs</th><th>Cantitate</th><th>Subtotal</th></tr></thead>
    <tbody>
    <?php while($item = $item_res->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo number_format($item['subtotal_price'],2); ?> USD</td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php endif; ?>
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
