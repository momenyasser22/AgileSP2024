<?php
require_once 'PermissionController.php';

// Instantiate the PermissionController
$permissionController = new PermissionController();

// Check if the user has permission to access this page
if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'U_Usertypes.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

require_once 'UserTypesController.php';

// Instantiate the controller
$userTypesController = new UserTypesController();

// Check if the ID parameter is provided in the URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize the input
        $type = $_POST['type']; // Assuming the form field is named 'type'

        // Update the user type
        $updateSuccess = $userTypesController->updateUserType($id, $type);

        if ($updateSuccess) {
            // Redirect back to the user types view page with the same UserTypeID
            header("Location: UserTypesView.php?UserTypeID={$userTypeID}");
            exit();
        } else {
            // If update failed, handle the error (e.g., display an error message)
            echo "Failed to update user type.";
        }
    }
} else {
    // If the ID parameter is not provided, handle the error (e.g., redirect to an error page)
    echo "User type ID not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Type</title>
</head>
<body>
    <h2>Update User Type</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id . '&UserTypeID=' . $userTypeID; ?>" method="post">
        <div>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" value="">
        </div>
        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</body>
</html>
