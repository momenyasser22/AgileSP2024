<?php
require_once 'UsersModel.php';
use UsersModel;
class UsersController {
    private $model;

    public function __construct() {
        $this->model = new UsersModel();
    }

    public function getAllUsers() {
        return $this->model->getAllUsers();
    }

    public function addUser($username, $password, $name, $usertype, $address) {
        return $this->model->addUser($username, $password, $name, $usertype, $address);
    }

    public function updateUser($userID, $username, $password, $name, $usertype, $address) {
        return $this->model->updateUser($userID, $username, $password, $name, $usertype, $address);
    }

    public function deleteUser($userID) {
        return $this->model->deleteUser($userID);
    }
    public function getAllUserIds() {
        return $this->model->getAllUserIds();

}
}
?>
