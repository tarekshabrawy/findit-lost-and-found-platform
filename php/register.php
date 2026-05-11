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
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <title>Register - FindIt</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/pages/auth.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<div class="container">
    <div class="card auth-card" style="max-width: 500px; margin: 60px auto;">
      

<h1 class="page-title">Login</h1>
    <h1 class="page-title">Create Account</h1>
        <p class="page-subtitle">Join FindIt and help your campus recover lost items faster.</p>

        <form action="auth_process.php" method="POST">
            <input type="hidden" name="action" value="register">

            <label class="form-label">Full Name</label>
            <input class="form-input" type="text" name="name" placeholder="Full Name" required>

            <label class="form-label">Email</label>
            <input class="form-input" type="email" name="email" placeholder="Email" required>

            <label class="form-label">Password</label>
            <input class="form-input" type="password" name="password" placeholder="Password" required>

            <label class="form-label">Major</label>
            <input class="form-input" type="text" name="major" placeholder="Major">

            <label class="form-label">Student ID</label>
            <input class="form-input" type="text" name="student_id" placeholder="Student ID">

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p style="margin-top: 20px;">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>
</div>

<script src="../js/menu.js"></script>
<script src="../js/auth.js"></script>
</body>
</html>