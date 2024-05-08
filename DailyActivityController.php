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

    public function addDailyActivity($userId, $activityTypeId, $dateReceived, $receivedBy, $timeLeaved) {
        return $this->model->addDailyActivity($userId, $activityTypeId, $dateReceived, $receivedBy, $timeLeaved);
    }
    public function getAllDailyActivitiesWithActivityNames() {
        $activities = $this->model->getAllDailyActivities();
    
        foreach ($activities as &$activity) {
            $activityTypeId = $activity['activity_type_id'];
            $activity['ActivityName'] = $this->model->getActivityNameByTypeId($activityTypeId);
        }
    
        return $activities;
    }
        
    public function updateDailyActivity($activityId, $newData) {
        return $this->model->updateDailyActivity($activityId, $newData);
    }

    public function deleteDailyActivity($activityId) {
        return $this->model->deleteDailyActivity($activityId);
    }

    public function getDailyActivityById($activityId) {
        return $this->model->getDailyActivityById($activityId);
    }
}
?>
