<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'ro', 
      includedLanguages: 'en,ro,fr,it,es,ar', 
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<?php 
include 'header.php'; 
include 'db.php';

if(!isset($_SESSION['user_id'])){
    echo "<div class='alert alert-info'>Trebuie să fii logat pentru a vedea coșul!</div>";
    include 'footer.php';
    exit;
}

/* 1) Verificăm dacă se cere actualizarea cantității (update_qty) */
if(isset($_POST['update_qty'])){
    $item_id = (int)$_POST['item_id'];
    $new_qty = (int)$_POST['qty'];
    if($new_qty < 1) $new_qty = 1;
    if(isset($_SESSION['cart'][$item_id])){
        $_SESSION['cart'][$item_id] = $new_qty;
        echo "<div class='alert alert-success'>Cantitatea a fost actualizată!</div>";
    }
}

/* 2) Adăugare în coș - (caz în care se vine direct în cart cu POST add_to_cart) */
if(isset($_POST['add_to_cart'])){
    $item_id = (int)$_POST['item_id'];
    $qty = (int)$_POST['quantity'];
    if($qty < 1) $qty = 1;

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if(isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $qty;
    } else {
        $_SESSION['cart'][$item_id] = $qty;
    }
    echo "<div class='alert alert-success'>Produs adăugat în coș!</div>";
}

/* 3) Ștergere produs */
if(isset($_GET['remove'])){
    $rid = (int)$_GET['remove'];
    if(isset($_SESSION['cart'][$rid])){
        unset($_SESSION['cart'][$rid]);
        echo "<div class='alert alert-info'>Produs șters din coș!</div>";
    }
}

/* 4) Plasare comandă */
if(isset($_POST['place_order'])){
    if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
        echo "<div class='alert alert-warning'>Coș gol!</div>";
    } else {
        $total_price = 0;
        foreach($_SESSION['cart'] as $id=>$q){
            $res = $conn->query("SELECT price FROM Menu_Items WHERE menu_item_id=$id");
            $r = $res->fetch_assoc();
            $total_price += $r['price'] * $q;
        }
        $uid = $_SESSION['user_id'];
        $ures = $conn->query("SELECT address FROM Users WHERE user_id=$uid");
        $urow = $ures->fetch_assoc();
        $address = $conn->real_escape_string($urow['address']);
        
        // Creăm comanda cu payment_status = 'unpaid'
        $sql = "INSERT INTO Orders (user_id,order_status,order_date,total_price,delivery_address,payment_status,created_at,updated_at) 
                VALUES ($uid,'pending',CURDATE(),$total_price,'$address','unpaid',NOW(),NOW())";
        if($conn->query($sql)){
            $order_id = $conn->insert_id;
            foreach($_SESSION['cart'] as $id=>$q){
                $res = $conn->query("SELECT price FROM Menu_Items WHERE menu_item_id=$id");
                $r = $res->fetch_assoc();
                $subtotal = $r['price'] * $q;
                $conn->query("INSERT INTO order_items (order_id,menu_item_id,quantity,subtotal_price) VALUES ($order_id,$id,$q,$subtotal)");
            }
            
            // Golește coșul
            unset($_SESSION['cart']);
            // Redirecționăm către checkout pentru a alege metoda de plată
            $_SESSION['current_order_id'] = $order_id;
            header("Location: checkout.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Eroare la plasarea comenzii: ".$conn->error."</div>";
        }
    }
}

echo "<h2>Coșul tău</h2>";

/* 5) Afișare coș */
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    echo "<div class='alert alert-info'>Coșul este gol.</div>";
} else {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Produs</th><th>Cantitate</th><th>Preț</th><th>Total</th><th>Acțiuni</th></tr></thead><tbody>";
    $sum=0;
    foreach($_SESSION['cart'] as $id=>$q){
        $res = $conn->query("SELECT name, price FROM Menu_Items WHERE menu_item_id=$id");
        $r = $res->fetch_assoc();
        $line_total = $r['price'] * $q;
        $sum += $line_total;
        echo "<tr>
                <td>".htmlentities($r['name'])."</td>
                <td>
                  <form method='post' style='display:inline-block; width:110px;'>
                    <input type='hidden' name='item_id' value='$id'>
                    <div class='input-group'>
                      <input type='number' name='qty' class='form-control form-control-sm' value='$q' min='1'>
                      <button type='submit' name='update_qty' class='btn btn-sm btn-outline-secondary'>Ok</button>
                    </div>
                  </form>
                </td>
                <td>".number_format($r['price'],2)." USD</td>
                <td>".number_format($line_total,2)." USD</td>
                <td>
                  <a href='cart.php?remove=$id' class='btn btn-sm btn-outline-danger'>Șterge</a>
                </td>
              </tr>";
    }
    echo "<tr>
            <td colspan='3' class='text-end'><strong>Total:</strong></td>
            <td><strong>".number_format($sum,2)." USD</strong></td>
            <td></td>
          </tr>";
    echo "</tbody></table>";
    echo "<form method='post'><button type='submit' name='place_order' class='btn btn-primary'>Plasează comanda</button></form>";
}

include 'footer.php';
?>
