<?php
require_once 'dbconnect.php';

class DailyActivityDetailsModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addDailyActivityDetails($activityId, $grade, $comment) {
        $query = "INSERT INTO dailyactivity_details (ActivityID, Grade, Comment) 
                  VALUES ('$activityId', '$grade', '$comment')";

        return $this->db->query($query);
    }

    public function updateDailyActivityDetails($detailId, $grade, $comment) {
        $query = "UPDATE dailyactivity_details 
                  SET Grade = '$grade', Comment = '$comment' 
                  WHERE DetailID = '$detailId'";

        return $this->db->query($query);
    }

    public function deleteDailyActivityDetails($detailId) {
        $query = "DELETE FROM dailyactivity_details WHERE DetailID = '$detailId'";

        return $this->db->query($query);
    }

    public function getDailyActivityDetailsByActivityId($activityId) {
        $query = "SELECT * FROM dailyactivity_details WHERE ActivityID = '$activityId'";
        $result = $this->db->query($query);

        $details = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $details[] = $row;
            }
        }
        return $details;
    }

    // Method to get details by DetailID
    public function getDailyActivityDetailsByDetailId($detailId) {
        $query = "SELECT * FROM dailyactivity_details WHERE DetailID = '$detailId'";
        $result = $this->db->query($query);
    
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } 
        
    }
    public function getAllDailyActivityDetails() {
    $query = "SELECT * FROM dailyactivity_details";
    $result = $this->db->query($query);

    $details = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $details[] = $row;
        }
    }
    return $details;

        }

// Inside DailyActivityDetailsModel.php

public function getAllActivityIds() {
    $query = "SELECT activity_id FROM dailyactivity1";
    $result = $this->db->query($query);
    $activityIds = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $activityIds[] = $row['activity_id'];
        }
    }

    return $activityIds;
}


    }

?>
