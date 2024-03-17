<?php
$servername='localhost';
$username='root';
$password='';
$database='user_management';
 
$con=new mysqli($servername,$username,$password,$database);
 
if($con->connect_error){
    die("Connection failed". $con->connect_error);
}
else{
    // echo "Connection successful";
}
 
 
?>
