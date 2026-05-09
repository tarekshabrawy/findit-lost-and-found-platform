<?php
// includes/navbar.php
// Determines active page for nav highlight
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar" id="mainNavbar">
    <div class="logo"><a href="index.php">FindIt</a></div>

    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-links" id="navLinks">
        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="feed.php"     class="<?= $current_page === 'feed.php'    ? 'active' : '' ?>">Feed</a>
            <a href="add_post.php" class="<?= $current_page === 'add_post.php'? 'active' : '' ?>">+ Post</a>
            <a href="profile.php"  class="<?= $current_page === 'profile.php' ? 'active' : '' ?>">Profile</a>
            <a href="about.php"    class="<?= $current_page === 'about.php'   ? 'active' : '' ?>">About</a>
            <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === 'admin'): ?>
                <a href="admin_dashboard.php" class="<?= $current_page === 'admin_dashboard.php' ? 'active' : '' ?>">Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="nav-cta">Logout</a>
        <?php else: ?>
            <a href="about.php"    class="<?= $current_page === 'about.php'  ? 'active' : '' ?>">About</a>
            <a href="login.php"    class="<?= $current_page === 'login.php'  ? 'active' : '' ?>">Login</a>
            <a href="register.php" class="nav-cta">Register</a>
        <?php endif; ?>
    </div>
</nav>
