<?php 

require_once '../inc/db.php';

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $hashPassword = password_hash($password,PASSWORD_DEFAULT);

    $query = "INSERT INTO users (`name`,`email`,`phone`,`password`) VALUES ('$name','$email','$phone','$hashPassword')";
    $result = mysqli_query($connection,$query);
    if($result)
    {
        header("location:../Login.php");
        exit();

    }else 
    {
        header("location:../register.php");
    }
}