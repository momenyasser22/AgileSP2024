<?php
require_once 'PermissionController.php';
require_once 'UserTypesController.php';

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];
// Check if the user has permission to access this page
$permissionController = new PermissionController();
if (!$permissionController->checkPermission($_GET['UserTypeID'], 'A_Usertypes.php')) {
    // Redirect to an error page or display an access denied message
    header("Location: permission_denied.php");
    exit();
}
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $type = $_POST['type']; // Assuming the form field is named 'type'

    // Instantiate the controller
    $userTypesController = new UserTypesController();

    // Add the new user type
    $addSuccess = $userTypesController->addUserType($type);

    if ($addSuccess) {
        // Redirect back to the user types view page
        header("Location: UserTypesView.php?UserTypeID={$_GET['UserTypeID']}");
        exit();
    } else {
        // If addition failed, handle the error (e.g., display an error message)
        echo "Failed to add user type.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Type</title>
</head>
<body>
    <h2>Add User Type</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?UserTypeID=<?php echo $_GET['UserTypeID']; ?>" method="post">
        <div>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type">
        </div>
        <div>
            <button type="submit">Add</button>
        </div>
    </form>
</body>
</html>
