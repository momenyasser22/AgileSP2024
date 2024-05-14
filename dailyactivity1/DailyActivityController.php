<?php
require_once 'DailyActivityModel.php';

class DailyActivityController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAllDailyActivities() {
        return $this->model->getAllDailyActivities();
    }

    public function addDailyActivity($activity) {
        return $this->model->addDailyActivity($activity);
    }


    public function getAllDailyActivitiesWithActivityNames() {
        $activities = $this->model->getAllDailyActivities();
        $activitiesWithNames = [];

        foreach ($activities as $activity) {
            $activityTypeId = $activity->activityTypeId;
            $activity->ActivityName = $this->model->getActivityNameByTypeId($activityTypeId);
            $activitiesWithNames[] = $activity;
        }

        return $activitiesWithNames;
    }
        
    public function updateDailyActivity($activity) {
        // Call the model's update method and pass the activity object
        return $this->model->updateDailyActivity($activity);
    }
    
    public function getDailyActivitiesByUserID($userID, $userType) {
        return $this->model->getDailyActivitiesByUserID($userID, $userType);
    }

    public function deleteDailyActivity($activityId) {
        return $this->model->deleteDailyActivity($activityId);
    }

    public function getDailyActivityById($activityId) {
        return $this->model->getDailyActivityById($activityId);
    }

    public function getAllActivityIds() {
        return $this->model->getAllActivityIds();
    }

    // Function to get all activity types
    public function getAllUserTypes() {
        return $this->model->getAllUserTypes();
    }
    public function getActivityNameByTypeId($activityTypeId) {
        return $this->model->getActivityNameByTypeId($activityTypeId);
    }



}
?>
