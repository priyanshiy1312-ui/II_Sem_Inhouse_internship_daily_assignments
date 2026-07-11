<?php

include("db.php");

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students(name,email,course)
            VALUES('$name','$email','$course')";

    if(mysqli_query($conn,$sql)){
        echo "Student Added Successfully";
        echo "<br><a href='view.php'>View Students</a>";
    }
    else{
        echo "Error";
    }

}

?>