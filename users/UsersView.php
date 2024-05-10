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
    if (!$permissionController->checkPermission($userTypeID, 'UsersView.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Include the UsersController
require_once 'UsersController.php';

// Instantiate the UsersController
$usersController = new UsersController();

// Fetch all users
$users = $usersController->getAllUsers();

// Check if the ID parameter is provided for deletion
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleted = $usersController->deleteUser($id);
    
    // Redirect back to this page after deletion
    header("Location: UsersView.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
    <h2>Users</h2>
    <a href="A_users.php" class="add-button">Add New User</a>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>User Type</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['UserID']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['Password']; ?></td>
                    <td><?php echo $user['Name']; ?></td>
                    <td><?php echo $user['usertype']; ?></td>
                    <td><?php echo $user['Address']; ?></td>
                    <td>
                        <a href="U_users.php?id=<?php echo $user['UserID']; ?>">Update</a>
                        <a href="D_users.php?id=<?php echo $user['UserID']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
