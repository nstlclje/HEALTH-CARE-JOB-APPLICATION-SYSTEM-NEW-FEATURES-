<?php
session_start();
require '../core/dbConfig.php';
require '../core/models.php';

$applicant = new Applicant($pdo);
$applicants = [];
$message = "";
$statusCode = 200;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'yearsOfExperience' => $_POST['yearsOfExperience'],
                'specialization' => $_POST['specialization'],
                'licenseNumber' => $_POST['licenseNumber'],
                'preferredHospital' => $_POST['preferredHospital'],
                'isCurrentlyEmployed' => isset($_POST['isCurrentlyEmployed']) ? 1 : 0
            ];
            $response = $applicant->create($data);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
        
            log_activity($_SESSION['user_name'], "Added new applicant: " . $_POST['firstName'] . " " . $_POST['lastName']);
            break;
        
        case 'update':
            $id = $_POST['id'];
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'yearsOfExperience' => $_POST['yearsOfExperience'],
                'specialization' => $_POST['specialization'],
                'licenseNumber' => $_POST['licenseNumber'],
                'preferredHospital' => $_POST['preferredHospital'],
                'isCurrentlyEmployed' => isset($_POST['isCurrentlyEmployed']) ? 1 : 0
            ];
            $response = $applicant->update($id, $data);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
            break;

        case 'delete':
            $id = $_POST['id'];
            $response = $applicant->delete($id);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
            break;

            case 'search':
                $query = $_POST['query'];
                $response = $applicant->search($query);
                $applicants = $response['querySet'];
                if (count($applicants) > 0) {
                    $message = "Found search.";
                } else {
                    $message = "No applicant found.";
                }
                $statusCode = $response['statusCode'];
            
                log_activity($_SESSION['user_name'], "Performed search for: $query");
                break;
            
    }
} else {
    $response = $applicant->read();
    $applicants = $response['querySet'];
}

if (isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];

    log_activity($_SESSION['user_name'], "Performed search for: $searchQuery");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Job Application System</title>
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
        .home-button {
            position: absolute;
            left: 20px;
            top: 20px;
            background: rgba(0, 0, 0, 0.1);
            color: #388E3C; 
            text-decoration: none;
            font-weight: bold;
            padding: 12px 24px; 
            font-size: 1rem; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            transition: background 0.3s;
        }
        .home-button a {
            text-decoration: none;
            color: #333;
        }
        .home-button a:hover {
            color: #4CAF50;
        }

        .logout-button {
            position: absolute;
            right: 20px;
            top: 20px;
            background: rgba(0, 0, 0, 0.1);
            color: #388E3C; 
            text-decoration: none;
            font-weight: bold;
            padding: 12px 24px; 
            font-size: 1rem; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            transition: background 0.3s;
        }
        .logout-button a {
            text-decoration: none;
            color: #333;
        }
        .logout-button a:hover {
            color: #4CAF50;
        }

        .activity-logs-button, .logout-button {
            position: absolute;
            right: 20px;
            top: 20px;
            background: rgba(0, 0, 0, 0.1);
            color: #388E3C; 
            text-decoration: none;
            font-weight: bold;
            padding: 12px 24px; 
            font-size: 1rem; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            transition: background 0.3s;
        }

        .activity-logs-button {
            right: 120px; 
        }

        .activity-logs-button a, .logout-button a {
            text-decoration: none;
            color: #333;
        }

        .activity-logs-button a:hover, .logout-button a:hover {
            color: #4CAF50;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            box-sizing: border-box;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .actions form {
            margin: 0;
        }
        .actions input[type="submit"] {
            padding: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.9em;
            width: 60px; 
        }
        .actions input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
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
        <div class="activity-logs-button">
        <a href="logs.php">Activity Logs</a>
    </div>
        Healthcare Job Application System
    </header>
    <div class="container">
        <h2>Add New Applicant</h2>
        <form action="../includes/index.php" method="post">
            <input type="hidden" name="action" value="create">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required><br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required><br>
            <label for="yearsOfExperience">Years of Experience:</label>
            <input type="number" name="yearsOfExperience" required><br>
            <label for="specialization">Specialization:</label>
            <input type="text" name="specialization" required><br>
            <label for="licenseNumber">License Number:</label>
            <input type="text" name="licenseNumber" required><br>
            <label for="preferredHospital">Preferred Hospital:</label>
            <input type="text" name="preferredHospital"><br>
            <label for="isCurrentlyEmployed">Currently Employed:</label>
            <input type="checkbox" name="isCurrentlyEmployed"><br>
            <input type="submit" value="Submit">
        </form>

        <h2>Search Applicants</h2>
        <form action="../includes/index.php" method="post" class="search-bar">
            <input type="hidden" name="action" value="search">
            <input type="text" name="query" placeholder="Search for applicants...">
            <input type="submit" value="Search">
        </form>

        <h2>Applicants Records</h2>
        <?php if ($message): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($applicants)): ?>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Years of Experience</th>
                        <th>Specialization</th>
                        <th>License Number</th>
                        <th>Preferred Hospital</th>
                        <th>Currently Employed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applicants as $applicant): ?>
                        <tr>
                            <td><?= htmlspecialchars($applicant['firstName']) ?></td>
                            <td><?= htmlspecialchars($applicant['lastName']) ?></td>
                            <td><?= htmlspecialchars($applicant['yearsOfExperience']) ?></td>
                            <td><?= htmlspecialchars($applicant['specialization']) ?></td>
                            <td><?= htmlspecialchars($applicant['licenseNumber']) ?></td>
                            <td><?= htmlspecialchars($applicant['preferredHospital']) ?></td>
                            <td><?= htmlspecialchars($applicant['isCurrentlyEmployed'] ? 'Yes' : 'No') ?></td>
                            <td class="actions">
                                <form action="../includes/delete.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $applicant['id'] ?>">
                                    <input type="submit" value="Delete">
                                </form>
                                <form action="../includes/edit.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $applicant['id'] ?>">
                                    <input type="submit" value="Edit">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>