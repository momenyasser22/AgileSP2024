<?php
require_once 'dbconnect.php';
require_once'UsersController.php';
class UsersModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        $users = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function addUser($username, $password, $name, $usertype, $address) {
        $query = "INSERT INTO users (username, password, Name, usertype, Address) 
                  VALUES ('$username', '$password', '$name', $usertype, $address)";
        return $this->db->query($query);
    }

    public function updateUser($userID, $username, $password, $name, $usertype, $address) {
        $query = "UPDATE users 
                  SET username = '$username', password = '$password', Name = '$name', 
                      usertype = $usertype, Address = $address 
                  WHERE UserID = $userID";
        return $this->db->query($query);
    }

    public function deleteUser($userID) {
        // First, delete related records in other tables
        $query1 = "DELETE FROM dailyactivity1 WHERE user_id = $userID";
        $this->db->query($query1);

        // Then delete the user
        $query2 = "DELETE FROM users WHERE UserID = $userID";
        return $this->db->query($query2);    }
        
        public function getAllUserIds() {
            $query = "SELECT UserID FROM users"; // Assuming your table name is 'users'
            $result = $this->db->query($query);
            $userIds = [];
    
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $userIds[] = $row['UserID'];
                }
            }
    
            return $userIds;
        }
}


?>
