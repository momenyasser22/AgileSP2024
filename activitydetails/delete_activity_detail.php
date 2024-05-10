<?php
session_start();

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

// Check if the detail ID is provided in the URL
if (isset($_GET['detail_id'])) {
    $detailId = $_GET['detail_id'];

    // Fetch the detail based on the detail ID
    $detail = $controller->getDailyActivityDetailsByDetailId($detailId);
    
    // Check if the detail belongs to the provided user type ID and activity ID
    if ($detail && $detail['UserTypeID'] == $_SESSION['UserTypeID']) {
        // Delete the daily activity detail
        $deleteSuccess = $controller->deleteDailyActivityDetails($detailId);

        if ($deleteSuccess) {
            // Redirect back to the view page
            header("Location: V_ADview.php?UserTypeID={$userTypeID}&UserID={$_GET['UserID']}&ActivityID={$_GET['ActivityID']}");
            exit();
        }
    } else {
        // Redirect with error message if detail does not belong to the provided user type ID
        header("Location: permission_denied.php");
        exit();
    }
}
?>
