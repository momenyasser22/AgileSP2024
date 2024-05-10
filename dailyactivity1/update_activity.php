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

// Fetch all activity IDs
$allActivities = $controller->getAllDailyActivities();

// Initialize $activityId variable
$activityId = isset($_GET['activity_id']) ? $_GET['activity_id'] : null;

// Fetch activity details by ID if activity ID is provided
if ($activityId) {
    $activity = $controller->getDailyActivityById($activityId);
}
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
    <form action="update_process.php" method="POST">
        <label for="activity_id">Select Activity ID:</label>
        <select name="activity_id" id="activity_id">
            <?php foreach ($allActivities as $activityItem): ?>
                <option value="<?php echo $activityItem['activity_id']; ?>" <?php echo ($activityItem['activity_id'] == $activityId) ? 'selected' : ''; ?>><?php echo $activityItem['activity_id']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="newUserId">New User ID:</label>
        <input type="text" id="newUserId" name="newUserId" value="<?php echo isset($activity['userid']) ? $activity['userid'] : ''; ?>"><br><br>
        
        <label for="newActivityTypeId">New Activity Type ID:</label>
        <input type="text" id="newActivityTypeId" name="newActivityTypeId" value="<?php echo isset($activity['activity_type_id']) ? $activity['activity_type_id'] : ''; ?>"><br><br>
        
        <label for="newDateReceived">New Date Received:</label>
        <input type="date" id="newDateReceived" name="newDateReceived" value="<?php echo isset($activity['Date_Recieved']) ? $activity['Date_Recieved'] : ''; ?>"><br><br>
        
        <label for="newReceivedBy">New Received By:</label>
        <input type="text" id="newReceivedBy" name="newReceivedBy" value="<?php echo isset($activity['Recieved_By']) ? $activity['Recieved_By'] : ''; ?>"><br><br>
        
        <label for="newTimeLeaved">New Time Leaved:</label>
        <input type="time" id="newTimeLeaved" name="newTimeLeaved" value="<?php echo isset($activity['Time_Leaved']) ? $activity['Time_Leaved'] : ''; ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
