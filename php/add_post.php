<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION["name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - FindIt</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/test.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card form-card" style="margin: 60px auto;">
        <h1 class="page-title">Create a New Post</h1>
        <p class="page-subtitle">
            Share details about a lost or found item so others can help reconnect it with the owner.
        </p>

        <form action="post_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create_post">

            <div class="form-grid">
                <div>
                    <label class="form-label" for="post_type">Post Type</label>
                    <select class="form-input" id="post_type" name="post_type" required>
                        <option value="lost">Lost</option>
                        <option value="found">Found</option>
                    </select>
                </div>

                <div>
                    <label class="form-label" for="category">Category</label>
                    <select class="form-input" id="category" name="category">
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
                    <label class="form-label" for="title">Title</label>
                    <input class="form-input" type="text" id="title" name="title" placeholder="Item title" required>
                </div>

                <div>
                    <label class="form-label" for="location">Location</label>
                    <input class="form-input" type="text" id="location" name="location" placeholder="Where it was lost or found">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-input" id="description" name="description" rows="5" placeholder="Add a detailed description" required></textarea>
                </div>

                <div>
                    <label class="form-label" for="item_date">Date</label>
                    <input class="form-input" type="date" id="item_date" name="item_date">
                </div>

                <div>
                    <label class="form-label" for="image">Item Image</label>
                    <input class="form-input" type="file" id="image" name="image" accept="image/*">
                    <p class="page-note">Optional image helps others recognize the item.</p>
                </div>
            </div>

            <img id="previewImage" class="preview-image" style="display:none;" alt="Image preview">

            <div class="form-actions">
                <a class="secondary-button" href="feed.php">Cancel</a>
                <button type="submit" class="btn btn-primary">Publish Post</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/menu.js"></script>
<script src="../js/posts.js"></script>
</body>
</html>