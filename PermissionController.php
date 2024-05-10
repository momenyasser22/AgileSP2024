<?php
require'PermissionModel.php';
class PermissionController {
    private $model;

    // Constructor to initialize the model
    public function __construct() {
        $this->model = new PermissionModel();
    }

    // Function to check permission based on user type
    public function checkPermission($userTypeID, $permissionName) {
        return $this->model->checkPermission($userTypeID, $permissionName);
    }
}

