<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - FindIt</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>

<div class="form-box">
    <h2>Create Account</h2>

    <form action="auth_process.php" method="POST">
        <input type="hidden" name="action" value="register">

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="major" placeholder="Major">
        <input type="text" name="student_id" placeholder="Student ID">

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<script src="../js/auth.js"></script>
</body>
</html>