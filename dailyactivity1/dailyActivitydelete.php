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
    if (!$permissionController->checkPermission($userTypeID, 'dailyActivitydelete.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Fetch all activity IDs
$allActivities = $controller->getAllDailyActivities();

// Check if form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activity_id'])) {
    $activityId = $_POST['activity_id'];
    $deleteSuccess = $controller->deleteDailyActivity($activityId);
    if ($deleteSuccess) {
        echo "Activity deleted successfully!";
        header("Location: view.php?deleted=true");
    } else {
        echo "Error deleting activity!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Activity</title>
</head>
<body>
    <h2>Delete Activity</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="activity_id">Select Activity ID to delete:</label>
        <select name="activity_id" id="activity_id">
            <?php foreach ($allActivities as $activityItem): ?>
                <option value="<?php echo $activityItem['activity_id']; ?>"><?php echo $activityItem['activity_id']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Delete">
    </form>
</body>
</html>
