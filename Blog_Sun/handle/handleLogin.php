<?php
require_once '../inc/db.php';

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * From users where `email` = '$email'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $oldPassword = $user['password'];
            $username = $user['name'];
            $user_id = $user['id'];
            $verify = password_verify($password, $oldPassword);
            if ($verify) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['success'] = "Welecome " . $username;
                header("location:../index.php");
                exit();
            } else {
                $_SESSION['error'] = "wrong password";
                header("location:../Login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "wrong email";
            header("location:../Login.php");
            exit();
        }
    }
    $_SESSION['error'] = "wrong creditionals";
    header("location:../Login.php");
}
