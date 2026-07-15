<?php

$host="localhost";

$user="root";

$password="";

$database="bmi_calculator";

$conn=new mysqli($host,$user,$password,$database);

if($conn->connect_error)
{
die("Connection Failed");
}

?>