<?php
require_once 'DailyActivityDetailsModel.php';

class DailyActivityDetailsController {
    private $model;


    public function getAllDailyActivityDetails() {
        return $this->model->getAllDailyActivityDetails();
    }


    public function __construct($model) {
        $this->model = $model;
    }
    

    public function addDailyActivityDetails($activityId, $grade, $comment) {
        return $this->model->addDailyActivityDetails($activityId, $grade, $comment);
    }

    public function updateDailyActivityDetails($detailId, $grade, $comment) {
        return $this->model->updateDailyActivityDetails($detailId, $grade, $comment);
    }

    public function deleteDailyActivityDetails($detailId) {
        return $this->model->deleteDailyActivityDetails($detailId);
    }

    public function getDailyActivityDetailsByActivityId($activityId) {
        return $this->model->getDailyActivityDetailsByActivityId($activityId);
    }

    // Method to get details by DetailID
    public function getDailyActivityDetailsByDetailId($detailId) {
        return $this->model->getDailyActivityDetailsByDetailId($detailId);
    }
// Inside DailyActivityDetailsController.php

    public function getAllActivityIds() {
        return $this->model->getAllActivityIds();
}

}
?>
