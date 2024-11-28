<?php
require '../core/dbConfig.php';

$query = "SELECT id, user_name, action, timestamp FROM activity_logs ORDER BY timestamp DESC"; 
$stmt = $pdo->prepare($query);
$stmt->execute();
$activityLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>    
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #A8E6CF, #DCEDC1); 
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1em 0;
            text-align: center;
            font-size: 2em;
            position: relative;
        }

        .home-button, .logout-button {
            position: absolute;
            top: 20px;
            font-weight: bold;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
        }

        .home-button {
            left: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .logout-button {
            right: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .home-button a, .logout-button a {
            text-decoration: none;
            color: #333;
        }

        .home-button a:hover, .logout-button a:hover {
            color: #4CAF50;
        }

        .table-container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table td {
            background-color: #DFF0D8;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

    </style>
</head>
<body>

<header>
    <div class="home-button">
        <a href="index.php">Home</a>
    </div>
    <div class="logout-button">
        <a href="login.php">Logout</a>
    </div>
    Activity Logs
</header>

<!-- Activity Logs Table Section -->
<div class="table-container">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($activityLogs)): ?>
                <?php foreach ($activityLogs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['id']) ?></td>
                        <td><?= htmlspecialchars($log['user_name']) ?></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><?= htmlspecialchars($log['timestamp']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No logs available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>