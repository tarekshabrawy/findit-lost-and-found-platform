<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$post_id = intval($_GET["id"] ?? 0);

if ($post_id <= 0) {
    header("Location: feed.php");
    exit();
}

$sql = "SELECT p.*, u.name as author_name 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.id = '$post_id' 
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    header("Location: feed.php");
    exit();
}

$comment_sql = "SELECT c.*, u.name as commenter_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = '$post_id' 
                ORDER BY c.created_at ASC";

$comment_result = mysqli_query($conn, $comment_sql);
$comments = mysqli_fetch_all($comment_result, MYSQLI_ASSOC);

$user_name = $_SESSION["name"];
$user_role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>Post Details - FindIt</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/post_details.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container main-content">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:20px;">
            <div>
                <h1 class="page-title"><?php echo htmlspecialchars($post["title"]); ?></h1>
                <p class="page-subtitle">
                    Posted by <?php echo htmlspecialchars($post["author_name"]); ?>
                </p>
            </div>

            <a class="secondary-button" href="feed.php">Back to Feed</a>
        </div>

        <span class="post-type <?php echo htmlspecialchars($post["post_type"]); ?>">
            <?php echo ucfirst(htmlspecialchars($post["post_type"])); ?>
        </span>

        <p style="margin-top: 20px;">
            <?php echo nl2br(htmlspecialchars($post["description"])); ?>
        </p>

        <?php if (!empty($post["image"])) { ?>
            <img src="../<?php echo htmlspecialchars($post["image"]); ?>" alt="Post Image" class="post-image">
        <?php } ?>

        <div class="two-col" style="margin-top: 20px;">
            <?php if (!empty($post["category"])) { ?>
                <div class="comment-item">
                    <strong>Category</strong>
                    <p><?php echo htmlspecialchars($post["category"]); ?></p>
                </div>
            <?php } ?>

            <?php if (!empty($post["location"])) { ?>
                <div class="comment-item">
                    <strong>Location</strong>
                    <p><?php echo htmlspecialchars($post["location"]); ?></p>
                </div>
            <?php } ?>

            <?php if (!empty($post["item_date"])) { ?>
                <div class="comment-item">
                    <strong>Date</strong>
                    <p><?php echo htmlspecialchars($post["item_date"]); ?></p>
                </div>
            <?php } ?>

            <div class="comment-item">
                <strong>Status</strong>
                <p>
                    <span class="status-badge status-<?php echo htmlspecialchars($post["status"]); ?>">
                        <?php echo str_replace("_", " ", ucfirst(htmlspecialchars($post["status"]))); ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2>Comments</h2>

        <?php if (empty($comments)) { ?>
            <p class="page-note">No comments yet. Add one to help the item owner.</p>
        <?php } else { ?>
            <?php foreach ($comments as $comment) { ?>
                <div class="comment-item">
                    <div class="comment-author">
                        <?php echo htmlspecialchars($comment["commenter_name"]); ?>
                    </div>

                    <div class="comment-text">
                        <?php echo nl2br(htmlspecialchars($comment["comment_text"])); ?>
                    </div>

                    <div class="comment-meta">
                        Posted: <?php echo date("M j, Y H:i", strtotime($comment["created_at"])); ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <form action="post_process.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="add_comment">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="redirect_to" value="post_details.php?id=<?php echo $post_id; ?>">

            <label class="form-label">Add Comment</label>
            <textarea class="form-input" name="comment_text" placeholder="Write your comment..." required></textarea>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/menu.js"></script>
</body>
</html>