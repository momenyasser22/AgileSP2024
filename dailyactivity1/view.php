<?php
session_start();

// Check if UserID and usertype are provided in the URL
if (isset($_GET['UserID']) && isset($_GET['usertype'])) {
    $UserID = $_GET['UserID'];
    $usertype = $_GET['usertype'];

    // Database connection
    require_once 'dbconnect.php'; // Include your database connection file
    require_once 'DailyActivityController.php';

    $db = Database::getInstance();
    $conn = $db->getConnection();

    $controller = new DailyActivityController(new DailyActivityModel($conn));

    // Fetch all daily activities for the specific user
    $allActivities = $controller->getDailyActivitiesByUserID($UserID);

    // Assuming you have a function to get activity names, you can fetch them here

} else {
    // If UserID and usertype are not provided, redirect to the login page
    header("Location: login.php");
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
    
    <a href="add_activity.php" class="add-button">Add New Activity</a>
    <a href="update_activity.php" class="update-button">Update existing Activity</a>
    <a href="DailyActivitydelete.php" class="Delete-button">Delete existing Activity</a>

    <table>
    <thead>
    <tr>
        <th>Activity ID</th>
        <th>User ID</th>
        <th>Activity Type ID</th>
        <th>Activity Name</th>
        <th>Date Received</th>
        <th>Received By</th>
        <th>Time Leaved</th> <!-- Added this column -->
    </tr>
</thead>
<tbody>
    <?php foreach ($allActivities as $activity): ?>
        <tr>
            <td><?php echo isset($activity['activity_id']) ? $activity['activity_id'] : ''; ?></td>
            <td><?php echo isset($activity['user_id']) ? $activity['user_id'] : ''; ?></td>
            <td><?php echo isset($activity['activity_type_id']) ? $activity['activity_type_id'] : ''; ?></td>
            <td><?php echo isset($activity['ActivityName']) ? $activity['ActivityName'] : ''; ?></td>
            <td><?php echo isset($activity['Date_Recieved']) ? $activity['Date_Recieved'] : ''; ?></td>
            <td><?php echo isset($activity['Recieved_By']) ? $activity['Recieved_By'] : ''; ?></td>
            <td><?php echo isset($activity['Time_Leaved']) ? $activity['Time_Leaved'] : ''; ?></td> <!-- Added this column -->
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>
    <a href="A_ADview.php?UserTypeID=<?php echo $usertype; ?>&UserID=<?php echo $UserID; ?>&ActivityID=<?php echo $activity['activity_id']; ?>">add Details</a><br>
    <a href="V_ADview.php?UserTypeID=<?php echo $usertype; ?>&UserID=<?php echo $UserID; ?>&ActivityID=<?php echo $activity['activity_id']; ?>">View Details</a><br>
    <a href="UserTypesView.php?UserTypeID=<?php echo $usertype; ?>" class="UserTypes Button">Show UserTypes</a><br>
    <a href="UsersView.php?UserTypeID=<?php echo $usertype; ?>" class="Users Button">Show Users </a><br>

</body>
</html>
