<?php
session_start();
include("../includes/db.php");

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["name"];
$user_role = $_SESSION["role"];

// Fetch posts from database
$sql = "SELECT p.*, u.name as author_name FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

$comments_by_post = [];
$comment_sql = "SELECT c.*, u.name as commenter_name FROM comments c JOIN users u ON c.user_id = u.id ORDER BY c.created_at ASC";
$comment_result = mysqli_query($conn, $comment_sql);
while ($comment = mysqli_fetch_assoc($comment_result)) {
    $comments_by_post[$comment['post_id']][] = $comment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIt - Feed</title>
    <link rel="stylesheet" href="../css/feed.css">
    <style>
        .create-post-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1d72f3;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(29, 114, 243, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .create-post-btn:hover {
            background: #1557b0;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FindIt</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($user_name); ?>!</span>
            <?php if ($user_role == 'admin'): ?>
                <a href="admin_dashboard.php">Admin Dashboard</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="no-posts">
                <h2>No posts yet</h2>
                <p>Be the first to post about a lost or found item!</p>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-author"><?php echo htmlspecialchars($post['author_name']); ?></div>
                        <div class="post-type <?php echo $post['post_type']; ?>">
                            <?php echo ucfirst($post['post_type']); ?>
                        </div>
                    </div>

                    <div class="post-content">
                        <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
                        <div class="post-description"><?php echo htmlspecialchars($post['description']); ?></div>

                        <div class="post-details">
                            <?php if ($post['category']): ?>
                                <div><span>Category:</span> <?php echo htmlspecialchars($post['category']); ?></div>
                            <?php endif; ?>
                            <?php if ($post['location']): ?>
                                <div><span>Location:</span> <?php echo htmlspecialchars($post['location']); ?></div>
                            <?php endif; ?>
                            <?php if ($post['item_date']): ?>
                                <div><span>Date:</span> <?php echo htmlspecialchars($post['item_date']); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if ($post['image']): ?>
                            <img src="../<?php echo htmlspecialchars($post['image']); ?>" alt="Item image" class="post-image">
                        <?php endif; ?>
                    </div>

                    <div class="post-status">
                        Status: <span class="status-badge status-<?php echo $post['status']; ?>">
                            <?php echo str_replace('_', ' ', ucfirst($post['status'])); ?>
                        </span>
                        <span style="float: right; font-size: 12px; color: #999;">
                            Posted on <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                        </span>
                    </div>

                    <div class="comments-section">
                        <?php $post_comments = $comments_by_post[$post['id']] ?? []; ?>
                        <h3>Comments (<?php echo count($post_comments); ?>)</h3>

                        <?php if (empty($post_comments)): ?>
                            <p class="page-note">No comments yet. Leave the first one.</p>
                        <?php else: ?>
                            <div class="comment-list">
                                <?php $preview_comments = array_slice($post_comments, -2); ?>
                                <?php foreach ($preview_comments as $comment): ?>
                                    <div class="comment-item">
                                        <div class="comment-author"><?php echo htmlspecialchars($comment['commenter_name']); ?></div>
                                        <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></div>
                                        <div class="comment-meta">
                                            <div><span>Posted:</span><?php echo date('M j, Y', strtotime($comment['created_at'])); ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="post_process.php" method="POST" class="comment-box">
                            <input type="hidden" name="action" value="add_comment">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <input type="hidden" name="redirect_to" value="feed.php">
                            <textarea name="comment_text" placeholder="Add a comment..." required></textarea>
                            <div class="form-actions">
                                <input type="submit" value="Post Comment">
                                <a class="secondary-button" href="post_details.php?id=<?php echo $post['id']; ?>">View details</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button class="create-post-btn" onclick="window.location.href='add_post.php'" title="Create New Post">+</button>

    <script src="../js/auth.js"></script>
</body>
</html>