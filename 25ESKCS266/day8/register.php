<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>day8</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
  <section id="form">
  <?php include 'header.php'?>
    <div  class="container mt-5 col-md-6">
    <form action="process.php" method="POST">
        <h1>Registration Form</h1>
  <div class="mb-3">
    <label for="exampleInputname1" class="form-label">Name</label>
    <input type="text" name="name" placeholder="Enter your name" class="form-control" id="exampleInputname1" aria-describedby="emailHelp">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputcollege1" class="form-label">College</label>
    <input type="text" name="college" placeholder="Enter your college "class="form-control" id="exampleInputcollege1" >
    
  </div>
  <div class="mb-3">
    <label for="exampleInputbranch1" class="form-label">Branch</label>
    <input type="text" name="branch" class="form-control"  placeholder="Enter your branch" id="exampleInputbranch1" >
    
  </div>
  <div class="mb-3">
    <label for="exampleInputcgpa1" class="form-label">CGPA</label>
    <input type="number" name="cgpa"  placeholder="Enter CGPA" class="form-control" id="exampleInputcgpa1" >
    
  </div>
 <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    
</div>
</form>
<?php include 'footer.php'?>
</body>
</html>