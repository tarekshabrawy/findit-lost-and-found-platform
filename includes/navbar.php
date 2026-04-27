<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="navbar">
    <h2>FindIt</h2>

    <div class="nav-links">
        <a href="feed.php">Feed</a>
        <a href="add_post.php">Add Post</a>
        <a href="profile.php">Profile</a>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") { ?>
            <a href="admin_dashboard.php">Admin</a>
        <?php } ?>

        <a href="logout.php">Logout</a>
    </div>
</div>