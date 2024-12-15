<?php
session_start();
require '../server/db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Fetch dashboard statistics
$users = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='student'")->fetch_assoc()['count'];
$teachers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='teacher'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="stats">
            <div>Students: <?php echo $users; ?></div>
            <div>Teachers: <?php echo $teachers; ?></div>
        </div>
        <canvas id="userChart"></canvas>
        <script>
            const ctx = document.getElementById('userChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Students', 'Teachers'],
                    datasets: [{
                        label: '# of Users',
                        data: [<?php echo $users; ?>, <?php echo $teachers; ?>],
                        backgroundColor: ['#007BFF', '#28A745']
                    }]
                }
            });
        </script>
        <a href="manage_users.php">Manage Users</a>
    </div>
</body>
</html>
