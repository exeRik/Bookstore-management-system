<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}

if (isset($_POST['add_to_cart'])) {
  $pro_name = $_POST['product_name'];
  $pro_price = $_POST['product_price'];
  $pro_quantity = $_POST['product_quantity'];
  $pro_image = $_POST['product_image'];

  $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'") or die('query failed');

  if (mysqli_num_rows($check) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES ('$user_id', '$pro_name', '$pro_price', '$pro_quantity', '$pro_image')") or die('query2 failed');
    $message[] = 'Product added to cart!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="home.css" />
</head>

<body>

  <?php include 'user_header.php'; ?>

  <section class="home_cont">
    <div class="main_descrip">
      <h1>The Bookshelf</h1>
      <p>Discover and own books that inspire you</p>
      <button><a href="shop.php" style="text-decoration: none; color: black;">Discover More</a></button>
    </div>
  </section>

  <section class="products_cont">
    <div class="pro_box_cont">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');

      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
          <form action="" method="post" class="pro_box">
            <img src="./uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="<?php echo htmlspecialchars($fetch_products['name']); ?>" />
            <h3><?php echo htmlspecialchars($fetch_products['name']); ?></h3>
            <p>Rs. <?php echo number_format($fetch_products['price']); ?>/-</p>

            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>" />
            <input type="number" name="product_quantity" min="1" value="1" />
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>" />
            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>" />

            <input type="submit" value="Add to Cart" name="add_to_cart" class="product_btn" />
          </form>
      <?php
        }
      } else {
        echo '<p class="empty">No products added yet!!</p>';
      }
      ?>
    </div>
  </section>

  <section class="about_cont">
    <img src="about.jpg" alt="About Bookiee" />
    <div class="about_descript">
      <h2>Discover Our Story</h2>
     <p>Bookiee is your go-to place to buy books that inform, inspire, and ignite curiosity. We make discovering great reads simple and enjoyable for every book lover. With fast delivery and personalized service, your next favorite book is just a click away.</p>
      <button class="product_btn" onclick="window.location.href='about.php';">Read More</button>
    </div>
  </section>

  <section class="questions_cont">
    <div class="questions">
      <h2>Have Any Queries?</h2>
      <p>
        At Bookiee, we value your satisfaction and strive to provide exceptional customer service.
        If you have any questions, concerns, or inquiries, our dedicated team is here to assist you every step of the way.
      </p>
      <button class="product_btn"><a href="contact.php" style="text-decoration: none; color: white;">Contact Us</a></button>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <script src="script.js"></script>

</body>

</html>
