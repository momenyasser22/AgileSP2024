<?php
session_start();
require_once 'PermissionController.php';
require_once 'dbconnect.php';
require_once 'DailyActivityController.php';
require_once 'DailyActivityModel.php'; 
require_once 'UsersController.php';
require_once 'UserTypesController.php';

// Check if the user has permission to add a new daily activity
$permissionController = new PermissionController();

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'add_activity.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Instantiate the UsersController object
$usersController = new UsersController();

// Instantiate the UserTypesController object
$userTypesController = new UserTypesController();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $db = Database::getInstance();
    $conn = $db->getConnection();

    // Instantiate the DailyActivityController
    $controller = new DailyActivityController(new DailyActivityModel($conn));

    // Fetch available user IDs and activity types
    $userIDs = $usersController->getAllUserIds();
    $activityTypes = $userTypesController->getAllActivityTypes();

    // Get activity name by type ID
    $selectedActivityTypeID = $_POST['activityTypeId'];
    $activityName = $controller->getActivityNameByTypeId($selectedActivityTypeID);

    // Create a new DailyActivity object
    $activity = new DailyActivity(
        null,
        $_POST['user_id'],
        $_POST['activityTypeId'],
        $_POST['dateReceived'],
        $_POST['receivedBy'],
        $_POST['timeLeaved'],
        $activityName // Use retrieved activity name
    );

    // Add the new daily activity
    $result = $controller->addDailyActivity($activity);
    
    // Check the result and provide feedback
    if ($result) {
        echo "New daily activity added successfully!";
    } else {
        echo "Error adding new daily activity.";
    }
}

// Fetch available user IDs and activity types
$userIDs = $usersController->getAllUserIds();
$activityTypes = $userTypesController->getAllActivityTypes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Daily Activity</title>
</head>
<body>
    <h2>Add New Daily Activity</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="user_id">User ID:</label>
        <select id="user_id" name="user_id">
            <?php foreach ($userIDs as $userID): ?>
                <option value="<?php echo $userID; ?>"><?php echo $userID; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="activityTypeId">Activity Type:</label>
        <select id="activityTypeId" name="activityTypeId">
            <?php foreach ($activityTypes as $activityType): ?>
                <option value="<?php echo $activityType['type_id']; ?>"><?php echo $activityType['ActivityName']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        
        <label for="dateReceived">Date Received:</label>
        <input type="date" id="dateReceived" name="dateReceived"><br><br>
        
        <label for="newReceivedBy">New Received By:</label>
        <select id="newReceivedBy" name="newReceivedBy">
            <?php foreach ($userIDs as $userID): ?>
                <option value="<?php echo $userID; ?>"><?php echo $userID; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="timeLeaved">Time Leaved:</label>
        <input type="time" id="timeLeaved" name="timeLeaved"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
