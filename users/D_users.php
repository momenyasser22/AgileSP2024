<?php
require_once 'UsersController.php';

// Instantiate the controller
$usersController = new UsersController();

// Check if the ID parameter is provided in the URL
if(isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];
    
    // Delete the user
    $deleted = $usersController->deleteUser($id);
    
    // Redirect back to the user view page after deletion
    header("Location: UsersView.php");
    exit();
} else {
    // If the ID parameter is not provided, handle the error (e.g., redirect to an error page)
    echo "User ID not provided.";
}
?>
