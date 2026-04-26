<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<h1>Welcome to Feed Page, <?php echo $_SESSION["name"]; ?></h1>
<a href="logout.php">Logout</a>