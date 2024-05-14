<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Payment Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php
require_once 'PD_Controller.php';
require_once 'UsersController.php'; // Include UsersController for fetching user name

// Initialize controllers
$paymentController = new UserPaymentDetailsController();
$userController = new UsersController(); // Assuming UsersController contains getUserName method

// Check if UserTypeID and UserID are provided in the URL
if (isset($_GET['UserTypeID']) && isset($_GET['UserID'])) {
    $userTypeID = $_GET['UserTypeID'];
    $userID = $_GET['UserID'];

    // Check if the user type is 0 (admin)
    if ($userTypeID == 0) {
        // Retrieve all payments
        $userPaymentDetails = $paymentController->getAllPayments();
    } else {
        // Retrieve user payment details based on user ID
        $userPaymentDetails = $paymentController->getUserPaymentDetails($userID);
    }

    // Check if user payment details are available
    if ($userPaymentDetails) {
        // Display user payment details in a table
        echo '<table>';
        echo '<tr><th>User ID</th><th>Name</th><th>Order ID</th><th>Payment Option</th><th>Payment Type</th><th>Option Value</th><th>Price</th></tr>';
        foreach ($userPaymentDetails as $paymentDetail) {
            // Fetch user name using UserID
            $userName = $userController->getUserName($paymentDetail->userId);

            echo '<tr>';
            echo '<td>' . $paymentDetail->userId . '</td>';
            echo '<td>' . $userName . '</td>';
            echo '<td>' . $paymentDetail->orderId . '</td>';
            echo '<td>' . $paymentDetail->paymentOptions->optionName . '</td>';
            echo '<td>' . $paymentDetail->paymentType . '</td>';
            echo '<td>' . $paymentDetail->optionValue . '</td>'; 
            echo '<td>' . $paymentDetail->price . '</td>'; 
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No payment details found for the user.';
    }
} else {
    echo 'UserTypeID and UserID are required parameters.';
}
?>

</body>
</html>
