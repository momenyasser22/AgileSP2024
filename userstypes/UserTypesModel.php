<?php
require_once 'dbconnect.php';

class UserTypesModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUserTypes() {
        $query = "SELECT * FROM usertype";
        $result = $this->db->query($query);
        $userTypes = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $userTypes[] = $row;
            }
        }
        return $userTypes;
    }

    public function addUserType($type) {
        // Generate a unique ID
        $query = "SELECT MAX(id) as max_id FROM usertype";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $id = $row['max_id'] + 1;

        // Insert the new user type with the generated ID
        $insertQuery = "INSERT INTO usertype (id, Type) VALUES ('$id', '$type')";
        return $this->db->query($insertQuery);
    }

    public function updateUserType($id, $type) {
        $query = "UPDATE usertype SET Type = '$type' WHERE id = $id";
        return $this->db->query($query);
    }


    public function deleteUserType($id) {
        $query1 = "DELETE FROM users WHERE usertype = $id";
        $this->db->query($query1);

        $query = "DELETE FROM usertype WHERE id = $id";
        return $this->db->query($query);
    }
}
?>
