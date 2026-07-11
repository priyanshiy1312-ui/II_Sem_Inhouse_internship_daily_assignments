<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>process</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php include 'header.php'?>
   <div class="conatiner2">
   <?php 
    $name = $_POST["name"];
     $college = $_POST["college"];
      $branch = $_POST["branch"];
       $cgpa = $_POST["cgpa"];
     echo "Name :". $name."<br>";
    echo "College:". $college."<br>" ;
    echo "Branch :" . $branch."<br>";
    echo "CGPA :" . $cgpa."<br>";
    ?>
    <!-- comment for cgpa -->
    <?php
$cgpa = $_POST["cgpa"];

if ($cgpa >= 9 && $cgpa <= 10) {
    echo "Outstanding Performance!";
}
elseif ($cgpa >= 8) {
    echo "Excellent Performance!";
}
elseif ($cgpa >= 7) {
    echo "Very Good Performance!";
}
elseif ($cgpa >= 6) {
    echo "Good Performance!";
}
elseif ($cgpa >= 5) {
    echo "Average Performance!";
}
elseif ($cgpa >= 4) {
    echo "Needs Improvement!";
}
elseif ($cgpa >= 1) {
    echo "Poor Performance!";
}
else {
    echo "Invalid CGPA! Please enter a CGPA between 1 and 10.";
}
?>
<br>
<!-- show if any is empty -->
    <?php
$name = $_POST['name'];
$college = $_POST['college'];
$branch = $_POST['branch'];
$cgpa = $_POST['cgpa'];

if (empty($name)) {
   echo "<p style='color:red;'>Name is required</p>.<br>";
}

if (empty($college)) {
    echo "<p  style='color:red;'>college is required</p>.<br>";
}

if (empty($branch)) {
    echo " <p  style='color:red;'>branch is required</p>.<br>";
}
if (empty($cgpa)) {
    echo "<p style='color:red;'> cgpa is required </p>.<br>";
}

// If all fields are filled
 
if (!empty($name) && !empty($college) && !empty($branch) && !empty($cgpa)) {
    echo "<h3  style='color:green;'>Form submitted successfully!<?h3>";
}
else{
    echo "<h4 style='color:red;'> Fill all the details</h4>";
}
?>
   </div>
    <?php include 'footer.php'?>
</body>
</html>