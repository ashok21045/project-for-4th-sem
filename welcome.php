<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
    session_start();
    
    if (!isset($_SESSION['exist']) || $_SESSION['exist'] != true) {
        header("Location: login.php");
        exit();
    }
    ?>
</head>
<body>
    <h1>Welcome 
        <?php echo $_SESSION['username']; ?>
    </h1>
    <a href="logout.php">Logout</a>
    <?php

session_unset();
session_destroy();
?>

</body>
</html>
