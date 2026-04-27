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

$sql = "SELECT p.*, u.name as author_name FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = '$post_id' LIMIT 1";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    header("Location: feed.php");
    exit();
}

$comment_sql = "SELECT c.*, u.name as commenter_name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = '$post_id' ORDER BY c.created_at ASC";
$comment_result = mysqli_query($conn, $comment_sql);
$comments = mysqli_fetch_all($comment_result, MYSQLI_ASSOC);

$user_name = $_SESSION["name"];
$user_role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details - FindIt</title>
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
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <div class="post-author"><?php echo htmlspecialchars($post['author_name']); ?></div>
                    <div class="post-type <?php echo $post['post_type']; ?>"><?php echo ucfirst($post['post_type']); ?></div>
                </div>
                <div>
                    <a class="secondary-button" href="feed.php">Back to Feed</a>
                </div>
            </div>

            <div class="detail-content">
                <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="detail-text"><?php echo nl2br(htmlspecialchars($post['description'])); ?></p>

                <div class="detail-details">
                    <?php if ($post['category']): ?><div><span>Category:</span><?php echo htmlspecialchars($post['category']); ?></div><?php endif; ?>
                    <?php if ($post['location']): ?><div><span>Location:</span><?php echo htmlspecialchars($post['location']); ?></div><?php endif; ?>
                    <?php if ($post['item_date']): ?><div><span>Date:</span><?php echo htmlspecialchars($post['item_date']); ?></div><?php endif; ?>
                    <div><span>Posted:</span><?php echo date('M j, Y', strtotime($post['created_at'])); ?></div>
                </div>

                <?php if ($post['image']): ?>
                    <img src="../<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
                <?php endif; ?>
            </div>

            <div class="post-status">
                Status: <span class="status-badge status-<?php echo $post['status']; ?>">
                    <?php echo str_replace('_', ' ', ucfirst($post['status'])); ?>
                </span>
            </div>
        </div>

        <div class="comment-box">
            <h3>Comments</h3>
            <?php if (empty($comments)): ?>
                <p class="page-note">No comments yet. Add one to help the item owner.</p>
            <?php else: ?>
                <div class="comment-list">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <div class="comment-author"><?php echo htmlspecialchars($comment['commenter_name']); ?></div>
                            <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></div>
                            <div class="comment-meta">
                                <div><span>Posted:</span><?php echo date('M j, Y H:i', strtotime($comment['created_at'])); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="post_process.php" method="POST">
                <input type="hidden" name="action" value="add_comment">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <input type="hidden" name="redirect_to" value="post_details.php?id=<?php echo $post_id; ?>">
                <textarea name="comment_text" placeholder="Write your comment..." required></textarea>
                <div class="form-actions">
                    <input type="submit" value="Add Comment">
                </div>
            </form>
        </div>
    </div>
</body>
</html>