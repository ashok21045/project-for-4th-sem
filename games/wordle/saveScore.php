<?php
session_start();
require_once "../../partials/_test.php"; // DB connection

if (!isset($_SESSION['username'])) {
    die("Not logged in");
}

$username = $_SESSION['username'];

// Receive JSON from JS
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo "No data received";
    exit;
}

$streak = $data['currentStreak'];
$highestStreak = $data['highestStreak'];
$totalWins = $data['totalWins'];

// Correct table name "scoreboard"
$sql = "UPDATE scoreboard SET 
            current_streak = ?, 
            higest_streak = ?, 
            total_wins = ?
        WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $streak, $highestStreak, $totalWins, $username);

if ($stmt->execute()) {
    echo "Stats saved successfully";
} else {
    echo "Error: " . $conn->error;
}
