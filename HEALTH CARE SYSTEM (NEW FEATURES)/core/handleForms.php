<?php
require '../core/dbConfig.php';
require '../core/models.php';

$applicant = new Applicant($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $yearsOfExperience = $_POST['yearsOfExperience'];
    $specialization = $_POST['specialization'];
    $licenseNumber = $_POST['licenseNumber'];
    $preferredHospital = $_POST['preferredHospital'];
    $isCurrentlyEmployed = $_POST['isCurrentlyEmployed'];

    $query = "INSERT INTO healthcare_applicants (firstName, lastName, yearsOfExperience, specialization, licenseNumber, preferredHospital, isCurrentlyEmployed)
              VALUES (:firstName, :lastName, :yearsOfExperience, :specialization, :licenseNumber, :preferredHospital, :isCurrentlyEmployed)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':yearsOfExperience' => $yearsOfExperience,
        ':specialization' => $specialization,
        ':licenseNumber' => $licenseNumber,
        ':preferredHospital' => $preferredHospital,
        ':isCurrentlyEmployed' => $isCurrentlyEmployed
    ]);

    log_activity($_SESSION['user_name'], "Added new healthcare applicant: $firstName $lastName");
}

?>