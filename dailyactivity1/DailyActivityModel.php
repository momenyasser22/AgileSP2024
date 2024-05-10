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
// Inside DailyActivityModel.php

public function getAllActivityIds() {
    $query = "SELECT DISTINCT ActivityID FROM dailyactivity";
    $result = $this->db->query($query);

    $activityIds = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activityIds[] = $row['ActivityID'];
        }
    }
    return $activityIds;
}
public function getDailyActivitiesByUserID($userID, $userType) {
    // Check if usertype is 0 or 1
    if ($userType == 0 || $userType == 1) {
        // If usertype is 0 or 1, retrieve all activities with activity names
        $query = "SELECT d.*, a.ActivityName
                  FROM dailyactivity1 d
                  LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id";
    } if (!($userType == 0 || $userType == 1)) {
        // If usertype is not 0 or 1, retrieve activities for the specified user with activity names
        $query = "SELECT d.*, a.ActivityName
                  FROM dailyactivity1 d
                  LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id
                  WHERE d.user_id = '$userID'";
    }

    $result = $this->db->query($query);
    $activities = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
    }
    return $activities;
}

}
?>
