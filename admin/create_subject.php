<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_name = $_POST['subject_name'];

    if (!empty($subject_name)) {
        $stmt = $conn->prepare("INSERT INTO subjects (name) VALUES (?)");
        $stmt->bind_param("s", $subject_name);

        if ($stmt->execute()) {
            $success = "Subject created successfully.";
        } else {
            $error = "Failed to create subject.";
        }
    } else {
        $error = "Subject name cannot be empty.";
    }
}

$subjects = $conn->query("SELECT * FROM subjects");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subjects</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Create Subjects</h1>
        <?php if (isset($success)): ?>
            <div class="alert success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="subject_name">Subject Name:</label>
            <input type="text" name="subject_name" required>
            <button type="submit">Create</button>
        </form>
        <h2>Existing Subjects</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($subject = $subjects->fetch_assoc()): ?>
                    <tr>
                        <td><?= $subject['id'] ?></td>
                        <td><?= $subject['name'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
