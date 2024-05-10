<?php
require_once 'PermissionController.php';

// Check if the user type ID is provided in the URL
if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user has permission to delete daily activity details
    $permissionController = new PermissionController();
    echo $userTypeID;
    if (!$permissionController->checkPermission($userTypeID, 'delete_activity_detail.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

require_once 'DailyActivityDetailsController.php';
require_once 'dbconnect.php';

$db = Database::getInstance();
$conn = $db->getConnection();

// Create an instance of the controller
$controller = new DailyActivityDetailsController(new DailyActivityDetailsModel($conn));

// Initialize variables to store detail data
$detailId = '';
$grade = '';
$comment = '';
$updateSuccess = false;
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $detailId = $_POST['detail_id'];
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

    // Update the daily activity detail
    $updateSuccess = $controller->updateDailyActivityDetails($detailId, $grade, $comment);

    if ($updateSuccess) {
        // Redirect back to the view page after successful update
        header("Location: V_ADview.php");
        exit();
    } else {
        // Set an error message if the update operation fails
        $errorMessage = "Update operation failed.";
    }
} else {
    // Check if the detail ID is provided in the URL
    if(isset($_GET['detail_id'])) {
        $detailId = $_GET['detail_id'];
        
        // Fetch the detail based on the detail ID from the URL
        $detail = $controller->getDailyActivityDetailsByDetailId($detailId);
        
        if ($detail) {
            // Populate variables with detail data
            $grade = $detail['Grade'];
            $comment = $detail['Comment'];
        } else {
            // Handle the case where the detail with the given ID is not found
            $errorMessage = "Detail not found.";
        }
    } else {
        // Handle the case where the detail ID is not provided
        $errorMessage = "Detail ID is not provided.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Daily Activity Detail</title>
</head>
<body>
    <h2>Update Daily Activity Detail</h2>
    
    <?php if ($errorMessage): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="detail_id" value="<?php echo $detailId; ?>">
        <div>
            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade" value="<?php echo $grade; ?>">
        </div>
        <div>
            <label for="comment">Comment:</label>
            <input type="text" id="comment" name="comment" value="<?php echo $comment; ?>">
        </div>
        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</body>
</html>
