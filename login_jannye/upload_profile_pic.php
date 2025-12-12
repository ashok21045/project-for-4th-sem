<?php
session_start();
require_once "../partials/_test.php";  // DB connection

$username = $_SESSION['username'];

$targetDir = "./photos/uploads/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

$fileName = time() . "_" . basename($_FILES["profile"]["name"]);
$targetFile = $targetDir . $fileName;

if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {

    // Save to DB
    $sql = "UPDATE user SET image='$targetFile' WHERE username='$username'";
    mysqli_query($conn, $sql);

    $_SESSION['profile_pic'] = $targetFile;

    echo json_encode([
        "status" => "success",
        "path" => $targetFile
    ]);

} else {
    echo json_encode(["status" => "error"]);
}
?>
