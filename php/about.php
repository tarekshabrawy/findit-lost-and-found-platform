<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FindIt</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container main-content">
    <div class="card">
        <h1 class="page-title">About FindIt</h1>
        <p class="page-subtitle">Connecting lost items with their rightful owners across campus.</p>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>Our Mission</h2>
        <p>
            FindIt helps students recover lost items and connect with people who have found them.
            The goal is to create a simple, trusted, and organized lost-and-found system for the university community.
        </p>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>What We Do</h2>
        <p>FindIt allows users to:</p>
        <ul style="list-style: disc; margin-left: 24px; color: var(--text-secondary);">
            <li>Post lost or found items</li>
            <li>Browse the community feed</li>
            <li>Comment on posts</li>
            <li>Update item status</li>
            <li>Use admin moderation for platform safety</li>
        </ul>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>How It Works</h2>
        <ol style="list-style: decimal; margin-left: 24px; color: var(--text-secondary);">
            <li><strong>Register:</strong> Create an account.</li>
            <li><strong>Post:</strong> Add details about a lost or found item.</li>
            <li><strong>Browse:</strong> Search the feed for matching items.</li>
            <li><strong>Connect:</strong> Comment and communicate through posts.</li>
            <li><strong>Resolve:</strong> Update the item status when returned.</li>
        </ol>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>Our Values</h2>

        <div class="two-col" style="margin-top: 20px;">
            <div class="comment-item">
                <h3>Trust</h3>
                <p>We keep the platform organized and safe through user accounts and admin moderation.</p>
            </div>

            <div class="comment-item">
                <h3>Community</h3>
                <p>FindIt depends on students helping each other recover important belongings.</p>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>Need Help?</h2>
        <p>If you need support, return to the home page or browse the feed.</p>
        <a href="index.php" class="btn btn-primary" style="margin-top: 15px;">Back to Home</a>
    </div>
</div>

<script src="../js/menu.js"></script>
</body>
</html>