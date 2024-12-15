<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'input_result') {
        $student_id = $_POST['student_id'];
        $subject_id = $_POST['subject_id'];
        $semester = $_POST['semester'];
        $exam = $_POST['exam'];
        $marks = $_POST['marks'];

        $stmt = $conn->prepare("INSERT INTO results (student_id, subject_id, semester, exam, marks) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $student_id, $subject_id, $semester, $exam, $marks);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Result submitted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit result.']);
        }
    }
}
?>
