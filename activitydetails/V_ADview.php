<?php
session_start();

if (isset($_GET['UserID']) && isset($_GET['UserTypeID']) && isset($_GET['ActivityID'])) {
    $UserID = $_GET['UserID'];
    $UserTypeID = $_GET['UserTypeID'];
    $ActivityID = $_GET['ActivityID'];

    require_once 'dbconnect.php';
    require_once 'DailyActivityDetailsController.php';
    require_once 'PermissionController.php';

    $db = Database::getInstance();
    $conn = $db->getConnection();
    $controller = new DailyActivityDetailsController(new DailyActivityDetailsModel($conn));
    $permissionController = new PermissionController();

    // Check if the user has permission to view daily activity details
    if (!$permissionController->checkPermission($UserTypeID, 'V_ADview.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }

    if ($UserTypeID === '0') {
        $activityDetails = $controller->getAllDailyActivityDetails();
    } else {
        $activityDetails = $controller->getDailyActivityDetailsByActivityId($ActivityID);
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Activity Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Daily Activity Details</h2>
    <table>
        <thead>
            <tr>
                <th>Detail ID</th>
                <th>Activity ID</th>
                <th>Grade</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activityDetails as $detail): ?>
                <tr>
                    <td><?php echo $detail['DetailID']; ?></td>
                    <td><?php echo $detail['ActivityID']; ?></td>
                    <td><?php echo $detail['Grade']; ?></td>
                    <td><?php echo $detail['Comment']; ?></td>
                    <td>
                        <a href="update_activity_detail.php?detail_id=<?php echo $detail['DetailID']; ?>&UserTypeID=<?php echo $UserTypeID; ?>">Update</a>
                        <a href="delete_activity_detail.php?detail_id=<?php echo $detail['DetailID']; ?>&UserTypeID=<?php echo $UserTypeID; ?>&UserID=<?php echo $UserID; ?>&ActivityID=<?php echo $ActivityID; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
