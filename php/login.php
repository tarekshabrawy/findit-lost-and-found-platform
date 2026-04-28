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
        <?php
        if (isset($_GET["error"])) {
            echo '<div style="background: #ffe5e5; color: #d62828; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #d62828;">
                    <strong>⚠️ Error:</strong> ' . htmlspecialchars($_GET["error"]) . '
                  </div>';
        }
        if (isset($_GET["message"])) {
            echo '<div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                    <strong>✓ Success:</strong> ' . htmlspecialchars($_GET["message"]) . '
                  </div>';
        }
        ?>
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