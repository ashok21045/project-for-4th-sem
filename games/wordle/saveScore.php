        <!-- save  score to the database -->
         <?php
session_start();
require_once "../../partials/_test.php";   // your DB file

// Only logged-in users allowed
if (!isset($_SESSION['username'])) {
    die("Not logged in");
}

$username = $_SESSION['username'];

// Receive JSON from JS
$data = json_decode(file_get_contents("php://input"), true);

$streak = $data['streak'];
$highStreak = $data['highStreak'];
$totalWins = $data['totalWins'];

// Update stats in database
$sql = "UPDATE scoredoard SET 
            -- username= ?,
            current_streak = ?, 
            higest_streak = ?, 
            total_wins = ?
        WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $streak, $highStreak, $totalWins, $username);

if ($stmt->execute()) {
    echo "Stats saved successfully";
} else {
    echo "Error: " . $conn->error;
}
?>
