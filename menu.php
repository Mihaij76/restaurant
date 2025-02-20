<?php 
include 'header.php'; 
include 'db.php';
?>
<style>

.card {
    height: 100%;
}

.card-img-top {
    height: 250px;   
    width: 100%;
    object-fit: cover; 
}

.card-body {
    display: flex;
    flex-direction: column;        
    justify-content: space-between; 
}
</style>

<?php
/* 1) Dacă utilizatorul trimite formularul de "add_to_cart", actualizăm coșul în $_SESSION */
if(isset($_POST['add_to_cart']) && isset($_POST['item_id'])){
    $id = (int)$_POST['item_id'];
    $qty = (int)($_POST['quantity'] ?? 0);

    // Inițializează coșul dacă nu există
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // Adaugă / actualizează cantitatea
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    echo "<div class='alert alert-success'>Produs adăugat în coș!</div>";
}

/* 2) Verificăm dacă userul e admin (cod existent) */
$isAdmin = false;
if(isset($_SESSION['user_id'])){
    $uid = (int)$_SESSION['user_id'];
    $u = $conn->query("SELECT role FROM users WHERE user_id=$uid");
    if($u && $u->num_rows>0){
        $ur = $u->fetch_assoc();
        if($ur['role']=='admin') $isAdmin=true;
    }
}

/* 3) Ștergere item din meniu (admin) */
if(isset($_POST['delete_item']) && $isAdmin){
    $item_id = (int)$_POST['item_id'];
    $conn->query("DELETE FROM Menu_Items WHERE menu_item_id=$item_id");
    echo "<div class='alert alert-info'>Item șters!</div>";
}

/* 4) Adăugare item (admin) */
if(isset($_POST['add_item']) && $isAdmin){
    $name = $conn->real_escape_string($_POST['name']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = (float)$_POST['price'];
    $cat_id = (int)$_POST['category_id'];
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $conn->query("INSERT INTO Menu_Items (name, description, price, image_url, category_id, availability, created_at, updated_at)
                  VALUES ('$name','$desc',$price,'$image_url',$cat_id,1,NOW(),NOW())");
    echo "<div class='alert alert-success'>Item adăugat!</div>";
}

/* 5) Afișăm produse din meniu  */
$sql = "SELECT m.menu_item_id, m.name, m.description, m.price, c.name as cat_name, m.image_url 
        FROM Menu_Items m 
        LEFT JOIN Categories c ON m.category_id = c.category_id
        WHERE m.availability = 1";
$result = $conn->query($sql);

echo "<h2 class='mb-4'>Meniul nostru</h2>";

/* 5.1) Formular produse(pentru admini) */
if($isAdmin){
    ?>
    <div class="mb-3">
        <h3>Adaugă item în meniu</h3>
        <form method="post">
            <input type="text" name="name" placeholder="Nume" class="form-control mb-2" required>
            <textarea name="description" placeholder="Descriere" class="form-control mb-2" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Preț" class="form-control mb-2" required>
            <input type="text" name="image_url" placeholder="URL imagine (ex: img/chickenmandi.jpg)" class="form-control mb-2" required>
            <input type="number" name="category_id" placeholder="ID categorie" class="form-control mb-2" required>
            <button type="submit" name="add_item" class="btn btn-primary">Adaugă</button>
        </form>
    </div>
    <?php
}

/* 5.2) Afișăm cardurile cu produsele */
echo "<div class='row g-4'>";
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<div class='col-md-4'>";
        echo "  <div class='card h-100'>";
        if(!empty($row['image_url'])){
            echo "<img src='".htmlspecialchars($row['image_url'])."' class='card-img-top' alt='".htmlspecialchars($row['name'])."'>";
        } else {
            echo "<img src='img/default.jpg' class='card-img-top' alt='No image'>";
        }
        echo "    <div class='card-body'>";
        echo "      <h5 class='card-title'>".htmlspecialchars($row['name'])."</h5>";
        echo "      <p class='card-text'>".htmlspecialchars($row['description'])."</p>";
        echo "      <p><strong>Categorie:</strong> ".htmlspecialchars($row['cat_name'])."</p>";
        echo "      <p><strong>Preț:</strong> ".number_format($row['price'],2)." USD</p>";

        // Poti cumpara numai daca esti logat
        if(isset($_SESSION['user_id'])){
            echo "<form method='post' action='menu.php'>"; 
            echo "  <input type='hidden' name='item_id' value='".$row['menu_item_id']."'>";
            echo "  <div class='input-group mb-3'>";
            echo "    <input type='number' name='quantity' class='form-control' value='' min='1'>";
            echo "    <button type='submit' name='add_to_cart' class='btn btn-success'>Adaugă</button>";
            echo "  </div>";
            echo "</form>";
        } else {
            echo "<div class='alert alert-secondary p-2' role='alert'>
                    <small>Loghează-te pentru a comanda.</small>
                  </div>";
        }

        // Sterge item pt admini
        if($isAdmin){
            echo "<form method='post' onsubmit=\"return confirm('Sigur ștergi acest item?');\">";
            echo "  <input type='hidden' name='item_id' value='".$row['menu_item_id']."'>";
            echo "  <button type='submit' name='delete_item' class='btn btn-danger'>Șterge item</button>";
            echo "</form>";
        }

        echo "    </div>"; 
        echo "  </div>"; 
        echo "</div>"; 
    }
} else {
    echo "<p>Meniul este momentan indisponibil.</p>";
}
echo "</div>"; 

include 'footer.php';
