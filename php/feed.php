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
   <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>FindIt - Feed</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/feed.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container main-content">
    <h1 class="page-title">Community Feed</h1>
    <p class="page-subtitle">
        Welcome, <?php echo htmlspecialchars($user_name); ?>. Browse lost and found posts from your campus community.
    </p>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <div class="card empty-state">
            <h2>No posts yet</h2>
            <p>Be the first to add a lost or found item.</p>
            <a class="btn btn-primary" href="add_post.php">Add Post</a>
        </div>
    <?php } ?>

    <?php while ($post = mysqli_fetch_assoc($result)) { ?>
        <?php
            $post_type = strtolower($post["post_type"]);
            $status = $post["status"];

            if ($post_type === "lost") {
                $status_options = [
                    "open" => "Open",
                    "found" => "Found",
                    "returned" => "Returned",
                    "closed" => "Closed"
                ];
            } else {
                $status_options = [
                    "waiting_for_owner" => "Waiting for Owner",
                    "claimed" => "Claimed",
                    "returned" => "Returned",
                    "handed_to_security" => "Handed to Security"
                ];
            }
        ?>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:16px;">
                <div>
                    <strong><?php echo htmlspecialchars($post["author_name"]); ?></strong>
                    <p class="page-note">
                        Posted: <?php echo htmlspecialchars($post["created_at"]); ?>
                    </p>
                </div>

                <span class="post-type <?php echo htmlspecialchars($post_type); ?>">
                    <?php echo strtoupper(htmlspecialchars($post_type)); ?>
                </span>
            </div>

            <h2><?php echo htmlspecialchars($post["title"]); ?></h2>

            <p><?php echo htmlspecialchars($post["description"]); ?></p>

            <?php if (!empty($post["image"])) { ?>
                <img 
                    class="post-img" 
                    src="../<?php echo htmlspecialchars($post["image"]); ?>" 
                    alt="Item Image"
                >
            <?php } ?>

            <div class="two-col" style="margin-top: 18px;">
                <div class="comment-item">
                    <strong>Category</strong>
                    <p><?php echo htmlspecialchars($post["category"]); ?></p>
                </div>

                <div class="comment-item">
                    <strong>Location</strong>
                    <p><?php echo htmlspecialchars($post["location"]); ?></p>
                </div>

                <div class="comment-item">
                    <strong>Date</strong>
                    <p><?php echo htmlspecialchars($post["item_date"]); ?></p>
                </div>

                <div class="comment-item">
                    <strong>Status</strong>
                    <p>
                        <span class="status-badge status-<?php echo htmlspecialchars($status); ?>">
                            <?php echo strtoupper(str_replace("_", " ", htmlspecialchars($status))); ?>
                        </span>
                    </p>
                </div>
            </div>

            <?php if ($post["user_id"] == $user_id || $user_role == "admin") { ?>
                <form action="post_process.php" method="POST" style="margin-top:20px;">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">

                    <label class="form-label">Update Status</label>

                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        <select class="form-input" name="status" style="flex:1; min-width:220px;">
                            <?php foreach ($status_options as $value => $label) { ?>
                                <option value="<?php echo $value; ?>" <?php if ($status == $value) echo "selected"; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php } ?>
                        </select>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            <?php } ?>

            <hr>

            <h3>Comments</h3>

            <?php if (!empty($comments_by_post[$post["id"]])) { ?>
                <?php foreach ($comments_by_post[$post["id"]] as $comment) { ?>
                    <div class="comment-item">
                        <div class="comment-author">
                            <?php echo htmlspecialchars($comment["commenter_name"]); ?>
                        </div>

                        <div class="comment-text">
                            <?php echo htmlspecialchars($comment["comment_text"]); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="page-note">No comments yet.</p>
            <?php } ?>

            <form action="post_process.php" method="POST" style="margin-top:20px;">
                <input type="hidden" name="action" value="comment">
                <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">

                <label class="form-label">Add Comment</label>
                <textarea class="form-input" name="comment_text" placeholder="Add a comment..." required></textarea>

                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
    <?php } ?>
</div>

<script src="../js/menu.js"></script>
</body>
</html>