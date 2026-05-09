<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIt — Lost & Found for Your Campus</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/home.css">
</head>
<body>

<?php include('../includes/navbar.php'); ?>

<div class="hero">
    <div class="hero-box">
        <div class="hero-eyebrow">
            <span>✦</span> Campus Lost &amp; Found
        </div>

        <h1>Lost it?<br><em>We'll find it.</em></h1>

        <p>
            FindIt connects students who've lost items with those who've found them —
            making your campus a little more honest, one item at a time.
        </p>

        <div class="hero-actions">
            <?php if (isset($_SESSION["user_id"])): ?>
                <a class="btn" href="feed.php">Go to Feed</a>
                <a class="btn" href="add_post.php">Post an Item</a>
            <?php else: ?>
                <a class="btn" href="register.php">Get Started</a>
                <a class="btn" href="login.php">Sign In</a>
            <?php endif; ?>
        </div>

        <div class="hero-features">
            <span class="hero-feature">Post lost items</span>
            <span class="hero-feature">Browse the feed</span>
            <span class="hero-feature">Reunite & resolve</span>
        </div>
    </div>
</div>

<script src="../js/menu.js"></script>
<script>
    // Navbar scroll effect for transparent home navbar
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>
