<?php
require_once 'dbconnect.php';
require_once 'DailyActivityController.php';
require_once 'PermissionController.php';
require_once 'UsersController.php';
require_once 'UserTypesController.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$controller = new DailyActivityController(new DailyActivityModel($conn));
$permissionController = new PermissionController();
$usersController = new UsersController();
$userTypesController = new UserTypesController();

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'update_activity.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Fetch all activity IDs
$allActivities = $controller->getAllDailyActivities();

// Initialize $activityId variable
$activityId = isset($_GET['activity_id']) ? $_GET['activity_id'] : null;

// Fetch activity details by ID if activity ID is provided
if ($activityId) {
    $activity = $controller->getDailyActivityById($activityId);
}

// Fetch user IDs from UsersController
$userIDs = $usersController->getAllUserIds();

// Fetch activity type IDs and names from UserTypesController
$activityTypes = $userTypesController->getAllActivityTypes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Activity</title>
</head>
<body>
    <h2>Update Activity</h2>
    <form action="update_process.php?UserTypeID=<?php echo isset($_GET['UserTypeID']) ? $_GET['UserTypeID'] : ''; ?>" method="POST">
        <label for="activity_id">Select Activity ID:</label>
        <select name="activity_id" id="activity_id">
            <?php foreach ($allActivities as $activityItem): ?>
                <option value="<?php echo $activityItem->activityId; ?>" <?php echo ($activityItem->activityId == $activityId) ? 'selected' : ''; ?>><?php echo $activityItem->activityId; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="newUserId">New User ID:</label>
        <select id="newUserId" name="newUserId">
            <?php foreach ($userIDs as $userID): ?>
                <option value="<?php echo $userID; ?>"><?php echo $userID; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="newActivityTypeId">New Activity Type ID:</label>
        <select id="newActivityTypeId" name="newActivityTypeId">
            <?php foreach ($activityTypes as $activityType): ?>
                <option value="<?php echo $activityType['type_id']; ?>"><?php echo $activityType['ActivityName']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="newDateReceived">New Date Received:</label>
        <input type="date" id="newDateReceived" name="newDateReceived" value="<?php echo isset($activity->dateReceived) ? $activity->dateReceived : ''; ?>"><br><br>
        
        <label for="newReceivedBy">New Received By:</label>
        <select id="newReceivedBy" name="newReceivedBy">
            <?php foreach ($userIDs as $userID): ?>
                <option value="<?php echo $userID; ?>"><?php echo $userID; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="newTimeLeaved">New Time Leaved:</label>
        <input type="time" id="newTimeLeaved" name="newTimeLeaved" value="<?php echo isset($activity->timeLeaved) ? $activity->timeLeaved : ''; ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
