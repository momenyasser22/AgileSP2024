<?php

require_once 'PermissionModel.php';
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

    // Function to add permission
    public function addPermission($userTypeID, $permissionName) {
        return $this->model->addPermission($userTypeID, $permissionName);
    }

    // Function to delete permission
    public function deletePermission($permno) {
        return $this->model->deletePermission($permno);
    }

    // Function to update permission
    public function updatePermission($permno, $userTypeID, $permissionName) {
        return $this->model->updatePermission($permno, $userTypeID, $permissionName);
    }
    // Function to fetch all permissions
public function getAllPermissions() {
    return $this->model->getAllPermissions();
}

}

?>
