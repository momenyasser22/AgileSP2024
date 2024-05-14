<?php
require_once 'dbconnect.php';

class UserPaymentDetails {
    public $userId;
    public $orderId;
    public $paymentOptions;
    public $paymentType;
    public $optionValue;
    public $price;

    public function __construct($userId, $orderId, $paymentOptions, $paymentType, $optionValue, $price) {
        $this->userId = $userId;
        $this->orderId = $orderId;
        $this->paymentOptions = $paymentOptions;
        $this->paymentType = $paymentType;
        $this->optionValue = $optionValue;
        $this->price = $price;
    }
}

class PaymentOption {
    public $id;
    public $optionName;

    public function __construct($id, $optionName) {
        $this->id = $id;
        $this->optionName = $optionName;
    }
}

class UserPaymentDetailsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Fetch user payment details by user ID
    public function getUserPaymentDetails($userId) {
        $query = "SELECT pd.UserID, pd.OrderID, pov.PaymentOptionID, pov.Value as optionValue, o.OptionName, pm.Name as PaymentType, pd.Price
                  FROM paymentsdone pd
                  INNER JOIN paymentsoptionvalue pov ON pd.OrderID = pov.OrderID
                  LEFT JOIN options o ON pov.PaymentOptionID = o.ID
                  LEFT JOIN paymentmethodopt pmo ON pov.PaymentOptionID = pmo.OptionID
                  LEFT JOIN paymentmethod pm ON pmo.PaymentMethodID = pm.Id
                  WHERE pd.UserID = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $userPaymentDetails = [];

        while ($row = $result->fetch_assoc()) {
            $paymentOption = new PaymentOption($row['PaymentOptionID'], $row['OptionName']);
            // Pass the option value to the constructor of UserPaymentDetails
            $userPaymentDetails[] = new UserPaymentDetails($row['UserID'], $row['OrderID'], $paymentOption, $row['PaymentType'], $row['optionValue'], $row['Price']);
        }

        $stmt->close();

        return $userPaymentDetails;
    }

    // Fetch all payments Ovveride Functions for the Admin User
    public function getAllPayments() {
        $query = "SELECT pd.UserID, pd.OrderID, pov.PaymentOptionID, pov.Value as optionValue, o.OptionName, pm.Name as PaymentType, pd.Price
                  FROM paymentsdone pd
                  INNER JOIN paymentsoptionvalue pov ON pd.OrderID = pov.OrderID
                  LEFT JOIN options o ON pov.PaymentOptionID = o.ID
                  LEFT JOIN paymentmethodopt pmo ON pov.PaymentOptionID = pmo.OptionID
                  LEFT JOIN paymentmethod pm ON pmo.PaymentMethodID = pm.Id";

        $result = $this->db->query($query);

        $payments = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $paymentOption = new PaymentOption($row['PaymentOptionID'], $row['OptionName']);
                // Pass the option value to the constructor of UserPaymentDetails
                $payments[] = new UserPaymentDetails($row['UserID'], $row['OrderID'], $paymentOption, $row['PaymentType'], $row['optionValue'], $row['Price']);
            }
        }

        return $payments;
    }
}
?>
