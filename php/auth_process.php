<?php
session_start();
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "register") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $major = $_POST["major"];
        $student_id = $_POST["student_id"];

        $sql = "INSERT INTO users (name, email, password, major, student_id, role)
                VALUES ('$name', '$email', '$password', '$major', '$student_id', 'user')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            echo "Registration failed: " . mysqli_error($conn);
        }
    }

    if ($action == "login") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["role"] = $user["role"];

                if ($user["role"] == "admin") {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: feed.php");
                }
                exit();
            } else {
                echo "Wrong password";
            }
        } else {
            echo "User not found";
        }
    }
}
?>