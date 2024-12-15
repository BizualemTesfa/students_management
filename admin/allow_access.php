<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $access_granted = $_POST['access_granted'] ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET access_granted = ? WHERE id = ?");
    $stmt->bind_param("ii", $access_granted, $user_id);

    if ($stmt->execute()) {
        header('Location: manage_users.php?success=Access updated');
    } else {
        header('Location: manage_users.php?error=Failed to update access');
    }
    exit();
}

// Fetch users without access
$users = $conn->query("SELECT id, username, role FROM users WHERE access_granted = 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allow Access</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Grant Access</h1>
        <form method="POST">
            <label for="user_id">Select User:</label>
            <select name="user_id" required>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['username'] ?> (<?= $user['role'] ?>)</option>
                <?php endwhile; ?>
            </select>
            <label for="access_granted">Grant Access:</label>
            <input type="checkbox" name="access_granted" value="1">
            <button type="submit">Update Access</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
