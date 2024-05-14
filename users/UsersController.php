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
public function getUserName($userID) {
    $result = $this->model->getUserName($userID);
    
    // Check if the result contains rows
    if ($result->num_rows > 0) {
        // Fetch row and return user name
        $row = $result->fetch_assoc();
        return $row['Name'];
    } else {
        return "Unknown"; // Return "Unknown" if user ID not found
    }
}

}
?>
