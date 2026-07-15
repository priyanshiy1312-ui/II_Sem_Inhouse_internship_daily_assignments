<?php
include "includes/db.php";

$message = "";

if(isset($_POST['register']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    
    if(empty($name) || empty($email) || empty($password) || empty($confirm))
    {
        $message = "Please fill all fields.";
    }

   
    elseif($password != $confirm)
    {
        $message = "Passwords do not match.";
    }

    else
    {
        
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0)
        {
            $message = "Email already registered.";
        }

        else
        {
           
            $hashPassword = password_hash($password,PASSWORD_DEFAULT);

            
            $insert = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
            $insert->bind_param("sss",$name,$email,$hashPassword);

            if($insert->execute())
            {
                header("Location: login.php");
                exit();
            }
            else
            {
                $message = "Registration Failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fb;
}

.card{
    border:none;
    border-radius:15px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-body">

<h2 class="text-center mb-4">

Create Account

</h2>

<?php

if($message!="")
{
    echo "<div class='alert alert-danger'>$message</div>";
}

?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Full Name

</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Confirm Password

</label>

<input
type="password"
name="confirm"
class="form-control"
required>

</div>

<button
type="submit"
name="register"
class="btn btn-success w-100">

Register

</button>

</form>

<hr>

<p class="text-center">

Already have an account?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</div>

</div>

</div>

</body>

</html>