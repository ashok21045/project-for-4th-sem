<?php

// 1. Database Connection Details (Update these with your actual details)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'brainsparkk';

// 2. Your List of Words

$word_list = [
    "xenon",
    "xerox",
    "xylem",
    "xenon",
    "xenia",
    "xenic",
    "xylan",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon",
    "xenon"
]


;


// 3. Establish Connection

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// 4. Prepare Statement (Only needs to be done once outside the loop)
$sql = "INSERT INTO words (word) VALUES (?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("❌ SQL Prepare failed: " . $conn->error);
}

// 's' means the parameter is a string
$stmt->bind_param("s", $word); 
$count = 0;

// 5. Loop Through the Array and Execute the Insert
foreach ($word_list as $word) {
    // $word is now bound to the prepared statement
    $stmt->execute();
    $count++;
}

// 6. Close the statement and connection
$stmt->close();
$conn->close();

echo "✅ Successfully inserted **$count** words into the 'words' table.\n";

?>