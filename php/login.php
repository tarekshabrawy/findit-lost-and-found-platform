<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: feed.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - FindIt</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card" style="max-width: 450px; margin: 80px auto;">
        <h1 class="page-title">Login</h1>

        <form action="auth_process.php" method="POST">
            <input type="hidden" name="action" value="login">

            <label>Email or Admin Username</label>
            <input type="text" name="email" placeholder="Email or admin" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don’t have an account? <a href="register.php">Register</a></p>
    </div>
</div>

<script src="../js/menu.js"></script>
<script src="../js/auth.js"></script>
</body>
</html>