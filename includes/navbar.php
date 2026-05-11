<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION["user_id"]);
$isAdmin = isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
?>

<nav class="navbar" id="mainNavbar">
    <div class="logo">
    <a href="index.php" class="logo-link">
        <span class="logo-text">FindIt</span>
        <img src="../assets/logo.png" alt="FindIt Logo" class="logo-img">
    </a>
</div>

    <div class="nav-actions">
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle theme">
            🌙
        </button>

        <button class="nav-toggle" id="navToggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="nav-links" id="navLinks">
        <?php if ($isLoggedIn): ?>
            <a href="feed.php" class="<?= $current_page === 'feed.php' ? 'active' : '' ?>">Feed</a>
            <a href="add_post.php" class="<?= $current_page === 'add_post.php' ? 'active' : '' ?>">+ Post</a>
            <a href="profile.php" class="<?= $current_page === 'profile.php' ? 'active' : '' ?>">Profile</a>
            <a href="about.php" class="<?= $current_page === 'about.php' ? 'active' : '' ?>">About</a>

            <?php if ($isAdmin): ?>
                <a href="admin_dashboard.php" class="<?= $current_page === 'admin_dashboard.php' ? 'active' : '' ?>">Admin</a>
            <?php endif; ?>

            <a href="logout.php" class="nav-cta">Logout</a>
        <?php else: ?>
            <a href="index.php" class="<?= $current_page === 'index.php' ? 'active' : '' ?>">Home</a>
            <a href="about.php" class="<?= $current_page === 'about.php' ? 'active' : '' ?>">About</a>
            <a href="login.php" class="<?= $current_page === 'login.php' ? 'active' : '' ?>">Login</a>
            <a href="register.php" class="nav-cta">Register</a>
        <?php endif; ?>
    </div>
</nav>