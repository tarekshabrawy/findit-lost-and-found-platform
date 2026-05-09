<?php include '../includes/navbar.php'; ?>
<link rel="stylesheet" href="/css/pages/feed.css">
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FindIt - Home</title>
    <link rel="stylesheet" href="/css/base.css">
<link rel="stylesheet" href="/css/layout.css">
<link rel="stylesheet" href="/css/components.css">
<link rel="stylesheet" href="/css/pages/feed.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="hero">
    <div class="hero-box">
        <h1>Welcome to FindIt</h1>
        <p>Lost it? Found it? Let us help.</p>

        <br>

        <?php if (isset($_SESSION["user_id"])) { ?>
            <a class="btn" href="feed.php">Go to Feed</a>
        <?php } else { ?>
            <a class="btn" href="login.php">Login</a>
            <a class="btn" href="register.php">Register</a>
        <?php } ?>
    </div>
</div>

<script src="../js/menu.js"></script>
</body>
</html>