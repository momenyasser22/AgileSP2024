<?php
require_once 'ActivityTypesModel.php';

class ActivityController {
    private $model;

    public function __construct() {
        $this->model = new ActivityModel();
    }

    public function createActivity($typeId, $activityName) {
        return $this->model->createActivity($typeId, $activityName);
    }

    public function getAllActivities() {
        return $this->model->getAllActivities();
    }

    public function updateActivity($activityId, $newActivityName) {
        return $this->model->updateActivity($activityId, $newActivityName);
    }

    public function deleteActivity($activityId) {
        return $this->model->deleteActivity($activityId);
    }
}
?>
