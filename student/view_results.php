<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$student_id = $_SESSION['user']['id'];

// Fetch results for this student
$results = $conn->query("SELECT s.name AS subject_name, r.semester, r.exam, r.marks 
                         FROM results r 
                         INNER JOIN subjects s ON r.subject_id = s.id 
                         WHERE r.student_id = $student_id 
                         ORDER BY r.semester, s.name, r.exam");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Your Results</h1>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Exam</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($result = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?= $result['subject_name'] ?></td>
                        <td><?= $result['semester'] == 1 ? '1st' : '2nd' ?> Semester</td>
                        <td><?= ucfirst($result['exam']) ?></td>
                        <td><?= $result['marks'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
