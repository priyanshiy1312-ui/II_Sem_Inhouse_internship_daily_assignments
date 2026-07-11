<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die("Please fill all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email.");
    }

    $sql = mysqli_prepare($conn,
        "SELECT id,name,password FROM users WHERE email=?");

    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);

    $result = mysqli_stmt_get_result($sql);

    if ($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "Incorrect Password.";
        }

    } else {
        echo "Email not registered.";
    }
}
?>