<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "delete_post") {
        $post_id = $_POST["post_id"];

        mysqli_query($conn, "DELETE FROM comments WHERE post_id=$post_id");
        mysqli_query($conn, "DELETE FROM posts WHERE id=$post_id");

        header("Location: admin_dashboard.php");
        exit();
    }

    if ($action == "delete_comment") {
        $comment_id = $_POST["comment_id"];

        mysqli_query($conn, "DELETE FROM comments WHERE id=$comment_id");

        header("Location: admin_dashboard.php");
        exit();
    }
}
?>