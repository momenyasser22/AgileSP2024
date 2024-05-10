<?php
use mysqli_sql_exception;
use mysqli;
require_once 'dbconnect.php';

class PermissionModel {

    // Constructor to initialize the database connection
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Function to check permission based on user type
    public function checkPermission($userTypeID, $permissionName) {
        try {
            // Prepare and execute the query with placeholders
            $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM permission1 WHERE usertype = ? AND pagename = ?");
            $stmt->bind_param("is", $userTypeID, $permissionName);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Close the statement
            $stmt->close();

            // Return true if count is greater than 0, indicating permission exists
            return $row['count'] > 0;
        } catch (mysqli_sql_exception $e) {
            // Handle any exceptions or errors
            error_log("Error in PermissionModel: " . $e->getMessage());
            return false; // Return false indicating permission check failed
        }
    }
}
?>
