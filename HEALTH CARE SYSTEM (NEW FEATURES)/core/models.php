<?php
class Applicant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
    
        $sql = "SELECT COUNT(*) FROM healthcare_applicants WHERE licenseNumber = :licenseNumber";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['licenseNumber' => $data['licenseNumber']]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return ['message' => 'Duplicate license number. Applicant already exists.', 'statusCode' => 400];
        }

        $sql = "INSERT INTO healthcare_applicants (firstName, lastName, yearsOfExperience, specialization, licenseNumber, preferredHospital, isCurrentlyEmployed)
                VALUES (:firstName, :lastName, :yearsOfExperience, :specialization, :licenseNumber, :preferredHospital, :isCurrentlyEmployed)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute($data)) {
            return ['message' => 'Applicant added successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to add applicant.', 'statusCode' => 400];
        }
    }

    public function read() {
        $sql = "SELECT * FROM healthcare_applicants";
        $stmt = $this->pdo->query($sql);
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'statusCode' => 200];
    }

    public function readById($id) {
        $sql = "SELECT * FROM healthcare_applicants WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $sql = "UPDATE healthcare_applicants SET
                firstName = :firstName,
                lastName = :lastName,
                yearsOfExperience = :yearsOfExperience,
                specialization = :specialization,
                licenseNumber = :licenseNumber,
                preferredHospital = :preferredHospital,
                isCurrentlyEmployed = :isCurrentlyEmployed
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;

        if ($stmt->execute($data)) {
            return ['message' => 'Applicant updated successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to update applicant.', 'statusCode' => 400];
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM healthcare_applicants WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['id' => $id])) {
            return ['message' => 'Applicant deleted successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to delete applicant.', 'statusCode' => 400];
        }
    }

    public function search($query) {
        $sql = "SELECT * FROM healthcare_applicants WHERE
                firstName LIKE :query OR
                lastName LIKE :query OR
                yearsOfExperience LIKE :query OR
                specialization LIKE :query OR
                licenseNumber LIKE :query OR
                preferredHospital LIKE :query";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'statusCode' => 200];
    }
}

function log_activity($user_name, $action) {
    global $pdo; 
    
    
    $query = "INSERT INTO activity_logs (user_name, action) VALUES (:user_name, :action)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':action', $action);
    $stmt->execute([':user_name' => $user_name, ':action' => $action]);

    try {
        $stmt->execute([':user_name' => $user_name, ':action' => $action]);
    } catch (PDOException $e) {
        
        error_log("Error logging activity: " . $e->getMessage());
    }
}

?>