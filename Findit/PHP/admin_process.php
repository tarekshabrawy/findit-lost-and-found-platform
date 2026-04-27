<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "admin") {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin_dashboard.php");
    exit();
}

$action = $_POST["action"] ?? "";

if ($action === "delete_post") {
    $post_id = (int) ($_POST["post_id"] ?? 0);

    if ($post_id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM comments WHERE post_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn, "DELETE FROM posts WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
    }
}

if ($action === "delete_comment") {
    $comment_id = (int) ($_POST["comment_id"] ?? 0);

    if ($comment_id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM comments WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $comment_id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: admin_dashboard.php");
exit();
?>
