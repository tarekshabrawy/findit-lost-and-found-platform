<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $major = $_POST["major"];
    $student_id = $_POST["student_id"];

    $sql = "UPDATE users SET name='$name', major='$major', student_id='$student_id' WHERE id=$user_id";
    mysqli_query($conn, $sql);

    $_SESSION["name"] = $name;
    header("Location: profile.php");
    exit();
}

$sql = "SELECT * FROM users WHERE id=$user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FindIt - Profile</title>
    <link rel="stylesheet" href="../css/base.css">
<link rel="stylesheet" href="../css/layout.css">
<link rel="stylesheet" href="../css/components.css">
<link rel="stylesheet" href="../css/navbar.css">
<link rel="stylesheet" href="../css/pages/profile.css">
</head>
<body>

<div class="navbar">
    <div class="logo">FindIt</div>
    <div class="nav-links">
        <a href="feed.php">Feed</a>
        <a href="add_post.php">Add Post</a>
        <a href="profile.php">Profile</a>

        <?php if ($_SESSION["role"] == "admin") { ?>
            <a href="admin_dashboard.php">Admin</a>
        <?php } ?>

        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h1>My Profile</h1>

        <div class="profile-header">
            <img class="profile-img" src="../uploads/profiles/default.png" alt="Profile Image">
            <div>
                <h2><?php echo htmlspecialchars($user["name"]); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user["role"]); ?></p>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Edit Profile</h2>

        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>

            <label>Major</label>
            <input type="text" name="major" value="<?php echo htmlspecialchars($user["major"]); ?>">

            <label>Student ID</label>
            <input type="text" name="student_id" value="<?php echo htmlspecialchars($user["student_id"]); ?>">

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

</body>
</html>