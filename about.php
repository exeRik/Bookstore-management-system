<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="home.css" />
</head>
<body>

  <?php include 'user_header.php'; ?>

  <section class="about_cont">
    <img src="about1.jpg" alt="About Bookiee" />
    <div class="about_descript">
      <h2>Why Trust Bookiee?</h2>
       <p>Bookiee offers a wide and diverse selection of books across all genres to satisfy every reader’s unique interests and tastes. Whether you're seeking educational resources to expand your knowledge, timeless classics that have shaped literature, or contemporary works that reflect today’s world, our platform provides seamless access and reliable delivery throughout Nepal. We take pride in assembling an extensive collection that meets the needs of all ages and reading levels, ensuring there’s something special for everyone. Our dedicated team is committed to helping you find the perfect book, offering personalized support and excellent service every step of the way. At Bookiee, we believe in the empowering influence of books — to inspire imagination, foster learning, and connect communities. Join us in celebrating the joy of reading and discover how a great book can open new doors, spark creativity, and bring people closer together.</p>
    </div>
  </section>

  <section class="questions_cont">
    <div class="questions">
      <h2>Have Any Queries?</h2>
      <p>
        At Bookiee, we value your satisfaction and strive to provide exceptional customer service.
        If you have any questions, concerns, or inquiries, our dedicated team is here to assist you every step of the way.
      </p>
      <button class="product_btn" onclick="window.location.href='contact.php'">Contact Us</button>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <script src="script.js"></script>

</body>
</html>
