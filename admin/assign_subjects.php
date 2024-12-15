<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];

    if (!empty($teacher_id) && !empty($subject_id)) {
        $stmt = $conn->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $teacher_id, $subject_id);

        if ($stmt->execute()) {
            $success = "Subject assigned to teacher successfully.";
        } else {
            $error = "Failed to assign subject.";
        }
    } else {
        $error = "All fields are required.";
    }
}

$teachers = $conn->query("SELECT id, username FROM users WHERE role = 'teacher'");
$subjects = $conn->query("SELECT id, name FROM subjects");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Subjects</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Assign Subjects</h1>
        <?php if (isset($success)): ?>
            <div class="alert success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="teacher_id">Select Teacher:</label>
            <select name="teacher_id" required>
                <?php while ($teacher = $teachers->fetch_assoc()): ?>
                    <option value="<?= $teacher['id'] ?>"><?= $teacher['username'] ?></option>
                <?php endwhile; ?>
            </select>
            <label for="subject_id">Select Subject:</label>
            <select name="subject_id" required>
                <?php while ($subject = $subjects->fetch_assoc()): ?>
                    <option value="<?= $subject['id'] ?>"><?= $subject['name'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Assign</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
