<?php
require_once 'UserTypesModel.php';
use UserTypesModel;
class UserTypesController {
    private $model;

    public function __construct() {
        $this->model = new UserTypesModel();
    }

    public function getAllUserTypes() {
        return $this->model->getAllUserTypes();
    }

    public function addUserType($type) {
        return $this->model->addUserType($type);
    }

    public function updateUserType($id, $type) {
        return $this->model->updateUserType($id, $type);
    }

    public function deleteUserType($id) {
        return $this->model->deleteUserType($id);
    }
}
?>
