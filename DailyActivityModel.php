<?php
class DailyActivityModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Method to fetch all daily activities
    public function getAllDailyActivities() {
        $activities = array();

        $query = "SELECT * FROM dailyactivity1";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activities[] = $row;
            }
        }

        return $activities;
    }

    // Method to fetch a daily activity by ID
    public function getDailyActivityById($activityId) {
        $query = "SELECT * FROM dailyactivity1 WHERE activity_id = '$activityId'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Method to add a new daily activity
    public function addDailyActivity($userId, $activityTypeId, $dateReceived, $receivedBy, $timeLeaved) {
        $query = "INSERT INTO dailyactivity1 (user_id, activity_type_id, Date_Recieved, Recieved_By, Time_Leaved) 
                  VALUES ('$userId', '$activityTypeId', '$dateReceived', '$receivedBy', '$timeLeaved')";

        if ($this->db->query($query) === TRUE) {
            return true;
        }
        return false;
    }

    // Method to update an existing daily activity
    public function updateDailyActivity($activityId, $newData) {
        $query = "UPDATE dailyactivity1 SET ";

        foreach ($newData as $key => $value) {
            $query .= "$key = '$value', ";
        }

        $query = rtrim($query, ', ');
        $query .= " WHERE activity_id = '$activityId'";

        return $this->db->query($query) === TRUE;
    }

    // Method to delete a daily activity
    public function deleteDailyActivity($activityId) {
        $query = "DELETE FROM dailyactivity1 WHERE activity_id = '$activityId'";

        return $this->db->query($query) === TRUE;
    }
// Method to fetch activity name by activity type ID
public function getActivityNameByTypeId($activityTypeId) {
    $query = "SELECT ActivityName FROM activitytypes WHERE type_id = '$activityTypeId'";
    $result = $this->db->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row['ActivityName'];
    }
}
    
}
?>
