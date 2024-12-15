<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Teacher Dashboard</h1>
        <a href="input_results.php">Input Results</a>
        <div class="attendance">
            <h2>Mark Attendance</h2>
            <form method="POST" action="../server/api.php">
                <input type="hidden" name="action" value="mark_attendance">
                <label for="student_id">Student ID:</label>
                <input type="number" name="student_id" required>
                <label for="date">Date:</label>
                <input type="date" name="date" required>
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
