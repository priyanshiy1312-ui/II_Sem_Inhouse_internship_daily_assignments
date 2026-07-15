<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Admission Form</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fb;
}

.card{
    border-radius:10px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3 class="text-center">

Student Admission Form

</h3>

</div>

<div class="card-body">

<form action="save_student.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Full Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>College</label>

<input
type="text"
name="college"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Branch</label>

<select
name="branch"
class="form-control"
required>

<option value="">Select Branch</option>

<option>CSE</option>

<option>AI</option>

<option>IT</option>

<option>ECE</option>

<option>ME</option>

<option>CE</option>

</select>

</div>

</div>

<div class="text-center">

<button
type="submit"
class="btn btn-success"
name="submit">

Submit

</button>

<a href="logout.php" class="btn btn-danger">

Logout

</a>

</div>

</form>

</div>

</div>

</div>

</body>
</html>