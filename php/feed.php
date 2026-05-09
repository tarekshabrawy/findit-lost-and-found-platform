 <?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION["name"];
$user_role = $_SESSION["role"];
$user_id = $_SESSION["user_id"];

$sql = "SELECT p.*, u.name AS author_name 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $sql);

$comment_sql = "SELECT c.*, u.name AS commenter_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                ORDER BY c.created_at ASC";
$comment_result = mysqli_query($conn, $comment_sql);

$comments_by_post = [];
while ($comment = mysqli_fetch_assoc($comment_result)) {
    $comments_by_post[$comment["post_id"]][] = $comment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FindIt - Feed</title>
    <link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/layout.css">
<link rel="stylesheet" href="../css/components.css">
<link rel="stylesheet" href="../css/navbar.css">
<link rel="stylesheet" href="../css/pages/feed.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <h1 class="page-title">Community Feed</h1>
    <p>Welcome, <?php echo htmlspecialchars($user_name); ?></p>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <div class="card">
            <h2>No posts yet</h2>
            <p>Be the first to add a lost or found item.</p>
            <a class="btn" href="add_post.php">Add Post</a>
        </div>
    <?php } ?>

    <?php while ($post = mysqli_fetch_assoc($result)) { ?>
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <strong><?php echo htmlspecialchars($post["author_name"]); ?></strong>
                <span class="badge"><?php echo strtoupper(htmlspecialchars($post["post_type"])); ?></span>
            </div>

            <h2><?php echo htmlspecialchars($post["title"]); ?></h2>
            <p><?php echo htmlspecialchars($post["description"]); ?></p>

            <?php if (!empty($post["image"])) { ?>
                <img class="post-img" src="../<?php echo htmlspecialchars($post["image"]); ?>" alt="Item Image">
            <?php } ?>

            <p><strong>Category:</strong> <?php echo htmlspecialchars($post["category"]); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($post["location"]); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($post["item_date"]); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($post["status"]); ?></p>

            <?php if ($post["user_id"] == $user_id || $user_role == "admin") { ?>
                <form action="post_process.php" method="POST">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">

                    <select name="status">
                        <option value="open" <?php if ($post["status"] == "open") echo "selected"; ?>>Open</option>
                        <option value="returned" <?php if ($post["status"] == "returned") echo "selected"; ?>>Returned</option>
                        <option value="handed_to_security" <?php if ($post["status"] == "handed_to_security") echo "selected"; ?>>Handed to Security</option>
                    </select>

                    <button type="submit">Update Status</button>
                </form>
            <?php } ?>

            <hr>

            <h3>Comments</h3>

            <?php if (!empty($comments_by_post[$post["id"]])) { ?>
                <?php foreach ($comments_by_post[$post["id"]] as $comment) { ?>
                    <div class="card" style="box-shadow:none; background:#f6f8fc;">
                        <strong><?php echo htmlspecialchars($comment["commenter_name"]); ?>:</strong>
                        <p><?php echo htmlspecialchars($comment["comment_text"]); ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No comments yet.</p>
            <?php } ?>

            <form action="post_process.php" method="POST">
                <input type="hidden" name="action" value="comment">
                <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                <textarea name="comment_text" placeholder="Add a comment..." required></textarea>
                <button type="submit">Post Comment</button>
            </form>
        </div>
    <?php } ?>
</div>

<script src="../js/menu.js"></script>
</body>
</html>