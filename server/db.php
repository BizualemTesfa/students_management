<?php
$host = 'localhost';
$user = 'root';
$pass = '10071498';
$db = 'student_management';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
