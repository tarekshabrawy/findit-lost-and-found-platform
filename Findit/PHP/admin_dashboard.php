<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: login.php");
    exit();
}

function fetch_count($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `$table`");
    $row = mysqli_fetch_assoc($result);
    return (int) ($row["total"] ?? 0);
}

$admin_name = $_SESSION["name"] ?? "Admin";
$user_count = fetch_count($conn, "users");
$post_count = fetch_count($conn, "posts");
$comment_count = fetch_count($conn, "comments");

$users_result = mysqli_query($conn, "SELECT id, name, email, major, student_id, role FROM users ORDER BY id DESC");
$posts_result = mysqli_query($conn, "SELECT p.*, u.name AS author_name FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$comments_result = mysqli_query($conn, "SELECT c.*, u.name AS commenter_name, p.title AS post_title FROM comments c JOIN users u ON c.user_id = u.id JOIN posts p ON c.post_id = p.id ORDER BY c.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FindIt</title>
    <link rel="stylesheet" href="../css/profile_admin.css">
</head>
<body>
    <header class="site-header">
        <h1>FindIt Admin</h1>
        <nav class="top-nav">
            <span>Welcome, <?php echo htmlspecialchars($admin_name); ?></span>
            <a href="feed.php">Feed</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="page-shell admin-page">
        <section class="stats-grid">
            <article class="stat-card"><h2><?php echo $user_count; ?></h2><p>Users</p></article>
            <article class="stat-card"><h2><?php echo $post_count; ?></h2><p>Posts</p></article>
            <article class="stat-card"><h2><?php echo $comment_count; ?></h2><p>Comments</p></article>
        </section>

        <section class="admin-section">
            <h2>Users</h2>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Name</th><th>Email</th><th>Major</th><th>Student ID</th><th>Role</th></tr></thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user["name"]); ?></td>
                                <td><?php echo htmlspecialchars($user["email"]); ?></td>
                                <td><?php echo htmlspecialchars($user["major"] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($user["student_id"] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($user["role"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-section">
            <h2>Posts</h2>
            <div class="admin-list">
                <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                    <article class="admin-item">
                        <div>
                            <h3><?php echo htmlspecialchars($post["title"]); ?></h3>
                            <p>By <?php echo htmlspecialchars($post["author_name"]); ?> | <?php echo htmlspecialchars($post["post_type"]); ?> | <?php echo htmlspecialchars($post["status"] ?? "open"); ?></p>
                            <p><?php echo htmlspecialchars($post["description"]); ?></p>
                        </div>
                        <form action="admin_process.php" method="POST" class="delete-form">
                            <input type="hidden" name="action" value="delete_post">
                            <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                            <button type="submit">Delete Post</button>
                        </form>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="admin-section">
            <h2>Comments</h2>
            <div class="admin-list">
                <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                    <article class="admin-item">
                        <div>
                            <h3>On: <?php echo htmlspecialchars($comment["post_title"]); ?></h3>
                            <p>By <?php echo htmlspecialchars($comment["commenter_name"]); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($comment["comment_text"])); ?></p>
                        </div>
                        <form action="admin_process.php" method="POST" class="delete-form">
                            <input type="hidden" name="action" value="delete_comment">
                            <input type="hidden" name="comment_id" value="<?php echo $comment["id"]; ?>">
                            <button type="submit">Delete Comment</button>
                        </form>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <script src="../js/admin.js"></script>
</body>
</html>
