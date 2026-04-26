<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - FindIt</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>

<div class="form-box">
    <h2>Login</h2>

    <form action="auth_process.php" method="POST">
        <input type="hidden" name="action" value="login">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register</a></p>
</div>

<script src="../js/auth.js"></script>
</body>
</html>