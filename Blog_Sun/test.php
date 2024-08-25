<?php 
require_once 'inc/db.php';
$query = "SELECT * FROM posts";
$result = mysqli_query($connection,$query);
$posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
print_r($posts);