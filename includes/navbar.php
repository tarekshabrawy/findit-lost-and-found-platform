<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION["user_id"]);
$isAdmin = isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
$userName = $_SESSION["name"] ?? "Guest";
?>

<nav class="navbar">
    <div class="logo">FindIt</div>

    <button class="burger-btn" id="burgerBtn" type="button">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="menu-panel" id="menuPanel">
        <div class="menu-header">
            <h3>Hello, <?php echo htmlspecialchars($userName); ?></h3>
            <p>Lost it? Found it? Let us help.</p>
        </div>

        <a href="index.php">Home</a>

        <?php if ($isLoggedIn) { ?>
            <a href="feed.php">Feed</a>
            <a href="add_post.php">Add Post</a>
            <a href="profile.php">Profile</a>

            <?php if ($isAdmin) { ?>
                <a class="admin-link" href="admin_dashboard.php">Admin Dashboard</a>
            <?php } ?>

            <a href="about.php">About Us</a>
            <a class="logout-link" href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="about.php">About Us</a>
        <?php } ?>
    </div>
</nav>