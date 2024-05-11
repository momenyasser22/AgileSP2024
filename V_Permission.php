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
    if (!$permissionController->checkPermission($userTypeID, 'V_Permission.php')) {
        // Redirect to an error page or display an access denied message
        header("Location: permission_denied.php");
        exit();
    }
}

// Fetch all permissions
$permissions = $permissionController->getAllPermissions();

// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_permission'])) {
    $permno = $_POST['permno'];

    // Attempt to delete the permission
    $deleteSuccess = $permissionController->deletePermission($permno);

    if ($deleteSuccess) {
        // Redirect to the same page to refresh the view
        header("Location: V_Permission.php?UserTypeID=$userTypeID");
        exit();
    } else {
        // If deletion failed, handle the error (e.g., display an error message)
        echo "Failed to delete permission.";
    }
}

// Check if the form is submitted for adding permission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_permission'])) {
    $newUserTypeID = $_POST['new_usertype_id'];
    $newPageName = $_POST['new_page_name'];

    // Attempt to add the permission
    $addSuccess = $permissionController->addPermission($newUserTypeID, $newPageName);

    if ($addSuccess) {
        // Redirect to the same page to refresh the view
        header("Location: V_Permission.php?UserTypeID=$userTypeID");
        exit();
    } else {
        // If addition failed, handle the error (e.g., display an error message)
        echo "Failed to add permission.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissions</title>
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
    <h2>Permissions</h2>

    <!-- Display table of permissions -->
    <table>
        <thead>
            <tr>
                <th>Permission Number</th>
                <th>User Type ID</th>
                <th>Page Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td><?php echo $permission['permno']; ?></td>
                    <td><?php echo $permission['usertype']; ?></td>
                    <td><?php echo $permission['pagename']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <!-- Form for deleting permission -->
    <h3>Delete Permission</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?UserTypeID=' . $userTypeID; ?>" method="post">
        <label for="permno">Select Permission Number to Delete:</label>
        <select name="permno" id="permno">
            <?php foreach ($permissions as $permission): ?>
                <option value="<?php echo $permission['permno']; ?>"><?php echo $permission['permno']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="delete_permission">Delete</button>
    </form>

    <br>

    <!-- Form for adding permission -->
    <h3>Add Permission</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?UserTypeID=' . $userTypeID; ?>" method="post">
        <label for="new_usertype_id">User Type ID:</label>
        <input type="text" id="new_usertype_id" name="new_usertype_id">
        <label for="new_page_name">Page Name:</label>
        <input type="text" id="new_page_name" name="new_page_name">
        <button type="submit" name="add_permission">Add Permission</button>
    </form>
</body>
</html>
