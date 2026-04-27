<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$action = $_POST["action"] ?? null;

if ($action === "create_post") {
    $post_type = mysqli_real_escape_string($conn, $_POST["post_type"] ?? "lost");
    $title = mysqli_real_escape_string($conn, trim($_POST["title"] ?? ""));
    $description = mysqli_real_escape_string($conn, trim($_POST["description"] ?? ""));
    $category = mysqli_real_escape_string($conn, trim($_POST["category"] ?? ""));
    $location = mysqli_real_escape_string($conn, trim($_POST["location"] ?? ""));
    $item_date = $_POST["item_date"] ?? null;
    $image_path = null;

    if (empty($title) || empty($description)) {
        die("Title and description are required.");
    }

    if (!empty($_FILES["image"]["name"])) {
        $uploadDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageFile = $_FILES["image"];
        $allowedTypes = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif'];
        $imageInfo = getimagesize($imageFile["tmp_name"]);

        if ($imageInfo === false || !array_key_exists($imageInfo[2], $allowedTypes)) {
            die("Uploaded file must be a JPG, PNG, or GIF image.");
        }

        $extension = $allowedTypes[$imageInfo[2]];
        $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($imageFile["tmp_name"], $destination)) {
            die("Unable to save uploaded image.");
        }

        $image_path = 'uploads/' . $filename;
    }

    $safe_item_date = null;
    if (!empty($item_date)) {
        $safe_item_date = date('Y-m-d', strtotime($item_date));
    }

    $sql = "INSERT INTO posts (user_id, post_type, title, description, category, location, item_date, image) VALUES ('$user_id', '$post_type', '$title', '$description', '$category', '$location', ".($safe_item_date ? "'" . $safe_item_date . "'" : "NULL").", ".($image_path ? "'" . mysqli_real_escape_string($conn, $image_path) . "'" : "NULL").")";

    if (!mysqli_query($conn, $sql)) {
        die("Could not save post: " . mysqli_error($conn));
    }

    header("Location: feed.php");
    exit();
}

if ($action === "add_comment") {
    $post_id = intval($_POST["post_id"] ?? 0);
    $comment_text = mysqli_real_escape_string($conn, trim($_POST["comment_text"] ?? ""));
    $redirect_to = trim($_POST["redirect_to"] ?? "feed.php");

    if ($post_id <= 0 || empty($comment_text)) {
        die("Comment text cannot be empty.");
    }

    $sql = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
    if (!mysqli_query($conn, $sql)) {
        die("Could not save comment: " . mysqli_error($conn));
    }

    header("Location: " . $redirect_to);
    exit();
}

header("Location: feed.php");
exit();
