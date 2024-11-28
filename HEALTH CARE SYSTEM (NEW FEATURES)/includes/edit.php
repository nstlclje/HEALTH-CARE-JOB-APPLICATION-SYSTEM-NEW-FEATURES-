<?php

session_start();

require '../core/dbConfig.php';
require '../core/models.php';  

$applicant = new Applicant($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $originalData = $applicant->readById($id);

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

    $action = "Updated applicant record: ";

    foreach ($data as $key => $newValue) {
        if ($newValue != $originalData[$key]) {
            $action .= ucfirst($key) . " changed from '" . htmlspecialchars($originalData[$key]) . "' to '" . htmlspecialchars($newValue) . "'; ";
        }
    }

    if (isset($_SESSION['user_name'])) {
        $user_name = $_SESSION['user_name'];
    } else {
        $user_name = 'Guest';  
    }

    log_activity($user_name, $action);

    header("Location: ../includes/index.php");
    exit;
}

$id = $_GET['id'];
$applicantData = $applicant->readById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant</title>
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
    </style>
</head>
<body>
    <header>
        Edit Applicant
    </header>
    <div class="container">
        <form action="../includes/edit.php" method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $applicantData['id'] ?>">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($applicantData['firstName']) ?>" required><br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?= htmlspecialchars($applicantData['lastName']) ?>" required><br>
            <label for="yearsOfExperience">Years of Experience:</label>
            <input type="number" name="yearsOfExperience" value="<?= htmlspecialchars($applicantData['yearsOfExperience']) ?>" required><br>
            <label for="specialization">Specialization:</label>
            <input type="text" name="specialization" value="<?= htmlspecialchars($applicantData['specialization']) ?>" required><br>
            <label for="licenseNumber">License Number:</label>
            <input type="text" name="licenseNumber" value="<?= htmlspecialchars($applicantData['licenseNumber']) ?>" required><br>
            <label for="preferredHospital">Preferred Hospital:</label>
            <input type="text" name="preferredHospital" value="<?= htmlspecialchars($applicantData['preferredHospital']) ?>"><br>
            <label for="isCurrentlyEmployed">Currently Employed:</label>
            <input type="checkbox" name="isCurrentlyEmployed" <?= $applicantData['isCurrentlyEmployed'] ? 'checked' : '' ?>><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>