<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $major = mysqli_real_escape_string($conn, $_POST["major"]);
    $student_id = mysqli_real_escape_string($conn, $_POST["student_id"]);

    $profile_image_sql = "";

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === 0) {
        $upload_dir = "../uploads/profiles/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = $_FILES["profile_image"]["name"];
        $file_tmp = $_FILES["profile_image"]["tmp_name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_ext = ["jpg", "jpeg", "png", "webp"];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = "profile_" . $user_id . "_" . time() . "." . $file_ext;
            $target_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_path)) {
                $db_image_path = "uploads/profiles/" . $new_file_name;
                $profile_image_sql = ", profile_image='$db_image_path'";
            }
        }
    }

    $sql = "UPDATE users 
            SET name='$name', major='$major', student_id='$student_id' $profile_image_sql 
            WHERE id=$user_id";

    mysqli_query($conn, $sql);

    $_SESSION["name"] = $name;
    header("Location: profile.php");
    exit();
}

$sql = "SELECT * FROM users WHERE id=$user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$profile_image = $user["profile_image"] ?? "";

if (empty($profile_image) || $profile_image === "uploads/profiles/default.png") {
    $random_avatar_number = rand(1, 5);
    $profile_image = "uploads/profiles/defaults/avatar" . $random_avatar_number . ".png";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>FindIt - Profile</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/profile.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card profile-card" style="margin: 60px auto 24px;">
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">View and update your FindIt account information.</p>

        <div class="profile-header">
           <img 
    class="profile-img" 
    src="../<?php echo htmlspecialchars($profile_image); ?>" 
    alt="Profile Image"
    onclick="openProfileModal(this.src)"
    style="cursor:pointer;"
>

            <div>
                <h2><?php echo htmlspecialchars($user["name"]); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user["role"]); ?></p>
            </div>
        </div>
    </div>

    <div class="card profile-card">
        <h2>Edit Profile</h2>

        <form method="POST" enctype="multipart/form-data">
            <label class="form-label">Name</label>
            <input class="form-input" type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>

            <label class="form-label">Major</label>
            <input class="form-input" type="text" name="major" value="<?php echo htmlspecialchars($user["major"]); ?>">

            <label class="form-label">Student ID</label>
            <input class="form-input" type="text" name="student_id" value="<?php echo htmlspecialchars($user["student_id"]); ?>">

           <label class="form-label">Profile Picture</label>

<input 
    id="profileImageInput"
    class="form-input"
    type="file"
    name="profile_image"
    accept="image/*"
    style="display:none;"
>

<button type="button" class="btn btn-primary" onclick="document.getElementById('profileImageInput').click();">
    Change Picture
</button>

<p id="selectedImageName" class="page-note">
    If you do not upload a picture, FindIt will show a random default avatar.
</p>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<script src="../js/menu.js"></script>
<script>
const profileInput = document.getElementById("profileImageInput");
const selectedImageName = document.getElementById("selectedImageName");

if (profileInput) {
    profileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            selectedImageName.textContent = "Selected: " + this.files[0].name;
        }
    });
}
</script>
<div id="profileModal" class="profile-modal" onclick="closeProfileModal()">
    <img id="profileModalImg" src="" alt="Profile Image">
</div>

<script>
function openProfileModal(src) {
    document.getElementById("profileModalImg").src = src;
    document.getElementById("profileModal").classList.add("show");
}

function closeProfileModal() {
    document.getElementById("profileModal").classList.remove("show");
}
</script>
</body>
</html>