<?php
session_start();

// Include the PermissionController
require_once 'PermissionController.php';

// Instantiate the PermissionController
$permissionController = new PermissionController();

// Check if the user type ID is provided in the URL
if (isset($_GET['UserTypeID'])) {
    $userTypeID = $_GET['UserTypeID'];

    // Check if the user type ID is not zero (i.e., not admin)
    if (!$permissionController->checkPermission($userTypeID, 'UserTypesView.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

require_once 'UserTypesController.php';

// Instantiate the controller
$userTypesController = new UserTypesController();

// Fetch all user types
$userTypes = $userTypesController->getAllUserTypes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Types</title>
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
    </style>
</head>
<body>
    <h2>User Types</h2>
    <a href="A_Usertypes.php" class="add-button">Add New UserTypes</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userTypes as $userType): ?>
                <tr>
                    <td><?php echo $userType['id']; ?></td>
                    <td><?php echo $userType['Type']; ?></td>
                    <td>
                        <a href="U_Usertypes.php?id=<?php echo $userType['id']; ?>">Update</a>
                        <a href="D_usertype.php?id=<?php echo $userType['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
