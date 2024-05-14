<?php
require_once 'dbconnect.php';
require_once 'DailyActivityController.php';
require_once 'PermissionController.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$controller = new DailyActivityController(new DailyActivityModel($conn));
$permissionController = new PermissionController();

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'update_activity.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $activityId = $_POST['activity_id'];
    $newUserId = $_POST['newUserId'];
    $newActivityTypeId = $_POST['newActivityTypeId'];
    $newDateReceived = $_POST['newDateReceived'];
    $newReceivedBy = $_POST['newReceivedBy'];
    $newTimeLeaved = $_POST['newTimeLeaved'];
    $activityName = $_POST['activityName']; // Retrieve activity name

    // Create a DailyActivity object with the updated data
    $updatedActivity = new DailyActivity($activityId, $newUserId, $newActivityTypeId, $newDateReceived, $newReceivedBy, $newTimeLeaved, $activityName);

    // Update the daily activity
    $result = $controller->updateDailyActivity($updatedActivity);

    if ($result) {
        echo "Activity updated successfully!";
        // Redirect to a success page or display a success message
    } else {
        // Redirect to an error page or display an error message
        header("Location: update_error.php");
        exit();
    }
} else {
    // Redirect to an error page or display an error message
    header("Location: update_error.php");
    exit();
}
?>
