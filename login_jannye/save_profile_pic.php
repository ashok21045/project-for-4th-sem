<?php
session_start();
require_once "../partials/_test.php";

$username = $_SESSION['username'];
$image = $_POST['image'];

$sql = "UPDATE user SET image='$image' WHERE username='$username'";
mysqli_query($conn, $sql);

$_SESSION['profile_pic'] = $image;
?>
