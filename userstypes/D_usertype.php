<?php
require_once 'PermissionController.php';

// Instantiate the PermissionController
$permissionController = new PermissionController();

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'D_usertype.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

require_once 'UserTypesController.php';

// Check if the ID parameter is provided in the URL
if(isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];
    
    // Instantiate the controller
    $userTypesController = new UserTypesController();
    
    // Attempt to delete the user type
    $deleteSuccess = $userTypesController->deleteUserType($id);
    
    if($deleteSuccess) {
        // Redirect back to the user types view page with the same UserTypeID
        header("Location: UserTypesView.php?UserTypeID=" . $_GET['UserTypeID']);
        exit();
    } else {
        // If deletion failed, handle the error (e.g., display an error message)
        echo "Failed to delete user type.";
    }
} else {
    // If the ID parameter is not provided, handle the error (e.g., redirect to an error page)
    echo "User type ID not provided.";
}
?>
