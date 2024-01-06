<?php

class ShooterController {
    private $db; // Database connection or ORM instance

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllShooters() {
        // Retrieve all shooters from the database
        // Implement appropriate database query based on your schema
        $query = "SELECT * FROM shooters";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getShooterById($shooterId) {
        // Retrieve a specific shooter by ID from the database
        $query = "SELECT * FROM shooters WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $shooterId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addShooter($shooterData) {
        // Insert a new shooter into the database
        $query = "INSERT INTO shooters (first_name, last_name, previous_year_average, current_year_average, class_id, is_new_shooter) 
                  VALUES (:first_name, :last_name, :previous_year_average, :current_year_average, :class_id, :is_new_shooter)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($shooterData);
        // Return the ID of the newly inserted shooter
        return $this->db->lastInsertId();
    }

    public function updateShooter($shooterId, $shooterData) {
        // Update an existing shooter in the database
        $query = "UPDATE shooters 
                  SET first_name = :first_name, last_name = :last_name, previous_year_average = :previous_year_average, 
                      current_year_average = :current_year_average, class_id = :class_id, is_new_shooter = :is_new_shooter
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $shooterData['id'] = $shooterId;
        $stmt->execute($shooterData);
        // Return the number of affected rows (success or failure indication)
        return $stmt->rowCount();
    }

    public function deleteShooter($shooterId) {
        // Delete a shooter from the database
        $query = "DELETE FROM shooters WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $shooterId, PDO::PARAM_INT);
        $stmt->execute();
        // Return the number of affected rows (success or failure indication)
        return $stmt->rowCount();
    }
}
