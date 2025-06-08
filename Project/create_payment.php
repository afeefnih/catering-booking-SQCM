<?php
// This script creates a payment record in the payment table for a given order.
// It is intended to be called after an order is submitted.

// Function to create a payment record
function createPaymentRecord($order_id, $amount) {
    require_once('../mysqli_connect.php');
    
    // Sanitize inputs
    $order_id = mysqli_real_escape_string($dbc, $order_id);
    $amount = mysqli_real_escape_string($dbc, $amount);
    
    // Set default payment status to Pending
    $status = 'Pending';
    
    // Create the SQL query
    $q = "INSERT INTO payment (order_id, amount, payment_status) VALUES ($order_id, $amount, '$status')";
    
    // Execute the query
    $r = @mysqli_query($dbc, $q);
    
    // Check if the query was successful
    if ($r) {
        // Get the payment ID
        $payment_id = mysqli_insert_id($dbc);
        return $payment_id;
    } else {
        // Return an error message
        return "Error creating payment record: " . mysqli_error($dbc);
    }
}

// If this script is called directly with POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if order_id and amount are set
    if (isset($_POST['order_id']) && isset($_POST['amount'])) {
        $order_id = $_POST['order_id'];
        $amount = $_POST['amount'];
        
        // Create payment record
        $result = createPaymentRecord($order_id, $amount);
        
        // Return result as JSON
        header('Content-Type: application/json');
        if (is_numeric($result)) {
            echo json_encode(['success' => true, 'payment_id' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => $result]);
        }
    } else {
        // Return error if required fields are missing
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Order ID and amount are required']);
    }
}
?> 