<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5 col-md-6">
        <h1>Registration form</h1>
    <form action="process.php" method="POST">
        <label>Name</label>
        <div class="md-3">
            
        <input type="text" name="name" placeholder="enter your name">
        </div>
        <label>college</label>
        <div class="md-3">
        
        <input type="text" name="College" placeholder="enter your college">
        </div>
        <label>branch</label>
        <div class="md-3">
        <input type="text" name="branch" placeholder="enter your branch">
</div>
        <button type="submit">submit</button>
    </form>
    </div>
</body>
</html>