<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>

<h2>Add Student</h2>

<form action="insert.php" method="POST">

    Name:
    <input type="text" name="name"><br><br>

    Email:
    <input type="email" name="email"><br><br>

    Course:
    <input type="text" name="course"><br><br>

    <input type="submit" name="submit" value="Save">

</form>

<br>

<a href="view.php">View Students</a>

</body>
</html>