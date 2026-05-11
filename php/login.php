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
  <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>Login - FindIt</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/auth.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card auth-card" style="max-width: 450px; margin: 80px auto;">
        <div class="auth-logo">
    <img src="../assets/logo.png" alt="FindIt Logo">
</div>
    <h1 class="page-title">Login</h1>
        
        <p class="page-subtitle">Welcome back to FindIt. Access your campus lost and found feed.</p>

        <?php
        if (isset($_GET["error"])) {
            echo '<div class="flash flash-error">
                    <strong>⚠️ Error:</strong> ' . htmlspecialchars($_GET["error"]) . '
                  </div>';
        }

        if (isset($_GET["message"])) {
            echo '<div class="flash flash-success">
                    <strong>✓ Success:</strong> ' . htmlspecialchars($_GET["message"]) . '
                  </div>';
        }
        ?>

        <form action="auth_process.php" method="POST">
            <input type="hidden" name="action" value="login">

            <label class="form-label">Email or Admin Username</label>
            <input type="text" name="email" placeholder="Email or admin" required class="form-input">

            <label class="form-label">Password</label>
            <input type="password" name="password" placeholder="Password" required class="form-input">

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p style="margin-top: 20px;">
            Don’t have an account?
            <a href="register.php">Register</a>
        </p>
    </div>
</div>

<script src="../js/menu.js"></script>
<script src="../js/auth.js"></script>
</body>
</html>