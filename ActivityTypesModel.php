<?php
require_once 'db_connect.php';

class ActivityModel {
    private $conn;
//comment
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function createActivity($typeId, $activityName) {
        $sql = "INSERT INTO activitytypes (type_id, ActivityName) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $typeId, $activityName);
        return $stmt->execute();
    }

    public function getAllActivities() {
        $sql = "SELECT * FROM activitytypes";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateActivity($activityId, $newActivityName) {
        $sql = "UPDATE activitytypes SET ActivityName = ? WHERE type_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newActivityName, $activityId);
        return $stmt->execute();
    }

    public function deleteActivity($activityId) {
        $sql = "DELETE FROM activitytypes WHERE type_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $activityId);
        return $stmt->execute();
    }
}
?>
