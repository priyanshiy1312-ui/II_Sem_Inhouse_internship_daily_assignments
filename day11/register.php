<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Empty validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        die("All fields are required.");
    }

    // Name validation
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        die("Name should contain only letters.");
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email.");
    }

    // Password length
    if (strlen($password) < 8) {
        die("Password must contain at least 8 characters.");
    }

    // Uppercase
    if (!preg_match("/[A-Z]/", $password)) {
        die("Password must contain one uppercase letter.");
    }

    // Lowercase
    if (!preg_match("/[a-z]/", $password)) {
        die("Password must contain one lowercase letter.");
    }

    // Number
    if (!preg_match("/[0-9]/", $password)) {
        die("Password must contain one number.");
    }

    // Special Character
    if (!preg_match("/[\W]/", $password)) {
        die("Password must contain one special character.");
    }

    // Confirm Password
    if ($password != $confirm) {
        die("Passwords do not match.");
    }

    // Check email exists
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        die("Email already registered.");
    }

    // Hash Password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert
    $sql = mysqli_prepare($conn,
        "INSERT INTO users(name,email,password) VALUES(?,?,?)");

    mysqli_stmt_bind_param($sql, "sss", $name, $email, $hash);

    if (mysqli_stmt_execute($sql)) {
        echo "Registration Successful";
    } else {
        echo "Registration Failed";
    }
}
?>