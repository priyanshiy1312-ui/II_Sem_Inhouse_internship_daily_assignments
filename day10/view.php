<?php
include("db.php");
?>

<!DOCTYPE html>

<html>

<head>

<title>View Students</title>

</head>

<body>

<h2>Student List</h2>

<table border="1" cellpadding="10">

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Course</th>

<th>Edit</th>

<th>Delete</th>

</tr>

<?php

$sql="SELECT * FROM students";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['course']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['id']; ?>">

Edit

</a>

</td>

<td>

<a href="delete.php?id=<?php echo $row['id']; ?>">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

</body>

</html>