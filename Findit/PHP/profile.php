<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION["user_id"];
$message = "";
$error = "";

function column_exists($conn, $table, $column) {
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $check = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $check && mysqli_num_rows($check) > 0;
}

$has_profile_image = column_exists($conn, "users", "profile_image");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $major = trim($_POST["major"] ?? "");
    $student_id = trim($_POST["student_id"] ?? "");

    if ($name === "") {
        $error = "Name is required.";
    } else {
        if ($has_profile_image && isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK) {
            $upload_dir = "../uploads/profiles/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $original_name = basename($_FILES["profile_image"]["name"]);
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

            if (in_array($extension, $allowed)) {
                $new_filename = "profile_" . $user_id . "_" . time() . "." . $extension;
                $target_path = $upload_dir . $new_filename;
                $db_path = "uploads/profiles/" . $new_filename;

                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_path)) {
                    $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, major = ?, student_id = ?, profile_image = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, "ssssi", $name, $major, $student_id, $db_path, $user_id);
                } else {
                    $error = "Image upload failed.";
                }
            } else {
                $error = "Please upload a JPG, PNG, GIF, or WEBP image.";
            }
        }

        if ($error === "") {
            if (!isset($stmt)) {
                $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, major = ?, student_id = ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "sssi", $name, $major, $student_id, $user_id);
            }

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["name"] = $name;
                $message = "Profile updated successfully.";
            } else {
                $error = "Could not update profile.";
            }
        }
    }
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: logout.php");
    exit();
}

$user_role = $_SESSION["role"] ?? "user";
$profile_image = $has_profile_image && !empty($user["profile_image"]) ? "../" . $user["profile_image"] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - FindIt</title>
    <link rel="stylesheet" href="../css/profile_admin.css">
</head>
<body>
    <header class="site-header">
        <h1>FindIt</h1>
        <nav class="top-nav">
            <a href="feed.php">Feed</a>
            <?php if ($user_role === "admin"): ?>
                <a href="admin_dashboard.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="page-shell profile-page">
        <section class="profile-card">
            <div class="profile-summary">
                <?php if ($profile_image): ?>
                    <img class="profile-image" src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile image">
                <?php else: ?>
                    <div class="profile-image-placeholder">No Image</div>
                <?php endif; ?>

                <div>
                    <h2><?php echo htmlspecialchars($user["name"]); ?></h2>
                    <p><strong>Major:</strong> <?php echo htmlspecialchars($user["major"] ?? "Not added"); ?></p>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($user["student_id"] ?? "Not added"); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"] ?? ""); ?></p>
                </div>
            </div>
        </section>

        <section class="form-card">
            <h2>Edit Profile</h2>

            <?php if ($message): ?><p class="success-message"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>
            <?php if ($error): ?><p class="error-message"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

            <form action="profile.php" method="POST" enctype="multipart/form-data" class="profile-form">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>

                <label for="major">Major</label>
                <input type="text" id="major" name="major" value="<?php echo htmlspecialchars($user["major"] ?? ""); ?>">

                <label for="student_id">Student ID</label>
                <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($user["student_id"] ?? ""); ?>">

                <?php if ($has_profile_image): ?>
                    <label for="profile_image">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">
                <?php else: ?>
                    <p class="page-note">To save profile pictures, add a <code>profile_image</code> column to the users table.</p>
                <?php endif; ?>

                <button type="submit">Save Changes</button>
            </form>
        </section>
    </main>
</body>
</html>
