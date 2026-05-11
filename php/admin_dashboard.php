<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
$posts = mysqli_query($conn, "SELECT p.*, u.name AS author_name FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$comments = mysqli_query($conn, "SELECT c.*, u.name AS commenter_name FROM comments c JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>FindIt - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/admin.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container-wide main-content">
    <h1 class="page-title">Admin Dashboard</h1>
    <p class="page-subtitle">Moderate users, posts, and comments across the FindIt platform.</p>

    <div class="card admin-card">
        <h2>Users</h2>

        <table class="table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>Student ID</th>
                <th>Role</th>
            </tr>

            <?php while ($user = mysqli_fetch_assoc($users)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user["name"]); ?></td>
                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                    <td><?php echo htmlspecialchars($user["major"]); ?></td>
                    <td><?php echo htmlspecialchars($user["student_id"]); ?></td>
                    <td><?php echo htmlspecialchars($user["role"]); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="card admin-card" style="margin-top: 24px;">
        <h2>Posts</h2>

        <table class="table">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($post = mysqli_fetch_assoc($posts)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($post["title"]); ?></td>
                    <td><?php echo htmlspecialchars($post["author_name"]); ?></td>
                    <td><?php echo htmlspecialchars($post["post_type"]); ?></td>
                    <td><?php echo htmlspecialchars($post["status"]); ?></td>
                    <td>
                        <form action="admin_process.php" method="POST">
                            <input type="hidden" name="action" value="delete_post">
                            <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                            <button class="btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="card admin-card" style="margin-top: 24px;">
        <h2>Comments</h2>

        <table class="table">
            <tr>
                <th>User</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>

            <?php while ($comment = mysqli_fetch_assoc($comments)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment["commenter_name"]); ?></td>
                    <td><?php echo htmlspecialchars($comment["comment_text"]); ?></td>
                    <td>
                        <form action="admin_process.php" method="POST">
                            <input type="hidden" name="action" value="delete_comment">
                            <input type="hidden" name="comment_id" value="<?php echo $comment["id"]; ?>">
                            <button class="btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<script src="../js/menu.js"></script>
</body>
</html>