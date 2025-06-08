<?php
require_once('toyyibpay_config.php');
require_once('../mysqli_connect.php'); // Adjust path if your DB connection script is elsewhere
require_once('script.php'); // Include the email sending function

// ToyyibPay sends callback data via POST
// This is a basic example. You MUST implement proper security checks for a production environment.
// For example, verify a signature if ToyyibPay provides one, or re-query bill status.

// Read the POST data
$billcode = $_POST['billcode'] ?? null;
$status = $_POST['status'] ?? null; // Payment status: 1 = success, 2 = pending, 3 = failed
$order_id = $_POST['order_id'] ?? null; // This is our billExternalReferenceNo
$amount = $_POST['amount'] ?? null; // Amount in RM (e.g., 10.00 for RM10)
$transaction_id_toyyibpay = $_POST['transaction_id'] ?? null; // ToyyibPay's own transaction ID, if different from billcode
$msg = $_POST['msg'] ?? null; // Message from ToyyibPay, often contains more details or error messages

// For logging/debugging purposes
$raw_post_data = file_get_contents('php://input');
$log_message = "ToyyibPay Callback Received:\nOrder ID: $order_id\nBillcode: $billcode\nStatus: $status\nAmount: $amount\nToyyibPay TXN ID: $transaction_id_toyyibpay\nMessage: $msg\nRaw Data: $raw_post_data\n-------------------------------------\n";
error_log($log_message, 3, "toyyibpay_callback.log"); // Logs to a file named toyyibpay_callback.log in the same directory

if ($billcode && $order_id && $status) {
    $new_payment_status = 'pending'; // Default

    if ($status == '1') { // Success
        $new_payment_status = 'success';
    } elseif ($status == '3') { // Failed
        $new_payment_status = 'failed';
    } elseif ($status == '2') { // Pending
        $new_payment_status = 'pending';
    }

    // It's a good practice to verify the amount if provided and if it matches your records
    // $amount_in_sen_from_toyyibpay = (int)round( (float)$amount * 100 );
    // Compare with $billAmount sent when creating the bill    // Update the payment status in your database
    // Use the $order_id (billExternalReferenceNo) and $billcode to identify the payment record
    $stmt = $dbc->prepare("UPDATE payment SET payment_status = ?, updated_at = NOW() WHERE order_id = ? AND transaction_id = ?");
    if ($stmt) {
        $stmt->bind_param('sis', $new_payment_status, $order_id, $billcode);
        if ($stmt->execute()) {
            // Successfully updated
            // Get customer details for email notification
            $customer_stmt = $dbc->prepare("SELECT email, contact_person, occasion, event_date, total_budget FROM orders WHERE order_id = ?");
            if ($customer_stmt) {
                $customer_stmt->bind_param('i', $order_id);
                $customer_stmt->execute();
                $customer_result = $customer_stmt->get_result();
                
                if ($customer_result->num_rows > 0) {
                    $customer_data = $customer_result->fetch_assoc();
                    $customer_email = $customer_data['email'];
                    $customer_name = $customer_data['contact_person'];
                    $occasion = $customer_data['occasion'];
                    $event_date = $customer_data['event_date'];
                    $total_amount = $customer_data['total_budget'];
                    
                    // Send email notification based on payment status
                    $email_subject = '';
                    $email_message = '';
                    
                    if ($new_payment_status == 'success') {
                        $email_subject = 'Payment Confirmed - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Confirmed</title></head>
                        <body>
                            <h2>Payment Successfully Confirmed</h2>
                            <p>Dear $customer_name,</p>
                            <p>Great news! Your payment has been successfully confirmed by our payment gateway.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Confirmed</li>
                            </ul>
                            <p>Your order is now confirmed and we will proceed with the catering arrangements. Our team will contact you within 24-48 hours to discuss the details and finalize your event requirements.</p>
                            <p>Thank you for choosing our catering services!</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                        
                        // Trigger order fulfillment logic here if needed
                        // You can add additional processing for successful payments
                        
                    } elseif ($new_payment_status == 'failed') {
                        $email_subject = 'Payment Failed - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Failed</title></head>
                        <body>
                            <h2>Payment Failed</h2>
                            <p>Dear $customer_name,</p>
                            <p>We regret to inform you that your payment could not be processed successfully.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Failed</li>
                            </ul>
                            <p>Don't worry - your order is still reserved. Please try the following:</p>
                            <ul>
                                <li>Check your card details and try again</li>
                                <li>Contact your bank to ensure your card can make online payments</li>
                                <li>Try using a different payment method</li>
                                <li>Contact us directly for assistance</li>
                            </ul>
                            <p>If you continue to experience issues, please contact our support team and we'll help you complete your order.</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                        
                    } elseif ($new_payment_status == 'pending') {
                        $email_subject = 'Payment Status Update - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Status Update</title></head>
                        <body>
                            <h2>Payment Status Update</h2>
                            <p>Dear $customer_name,</p>
                            <p>This is an update regarding your payment status. Your payment is still being processed.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Pending</li>
                            </ul>
                            <p>Your payment is currently being verified. This process may take some time depending on your payment method and bank processing times.</p>
                            <p>We will notify you immediately once the payment status is confirmed. No action is required from your side at this time.</p>
                            <p>If you have any concerns, please contact us or check with your bank.</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                    }
                    
                    // Send the email
                    if (!empty($customer_email) && !empty($email_subject) && !empty($email_message)) {
                        $email_result = sendMail($customer_email, $email_subject, $email_message);
                        if ($email_result !== 'success') {
                            error_log("ToyyibPay Callback: Failed to send email notification for order_id: $order_id. Error: $email_result", 3, "toyyibpay_callback.log");
                        } else {
                            error_log("ToyyibPay Callback: Email notification sent successfully for order_id: $order_id, status: $new_payment_status", 3, "toyyibpay_callback.log");
                        }
                    }
                }
                $customer_stmt->close();
            }
            
            http_response_code(200); // Send a 200 OK response to ToyyibPay to acknowledge receipt
            echo "Callback received and processed.";
        } else {
            // Failed to update database
            error_log("ToyyibPay Callback: DB update failed for order_id $order_id, billcode $billcode. Error: " . $stmt->error, 3, "toyyibpay_callback.log");
            http_response_code(500); // Internal Server Error
            echo "Error updating database.";
        }
        $stmt->close();
    } else {
        // Failed to prepare statement
        error_log("ToyyibPay Callback: DB prepare statement failed for order_id $order_id. Error: " . $dbc->error, 3, "toyyibpay_callback.log");
        http_response_code(500);
        echo "Error preparing database statement.";
    }
    mysqli_close($dbc);
} else {
    // Required parameters not received
    error_log("ToyyibPay Callback: Missing required parameters. Raw Data: $raw_post_data", 3, "toyyibpay_callback.log");
    http_response_code(400); // Bad Request
    echo "Missing required parameters.";
}
?>
