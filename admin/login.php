<?php
session_start();
require_once "../includes/db.php";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];}

   try{
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: dashboard.php");
            exit;

        } else {

            echo "Incorrect Password!";

        }

    } else {

        echo "Username not found!";

    }
}
catch(PDOException $e){
    $error_message ="Database Error:" . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MtaaMarket - Admin Login</title>

    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<div class="card">
    <h1>Admin Login</h1>

    <p>Sign in to manage your storefront inventory.</p>
     <?php if(!empty($error_message)):?>
        <?php endif; ?>
    <form action="" method="POST">

        <input
            type="text"
            name="username"
            placeholder="Username"
            required>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>
            



</div>

</body>
</html>