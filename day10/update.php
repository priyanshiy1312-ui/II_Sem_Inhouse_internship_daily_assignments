<?php

include("db.php");

if(isset($_POST['update'])){

$id=$_POST['id'];

$name=$_POST['name'];

$email=$_POST['email'];

$course=$_POST['course'];

$sql="UPDATE students SET

name='$name',

email='$email',

course='$course'

WHERE id=$id";

if(mysqli_query($conn,$sql))
{
header("Location:view.php");
}

}

?>