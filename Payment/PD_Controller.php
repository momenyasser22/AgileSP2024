<?php
require_once 'PD_Model.php';

class UserPaymentDetailsController {
    private $model;

    public function __construct() {
        $this->model = new UserPaymentDetailsModel();
    }

    public function getUserPaymentDetails($userId) {
        return $this->model->getUserPaymentDetails($userId);
    }

    public function getAllPayments() {
        return $this->model->getAllPayments();
    }
}
?>
