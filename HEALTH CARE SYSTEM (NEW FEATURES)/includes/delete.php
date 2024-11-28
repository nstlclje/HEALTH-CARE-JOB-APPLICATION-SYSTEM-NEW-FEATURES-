<?php
require '../core/dbConfig.php';
require '../core/models.php';

session_start(); 

$applicant = new Applicant($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $applicantData = $applicant->readById($id);  

    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        
        $response = $applicant->delete($id);
        
        $action = "Deleted applicant: " . htmlspecialchars($applicantData['firstName']) . " " . htmlspecialchars($applicantData['lastName']);
        
        if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
            $user_name = $_SESSION['user_name'];
        } else {
            $user_name = 'Guest'; 
        }

        log_activity($user_name, $action);
        
        header("Location: ../includes/index.php");
        exit;
    } else {
        
        $action = "Cancelled deletion of applicant: " . htmlspecialchars($applicantData['firstName']) . " " . htmlspecialchars($applicantData['lastName']);
        
        if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
            $user_name = $_SESSION['user_name'];
        } else {
            $user_name = 'Guest';  
        }

        log_activity($user_name, $action);
        
        header("Location: ../includes/index.php");
        exit;
    }
}

$id = $_GET['id'];
$applicantData = $applicant->readById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Applicant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
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
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        Delete Applicant
    </header>
    <div class="container">
        <p>Are you sure you want to delete the following applicant?</p>
        <form action="../includes/delete.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($applicantData['id']) ?>">
            <p>First Name: <?= htmlspecialchars($applicantData['firstName']) ?></p>
            <p>Last Name: <?= htmlspecialchars($applicantData['lastName']) ?></p>
            <p>Years of Experience: <?= htmlspecialchars($applicantData['yearsOfExperience']) ?></p>
            <p>Specialization: <?= htmlspecialchars($applicantData['specialization']) ?></p>
            <p>License Number: <?= htmlspecialchars($applicantData['licenseNumber']) ?></p>
            <p>Preferred Hospital: <?= htmlspecialchars($applicantData['preferredHospital']) ?></p>
            <p>Currently Employed: <?= htmlspecialchars($applicantData['isCurrentlyEmployed'] ? 'Yes' : 'No') ?></p>
            <p>
                <label for="confirm">Do you want to delete this applicant?</label><br>
                <input type="radio" name="confirm" value="yes"> Yes<br>
                <input type="radio" name="confirm" value="no" checked> No<br>
            </p>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
