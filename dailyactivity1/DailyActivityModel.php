<?php
class DailyActivity {
    public $activityId;
    public $userId;
    public $activityTypeId;
    public $dateReceived;
    public $receivedBy;
    public $timeLeaved;
    public $ActivityName;

    public function __construct($activityId, $userId, $activityTypeId, $dateReceived, $receivedBy, $timeLeaved, $ActivityName) {
        $this->activityId = $activityId;
        $this->userId = $userId;
        $this->activityTypeId = $activityTypeId;
        $this->dateReceived = $dateReceived;
        $this->receivedBy = $receivedBy;
        $this->timeLeaved = $timeLeaved;
        $this->ActivityName = $ActivityName;
    }
    public function getActivityId() {
        return $this->activityId;
    }
}

class DailyActivityModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //object Oriented GET ALL DailyActivities
    public function getAllDailyActivities() {
        $activities = array();

        $query = "SELECT d.activity_id, d.user_id, d.activity_type_id, d.Date_Recieved as date_received, d.Recieved_By as received_by, d.Time_Leaved as time_leaved, a.ActivityName
                  FROM dailyactivity1 d
                  LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activities[] = new DailyActivity(
                    $row['activity_id'],
                    $row['user_id'],
                    $row['activity_type_id'],
                    $row['date_received'],
                    $row['received_by'],
                    $row['time_leaved'],
                    $row['ActivityName']
                );
            }
        }

        return $activities;
    }

    public function getDailyActivityById($activityId) {
        $query = "SELECT d.activity_id, d.user_id, d.activity_type_id, d.Date_Recieved as date_received, d.Recieved_By as received_by, d.Time_Leaved as time_leaved, a.ActivityName
                  FROM dailyactivity1 d
                  LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id
                  WHERE d.activity_id = '$activityId'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return new DailyActivity(
                $row['activity_id'],
                $row['user_id'],
                $row['activity_type_id'],
                $row['date_received'],
                $row['received_by'],
                $row['time_leaved'],
                $row['ActivityName']
            );
        }
        return null;
    }
//Object Add daily activity
    public function addDailyActivity($activity) {
        // Extract properties from the activity object
        $userId = $activity->userId;
        $activityTypeId = $activity->activityTypeId;
        $dateReceived = $activity->dateReceived;
        $receivedBy = $activity->receivedBy;
        $timeLeaved = $activity->timeLeaved;
    
        // Prepare the SQL query
        $query = "INSERT INTO dailyactivity1 (user_id, activity_type_id, Date_Recieved, Recieved_By, Time_Leaved) 
                  VALUES ('$userId', '$activityTypeId', '$dateReceived', '$receivedBy', '$timeLeaved')";
    
        // Execute the query
        if ($this->db->query($query) === TRUE) {
            return true;
        }
        return false;
    }
//Object Oriented Update DAILY ACTIVITY
    public function updateDailyActivity($activity) {
        // Extract properties from the activity object
        $activityId = $activity->activityId;
        $userId = $activity->userId;
        $activityTypeId = $activity->activityTypeId;
        $dateReceived = $activity->dateReceived;
        $receivedBy = $activity->receivedBy;
        $timeLeaved = $activity->timeLeaved;
    
        // Prepare the SQL query
        $query = "UPDATE dailyactivity1 SET
                  user_id = '$userId',
                  activity_type_id = '$activityTypeId',
                  Date_Recieved = '$dateReceived',
                  Recieved_By = '$receivedBy',
                  Time_Leaved = '$timeLeaved'
                  WHERE activity_id = '$activityId'";
    
        // Execute the query
        return $this->db->query($query) === TRUE;
    }
    //Object Oriented Delete DAILY Activity
    public function deleteDailyActivity(DailyActivity $activity) {
        $activityId = $activity->activityId;
        $query = "DELETE FROM dailyactivity1 WHERE activity_id = ?";
    
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $activityId);
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }
    //Object Oriented GetActivityName Used in Fetching Activity Name in the table of Daily Activity
        public function getActivityNameByTypeId($activityTypeId) {
        $query = "SELECT ActivityName FROM activitytypes WHERE type_id = '$activityTypeId'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['ActivityName'];
        }
        return null;
    }
    //Get ALL ACTIVITY IDS "Object Oriented" used in the Update page of Daily Activity
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

    //GetDailyActivity By UserID which used to Fetch Activity that is done by the user
    public function getDailyActivitiesByUserID($userID, $userType) {
        if ($userType == 0 || $userType == 1) {
            $query = "SELECT d.activity_id, d.user_id, d.activity_type_id, d.Date_Recieved as date_received, d.Recieved_By as received_by, d.Time_Leaved as time_leaved, a.ActivityName
                      FROM dailyactivity1 d
                      LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id";
        } else {
            $query = "SELECT d.activity_id, d.user_id, d.activity_type_id, d.Date_Recieved as date_received, d.Recieved_By as received_by, d.Time_Leaved as time_leaved, a.ActivityName
                      FROM dailyactivity1 d
                      LEFT JOIN activitytypes a ON d.activity_type_id = a.type_id
                      WHERE d.user_id = '$userID'";
        }

        $result = $this->db->query($query);
        $activities = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $activity = new DailyActivity(
                    $row['activity_id'],
                    $row['user_id'],
                    $row['activity_type_id'],
                    $row['date_received'],
                    $row['received_by'],
                    $row['time_leaved'],
                    $row['ActivityName']
                );
                $activities[] = $activity;
            }
        }
        return $activities;
    }


}
?>
