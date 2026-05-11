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

    if ($action == "comment" || $action == "add_comment") {
        $post_id = intval($_POST["post_id"]);
        $comment_text = mysqli_real_escape_string($conn, $_POST["comment_text"]);

        $sql = "INSERT INTO comments (post_id, user_id, comment_text)
                VALUES ('$post_id', '$user_id', '$comment_text')";

        mysqli_query($conn, $sql);

        if (!empty($_POST["redirect_to"])) {
            header("Location: " . $_POST["redirect_to"]);
        } else {
            header("Location: feed.php");
        }
        exit();
    }

    if ($action == "create_post") {
        $post_type = mysqli_real_escape_string($conn, $_POST["post_type"]);
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $category = mysqli_real_escape_string($conn, $_POST["category"]);
        $location = mysqli_real_escape_string($conn, $_POST["location"]);
        $item_date = mysqli_real_escape_string($conn, $_POST["item_date"]);

        if ($post_type == "lost") {
            $default_status = "open";
        } else {
            $default_status = "waiting_for_owner";
        }

        $image_path = "";

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $upload_dir = "../uploads/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_tmp = $_FILES["image"]["tmp_name"];
            $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $allowed_ext = ["jpg", "jpeg", "png", "webp"];

            if (in_array($file_ext, $allowed_ext)) {
                $file_name = uniqid("img_", true) . "." . $file_ext;
                $destination = $upload_dir . $file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $image_path = "uploads/" . $file_name;
                }
            }
        }

        $sql = "INSERT INTO posts 
                (user_id, post_type, title, description, category, location, item_date, image, status)
                VALUES 
                ('$user_id', '$post_type', '$title', '$description', '$category', '$location', '$item_date', '$image_path', '$default_status')";

        mysqli_query($conn, $sql);

        header("Location: feed.php");
        exit();
    }

    if ($action == "update_status") {
        $post_id = intval($_POST["post_id"]);
        $new_status = mysqli_real_escape_string($conn, $_POST["status"]);

        $check_sql = "SELECT * FROM posts WHERE id='$post_id'";
        $check_result = mysqli_query($conn, $check_sql);
        $post = mysqli_fetch_assoc($check_result);

        if ($post && ($post["user_id"] == $user_id || $user_role == "admin")) {
            $post_type = strtolower($post["post_type"]);

            if ($post_type == "lost") {
                $allowed_statuses = ["open", "found", "returned", "closed"];
            } else {
                $allowed_statuses = ["waiting_for_owner", "claimed", "returned", "handed_to_security"];
            }

            if (in_array($new_status, $allowed_statuses)) {
                $update_sql = "UPDATE posts SET status='$new_status' WHERE id='$post_id'";
                mysqli_query($conn, $update_sql);
            }
        }

        header("Location: feed.php");
        exit();
    }
}

header("Location: feed.php");
exit();
?>