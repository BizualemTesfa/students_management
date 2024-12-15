<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$student_id = $_SESSION['user']['id'];

// Fetch the student information
$student_info = $conn->query("SELECT username FROM users WHERE id = $student_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= $student_info['username'] ?></h1>
        <div class="menu">
            <a href="view_results.php">View Results</a>
            <a href="../server/logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
