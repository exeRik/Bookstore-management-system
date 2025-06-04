<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();" aria-label="Close message"></i>
        </div>
        ';
    }
}
?>
<header class="user_header">
  <div class="header_1">
    <div class="user_flex">

      <!-- Logo and Brand -->
      <div class="logo_cont">
        <img src="book_logo.png" alt="Bookie Logo">
        <a href="home.php" class="book_logo">Bookie</a>
      </div>

      <!-- Navbar -->
      <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Contact</a>
        <a href="orders.php">Orders</a>
      </nav>

      <!-- Login/Register & Icons -->
      <div class="last_part">
        <div class="loginorreg">
          <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
        </div>

        <div class="icons">
          <a class="fa-solid fa-magnifying-glass" href="search_page.php" aria-label="Search"></a>

          <div class="fas fa-user" id="user_btn" aria-label="User Menu"></div>

          <?php
          $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
          $cart_row_number = mysqli_num_rows($select_cart_number);
          ?>
          <a href="cart.php" aria-label="Cart">
            <i class="fas fa-shopping-cart"></i>
            <span class="quantity">(<?php echo $cart_row_number ?>)</span>
          </a>

          <div class="fas fa-bars" id="user_menu_btn" aria-label="Menu"></div>
        </div>
      </div>

      <!-- User Account Info -->
      <div class="header_acc_box">
        <p>Username : <span><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?></span></p>
        <p>Email : <span><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'Not Available'; ?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
      </div>

    </div>
  </div>
</header>
