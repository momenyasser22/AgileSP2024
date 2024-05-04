<?php
require_once 'db_connect.php';

class DailyActivityModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createDailyActivity($userId, $activityId, $activityTypeId) {
        $sql = "INSERT INTO dailyactivity1 (user_id, activity_id, activity_type_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $userId, $activityId, $activityTypeId);
        return $stmt->execute();
    }

    public function getDailyActivitiesByUserId($userId) {
        $sql = "SELECT da.*, at.type_name
                FROM dailyactivity1 da
                JOIN activitytypes at ON da.activity_type_id = at.type_id
                WHERE da.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateDailyActivityType($userId, $activityId, $newActivityTypeId) {
        $sql = "UPDATE dailyactivity1 SET activity_type_id = ? WHERE user_id = ? AND activity_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $newActivityTypeId, $userId, $activityId);
        return $stmt->execute();
    }

    public function deleteDailyActivity($userId, $activityId) {
        $sql = "DELETE FROM dailyactivity1 WHERE user_id = ? AND activity_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $activityId);
        return $stmt->execute();
    }
}
?>
