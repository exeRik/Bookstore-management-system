<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit();
}

// ✅ Update cart quantity
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = max(1, intval($_POST['cart_quantity'])); // ensure at least 1

    $stmt = $conn->prepare("UPDATE `cart` SET quantity=? WHERE id=? AND user_id=?");
    $stmt->bind_param("iii", $cart_quantity, $cart_id, $user_id);
    $stmt->execute();
    $stmt->close();

    $message[] = 'Cart quantity updated!';
}

// ✅ Delete single item
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM `cart` WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    $stmt->close();

    header('Location: cart.php');
    exit();
}

// ✅ Delete all items
if (isset($_GET['delete_all'])) {
    $stmt = $conn->prepare("DELETE FROM `cart` WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="home.css">
</head>
<body>
  
<?php include 'user_header.php'; ?>

<section class="shopping_cart">
  <h1>Your Shopping Cart</h1>

  <div class="cart_box_cont">
    <?php
    $grand_total = 0;
    $stmt = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($fetch_cart = $result->fetch_assoc()) {
            $sub_total = $fetch_cart['quantity'] * $fetch_cart['price'];
            $grand_total += $sub_total;
    ?>
        <div class="cart_box">
          <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" 
             class="fas fa-times" 
             onclick="return confirm('Are you sure you want to delete this product?');"></a>

          <img src="./uploaded_img/<?php echo htmlspecialchars($fetch_cart['image']); ?>" alt="Product">

          <h3><?php echo htmlspecialchars($fetch_cart['name']); ?></h3>
          <p>Price: Rs. <?php echo number_format($fetch_cart['price']); ?>/-</p>

          <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" name="cart_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" value="Update" name="update_cart" class="product_btn">
          </form>

          <p>Subtotal: <span>Rs. <?php echo number_format($sub_total); ?>/-</span></p>
        </div>
    <?php
        }
    } else {
        echo '<p class="empty">Your Cart is Empty!</p>';
    }
    $stmt->close();
    ?>
  </div>

  <div class="cart_total">
    <h2>Total Cart Price: <span>Rs. <?php echo number_format($grand_total); ?>/-</span></h2>
    <div class="btns_cart">
      <a href="cart.php?delete_all" 
         class="product_btn <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>" 
         onclick="return confirm('Are you sure you want to delete all cart items?');">
         Delete All
      </a>
      <a href="shop.php" class="product_btn">Continue Shopping</a>
      <a href="checkout.php" 
         class="product_btn <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>">
         Checkout
      </a>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
<script src="script.js"></script>

</body>
</html>
