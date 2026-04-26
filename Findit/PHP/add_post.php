<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION["name"];
$user_role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - FindIt</title>
    <link rel="stylesheet" href="../css/feed.css">
</head>
<body>
    <div class="header">
        <h1>FindIt</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($user_name); ?>!</span>
            <a href="feed.php">Feed</a>
            <?php if ($user_role == 'admin'): ?>
                <a href="admin_dashboard.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="form-box">
            <h2>Create a New Post</h2>
            <p class="feedback-message">Share details about a lost or found item so others can help you reconnect.</p>

            <form action="post_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create_post">

                <div class="form-grid">
                    <div>
                        <label for="post_type">Post Type</label>
                        <select id="post_type" name="post_type" required>
                            <option value="lost">Lost</option>
                            <option value="found">Found</option>
                        </select>
                    </div>

                    <div>
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="">Select category</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Documents">Documents</option>
                            <option value="Keys">Keys</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="Item title" required>
                    </div>

                    <div>
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Where it was lost or found">
                    </div>

                    <div style="grid-column: 1 / -1;">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="5" placeholder="Add a detailed description" required></textarea>
                    </div>

                    <div>
                        <label for="item_date">Date</label>
                        <input type="date" id="item_date" name="item_date">
                    </div>

                    <div>
                        <label for="image">Item Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <p class="page-note">Optional image helps others recognize the item.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="secondary-button" href="feed.php">Cancel</a>
                    <input type="submit" value="Publish Post">
                </div>
            </form>

            <img id="previewImage" class="preview-image" style="display:none;" alt="Image preview">
        </div>
    </div>

    <script src="../js/posts.js"></script>
</body>
</html>