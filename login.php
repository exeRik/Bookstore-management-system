<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $raw_password = $_POST['password'];

    // Hardcoded admin credentials (plain text)
    $admin_email = 'admin@example.com';
    $admin_password = 'admin123';

    if ($email === $admin_email && $raw_password === $admin_password) {
        // Admin login successful
        $_SESSION['admin_name'] = 'Admin';
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_id'] = 0;
        header('location:admin_page.php');
        exit();
    }

    // Normal user login (password stored as MD5 in DB)
    $hashed_password = md5($raw_password);
    $select_users = mysqli_query($conn, "SELECT * FROM `register` WHERE email='$email' AND password='$hashed_password'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
        exit();
    } else {
        $message[] = 'Incorrect email or password';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="login.css">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>
    ';    
    }
    
}
?>


<div class="box login_box">
    <span class="borderline"></span>
    <form action="" method="post">
    <h2>Login</h2>

        <div class="inputbox">
            <input type="email" name="email" required="required">
            <span>Email</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>
        
        <div class="links">
            <a href="#">Forgot Password</a>
            <a href="register.php">Sign in</a>
        </div>

        <input type="submit" value="Login" name="submit">
    </form>
</div>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</body>
</html>