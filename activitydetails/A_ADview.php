<?php
session_start();

require_once 'PermissionController.php';
require_once 'DailyActivityDetailsController.php';
require_once 'dbconnect.php';

$db = Database::getInstance();
$conn = $db->getConnection();

// Create an instance of the controller
$controller = new DailyActivityDetailsController(new DailyActivityDetailsModel($conn));
$permissionController = new PermissionController();

if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'A_ADview.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activityId = $_POST['activity_id'];
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

    // Add the daily activity detail
    $success = $controller->addDailyActivityDetails($activityId, $grade, $comment);

    if ($success) {
        // Redirect back to the same page to clear the form
        header("Location: A_ADview.php?UserTypeID=0");
        exit;
    } else {
        // Handle the error if adding the detail fails
        echo "Error adding daily activity detail.";
    }
}

// Fetch all activity IDs
$activityIds = $controller->getAllActivityIds();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Daily Activity Detail</title>
</head>
<body>
    <h2>Add Daily Activity Detail</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="activity_id">Activity ID:</label>
            <select id="activity_id" name="activity_id">
                <?php foreach ($activityIds as $activityId): ?>
                    <option value="<?php echo $activityId; ?>"><?php echo $activityId; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade">
        </div>
        <div>
            <label for="comment">Comment:</label>
            <input type="text" id="comment" name="comment">
        </div>
        <div>
            <button type="submit">Add Detail</button>
        </div>
    </form>
</body>
</html>
