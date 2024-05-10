<?php
use mysqli_sql_exception;
use mysqli;

require_once 'dbconnect.php';

class PermissionModel {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Function to check permission based on user type
    public function checkPermission($userTypeID, $permissionName) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM permission1 WHERE usertype = ? AND pagename = ?");
            $stmt->bind_param("is", $userTypeID, $permissionName);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $stmt->close();

            return $row['count'] > 0;
        } catch (mysqli_sql_exception $e) {
            error_log("Error in PermissionModel: " . $e->getMessage());
            return false;
        }
    }

    // Function to add permission
    public function addPermission($userTypeID, $permissionName) {
        try {
            $stmt = $this->db->prepare("INSERT INTO permission1 (usertype, pagename) VALUES (?, ?)");
            $stmt->bind_param("is", $userTypeID, $permissionName);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            error_log("Error in PermissionModel: " . $e->getMessage());
            return false;
        }
    }

    // Function to delete permission
    public function deletePermission($permno) {
        try {
            $stmt = $this->db->prepare("DELETE FROM permission1 WHERE permno = ?");
            $stmt->bind_param("i", $permno);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            error_log("Error in PermissionModel: " . $e->getMessage());
            return false;
        }
    }

    // Function to update permission
    public function updatePermission($permno, $userTypeID, $permissionName) {
        try {
            $stmt = $this->db->prepare("UPDATE permission1 SET usertype = ?, pagename = ? WHERE permno = ?");
            $stmt->bind_param("isi", $userTypeID, $permissionName, $permno);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            error_log("Error in PermissionModel: " . $e->getMessage());
            return false;
        }
    }
    // Function to fetch all permissions from the database
public function getAllPermissions() {
    try {
        // Prepare and execute the query
        $stmt = $this->db->query("SELECT * FROM permission1");

        // Fetch all permissions
        $permissions = $stmt->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        return $permissions;
    } catch (mysqli_sql_exception $e) {
        // Handle any exceptions or errors
        error_log("Error in PermissionModel: " . $e->getMessage());
        return []; // Return an empty array if an error occurs
    }
}

}
?>
