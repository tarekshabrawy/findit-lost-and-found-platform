<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: feed.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - FindIt</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card" style="max-width: 500px; margin: 60px auto;">
        <h1 class="page-title">Create Account</h1>

        <form action="auth_process.php" method="POST">
            <input type="hidden" name="action" value="register">

            <label>Full Name</label>
            <input type="text" name="name" placeholder="Full Name" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <label>Major</label>
            <input type="text" name="major" placeholder="Major">

            <label>Student ID</label>
            <input type="text" name="student_id" placeholder="Student ID">

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<script src="../js/menu.js"></script>
<script src="../js/auth.js"></script>
</body>
</html>