<?php
session_start();

if (isset($_GET['UserID']) && isset($_GET['usertype'])) {
    $UserID = $_GET['UserID'];
    $usertype = $_GET['usertype'];

    require_once 'dbconnect.php'; // Include your database connection file
    require_once 'DailyActivityController.php'; // Include your controller
    require_once 'UsersController.php'; // Include UsersController for getting user names

    $db = Database::getInstance(); // Get the database instance
    $conn = $db->getConnection(); // Get the database connection

    $controller = new DailyActivityController(new DailyActivityModel($conn)); // Instantiate the controller with the model
    $usersController = new UsersController(); // Instantiate UsersController

    $allActivities = $controller->getAllDailyActivities(); // Get all daily activities

} else {
    header("Location: login.php"); // Redirect to login page if UserID and usertype are not provided
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Activities</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .add-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Daily Activities</h2>
    <a href="V_Permission.php?UserTypeID=<?php echo $usertype; ?>" class="add-button">Show Permissions</a><br>
    <a href="add_activity.php?UserTypeID=<?php echo $usertype; ?>" class="add-button">Add New Activity</a><br>
    <a href="update_activity.php?UserTypeID=<?php echo $usertype; ?>" class="update-button">Update existing Activity</a>
    <a href="DailyActivitydelete.php?UserTypeID=<?php echo $usertype; ?>" class="Delete-button">Delete existing Activity</a>

    <table>
        <thead>
            <tr>
                <th>Activity ID</th>
                <th>Name</th>
                <th>Activity Type ID</th>
                <th>Activity Name</th>
                <th>Date Received</th>
                <th>Received By</th>
                <th>Time Leaved</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allActivities as $activity): ?>
                <tr>
                    <td><?php echo $activity->activityId; ?></td>
                    <td><?php echo $usersController->getUserName($activity->userId); ?></td>
                    <td><?php echo $activity->activityTypeId; ?></td>
                    <td><?php echo $activity->ActivityName; ?></td>
                    <td><?php echo $activity->dateReceived; ?></td>
                    <td><?php echo $activity->receivedBy; ?></td>
                    <td><?php echo $activity->timeLeaved; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="PD_View.php?UserTypeID=<?php echo $usertype; ?>&UserID=<?php echo $UserID; ?>">View Payments</a><br>
    <a href="A_ADview.php?UserTypeID=<?php echo $usertype; ?>&UserID=<?php echo $UserID; ?>&ActivityID=<?php echo $activity->activityId; ?>">add Details</a><br>
    <a href="V_ADview.php?UserTypeID=<?php echo $usertype; ?>&UserID=<?php echo $UserID; ?>&ActivityID=<?php echo $activity->activityId; ?>">View Details</a><br>
    <a href="UserTypesView.php?UserTypeID=<?php echo $usertype; ?>" class="UserTypes Button">Show UserTypes</a><br>
    <a href="UsersView.php?UserTypeID=<?php echo $usertype; ?>" class="Users Button">Show Users</a><br>

</body>
</html>
