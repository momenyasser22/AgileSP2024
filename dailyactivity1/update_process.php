<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['activity_id'])) {
    // Get form data
    $activityId = $_POST['activity_id'];
    $newUserId = $_POST['newUserId'];
    $newActivityTypeId = $_POST['newActivityTypeId'];
    $newDateReceived = $_POST['newDateReceived'];
    $newReceivedBy = $_POST['newReceivedBy'];
    $newTimeLeaved = $_POST['newTimeLeaved'];

    // Database connection
    require_once 'dbconnect.php'; // Include your database connection file
    require_once 'DailyActivityController.php';

    $db = Database::getInstance();
    $conn = $db->getConnection();

    $controller = new DailyActivityController(new DailyActivityModel($conn));

    // Update the activity
    $updateSuccess = $controller->updateDailyActivity($activityId, [
        'user_id' => $newUserId,
        'activity_type_id' => $newActivityTypeId,
        'Date_Recieved' => $newDateReceived,
        'Recieved_By' => $newReceivedBy,
        'Time_Leaved' => $newTimeLeaved
    ]);

    if ($updateSuccess) {
        echo "Activity updated successfully!";
        exit(); // Add exit to prevent further execution
    } else {
        echo "Error updating activity!";
    }
} else {
    // If form is not submitted, redirect to the view page
    header("Location: view.php");
    exit();
}
?>
