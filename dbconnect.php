<?php
use Exception;
use mysqli;

class Database {
    private static $instance;
    private $conn;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "agile";

    // Private constructor to prevent instantiation from outside
    private function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Public method to get the singleton instance
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Public method to get the database connection
    public function getConnection() {
        return $this->conn;
    }
}

// Example usage:
try {
    // Get the singleton instance
    $db = Database::getInstance();

    // Get the database connection
    $conn = $db->getConnection();
    echo "Connected successfully";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
