<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user_role = $_SESSION["role"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "comment") {
        $post_id = $_POST["post_id"];
        $comment_text = $_POST["comment_text"];

        $sql = "INSERT INTO comments (post_id, user_id, comment_text)
                VALUES ('$post_id', '$user_id', '$comment_text')";

        mysqli_query($conn, $sql);

        header("Location: feed.php");
        exit();
    }

    if ($action == "update_status") {
        $post_id = $_POST["post_id"];
        $new_status = $_POST["status"];

        $check_sql = "SELECT * FROM posts WHERE id='$post_id'";
        $check_result = mysqli_query($conn, $check_sql);
        $post = mysqli_fetch_assoc($check_result);

        if ($post && ($post["user_id"] == $user_id || $user_role == "admin")) {
            $update_sql = "UPDATE posts SET status='$new_status' WHERE id='$post_id'";
            mysqli_query($conn, $update_sql);
        }

        header("Location: feed.php");
        exit();
    }
}
?>