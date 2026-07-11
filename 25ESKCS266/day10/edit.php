<?php

include("db.php");

$id=$_GET['id'];

$sql="SELECT * FROM students WHERE id=$id";

$result=mysqli_query($conn,$sql);

$row=mysqli_fetch_assoc($result);

?>

<form action="update.php" method="POST">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

Name

<input type="text"
name="name"
value="<?php echo $row['name']; ?>">

<br><br>

Email

<input type="email"
name="email"
value="<?php echo $row['email']; ?>">

<br><br>

Course

<input type="text"
name="course"
value="<?php echo $row['course']; ?>">

<br><br>

<input type="submit"
name="update"
value="Update">

</form>