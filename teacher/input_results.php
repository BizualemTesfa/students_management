<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$teacher_id = $_SESSION['user']['id'];

// Fetch subjects assigned to this teacher
$subjects = $conn->query("SELECT s.id, s.name 
                          FROM teacher_subjects ts 
                          INNER JOIN subjects s ON ts.subject_id = s.id 
                          WHERE ts.teacher_id = $teacher_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $semester = $_POST['semester'];
    $exam = $_POST['exam'];
    $marks = $_POST['marks'];

    if (!empty($student_id) && !empty($subject_id) && !empty($semester) && !empty($exam) && !empty($marks)) {
        $stmt = $conn->prepare("INSERT INTO results (student_id, subject_id, semester, exam, marks) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisd", $student_id, $subject_id, $semester, $exam, $marks);

        if ($stmt->execute()) {
            $success = "Result added successfully.";
        } else {
            $error = "Failed to add result.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Results</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Input Results</h1>
        <?php if (isset($success)): ?>
            <div class="alert success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="student_id">Student ID:</label>
            <input type="number" name="student_id" required>
            
            <label for="subject_id">Subject:</label>
            <select name="subject_id" required>
                <?php while ($subject = $subjects->fetch_assoc()): ?>
                    <option value="<?= $subject['id'] ?>"><?= $subject['name'] ?></option>
                <?php endwhile; ?>
            </select>
            
            <label for="semester">Semester:</label>
            <select name="semester" required>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
            </select>
            
            <label for="exam">Exam:</label>
            <select name="exam" required>
                <option value="mid">Midterm</option>
                <option value="final">Final</option>
            </select>
            
            <label for="marks">Marks:</label>
            <input type="number" step="0.01" name="marks" required>
            
            <button type="submit">Submit</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
