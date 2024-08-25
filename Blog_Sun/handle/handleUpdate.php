<?php
require_once "../inc/db.php";
if (isset($_POST['submit']) && $_GET['id']) {
    $errors = [];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $id = $_GET['id'];
    $query = "SELECT * FROM posts where id = $id";
    $result = mysqli_query($connection, $query);
    $oldImage = mysqli_fetch_assoc($result)['image'];
    if (empty($title)) {
        $errors[] = " the title should be exist";
    }
    if (empty($body)) {
        $errors[] = " the body should be exist";
    }

    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $img = $_FILES['image'];
        $img_name = $img['name'];
        $img_tmp_name = $img['tmp_name'];
        $img_error = $img['error'];
        $img_size = $img['size'] / (1024 * 1024);
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $new_name = uniqid() . "." . $ext; //213215641321.png
        if (empty($img)) {
            $errors[] = " you should upload photo";
        } elseif ($img_error > 0) {
            $errors[] = " your file is broken";
        } elseif (!in_array($ext, ['png', 'jpg'])) {
            $errors[] = "your img should be jpg or png";
        }
    } else {
        $new_name = $oldImage;
    }

    if (empty($errors)) {
        $query = "UPDATE posts Set `title` = '$title',`body` = '$body' , `image` = '$new_name' WHERE id = '$id' ";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $_SESSION['success'] = 'the post is updated successfully';
            move_uploaded_file($img_tmp_name, '../assets/images/postImage/' . $new_name);
            unlink('../assets/images/postImage/'.$oldImage);
            header('location:../index.php');
            exit();
        }
    }

    $_SESSION['errors'] = $errors;
    header('location:../index.php');
}
