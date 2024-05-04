<?php
require_once 'db_connect.php';

class UserTypeModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function createUserType($type) {
        $sql = "INSERT INTO usertype (type) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $type);
        return $stmt->execute();
    }

    public function getUserTypeById($id) {
        $sql = "SELECT * FROM usertype WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAllUserTypes() {
        $sql = "SELECT * FROM usertype";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUserType($id, $type) {
        $sql = "UPDATE usertype SET type = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $type, $id);
        return $stmt->execute();
    }

    public function deleteUserType($id) {
        $sql = "DELETE FROM usertype WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
