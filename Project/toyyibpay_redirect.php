<?php
require_once('toyyibpay_config.php');
require_once('../mysqli_connect.php'); // Adjust path if your DB connection script is elsewhere
require_once('script.php'); // Include the email sending function

$page_title = 'Payment Status';
include ('includes/header.html'); // Assuming you have a common header

echo '<div class="wrapper1" style="padding: 20px; text-align: center;">'; // Using a generic class for styling

// ToyyibPay typically sends parameters via GET for the redirect URL
$status_id = $_GET['status_id'] ?? null; // Payment status ID: 1 = success, 2 = pending, 3 = failed
$billcode = $_GET['billcode'] ?? null;
$order_id = $_GET['order_id'] ?? null; // This is our billExternalReferenceNo
$message = $_GET['msg'] ?? ''; // Message from ToyyibPay

if ($order_id && $billcode) {
    $new_payment_status = 'pending'; // Default to pending

    if ($status_id == '1') { // Success
        $new_payment_status = 'success';
        echo '<h1>Payment Successful!</h1>';
        echo '<p>Thank you for your payment. Your order (ID: ' . htmlspecialchars($order_id) . ') has been processed.</p>';
        echo '<p>ToyyibPay Transaction ID: ' . htmlspecialchars($billcode) . '</p>';
        if ($message) {
            echo '<p>Message from gateway: ' . htmlspecialchars($message) . '</p>';
        }
    } elseif ($status_id == '2') { // Pending
        $new_payment_status = 'pending';
        echo '<h1>Payment Pending</h1>';
        echo '<p>Your payment for order (ID: ' . htmlspecialchars($order_id) . ') is currently pending.</p>';
        echo '<p>ToyyibPay Transaction ID: ' . htmlspecialchars($billcode) . '</p>';
        echo '<p>We will update you once the status changes. You might need to check with your bank.</p>';
        if ($message) {
            echo '<p>Message from gateway: ' . htmlspecialchars($message) . '</p>';
        }
    } elseif ($status_id == '3') { // Failed
        $new_payment_status = 'failed';
        echo '<h1>Payment Failed</h1>';
        echo '<p>Unfortunately, your payment for order (ID: ' . htmlspecialchars($order_id) . ') could not be processed.</p>';
        echo '<p>ToyyibPay Transaction ID: ' . htmlspecialchars($billcode) . '</p>';
        if ($message) {
            echo '<p>Reason: ' . htmlspecialchars($message) . '</p>';
        }
        echo '<p>Please try again or contact us for assistance.</p>';
    } else {
        echo '<h1>Invalid Payment Status</h1>';
        echo '<p>We received an unclear payment status for your order (ID: ' . htmlspecialchars($order_id) . ').</p>';
        echo '<p>ToyyibPay Transaction ID: ' . htmlspecialchars($billcode) . '</p>';
        echo '<p>Please contact us for clarification.</p>';
    }    // Update the payment status in your database
    // Ensure $order_id is the ID from your `orders` table and $billcode matches the transaction_id
    $stmt = $dbc->prepare("UPDATE payment SET payment_status = ?, updated_at = NOW() WHERE order_id = ? AND transaction_id = ?");
    if ($stmt) {
        $stmt->bind_param('sis', $new_payment_status, $order_id, $billcode);
        if ($stmt->execute()) {
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
                        $email_subject = 'Payment Successful - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Successful</title></head>
                        <body>
                            <h2>Payment Confirmation</h2>
                            <p>Dear $customer_name,</p>
                            <p>Thank you for your payment! Your order has been successfully processed.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Successful</li>
                            </ul>
                            <p>We will contact you soon to finalize the catering arrangements for your event.</p>
                            <p>Thank you for choosing our catering services!</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                    } elseif ($new_payment_status == 'failed') {
                        $email_subject = 'Payment Failed - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Failed</title></head>
                        <body>
                            <h2>Payment Failed</h2>
                            <p>Dear $customer_name,</p>
                            <p>Unfortunately, your payment could not be processed.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Failed</li>
                            </ul>
                            <p>Please try again or contact us for assistance. You can retry the payment or arrange an alternative payment method.</p>
                            <p>If you continue to experience issues, please contact our support team.</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                    } elseif ($new_payment_status == 'pending') {
                        $email_subject = 'Payment Pending - Order #' . $order_id;
                        $email_message = "
                        <html>
                        <head><title>Payment Pending</title></head>
                        <body>
                            <h2>Payment Pending</h2>
                            <p>Dear $customer_name,</p>
                            <p>Your payment is currently being processed and is pending confirmation.</p>
                            <h3>Order Details:</h3>
                            <ul>
                                <li><strong>Order ID:</strong> #$order_id</li>
                                <li><strong>Occasion:</strong> $occasion</li>
                                <li><strong>Event Date:</strong> $event_date</li>
                                <li><strong>Total Amount:</strong> RM $total_amount</li>
                                <li><strong>Transaction ID:</strong> $billcode</li>
                                <li><strong>Payment Status:</strong> Pending</li>
                            </ul>
                            <p>We will update you once the payment status changes. This may take a few minutes to several hours depending on your payment method.</p>
                            <p>Please check with your bank if needed, or contact us if you have any concerns.</p>
                            <br>
                            <p>Best regards,<br>Catering Booking Team</p>
                        </body>
                        </html>";
                    }
                    
                    // Send the email
                    if (!empty($customer_email) && !empty($email_subject) && !empty($email_message)) {
                        $email_result = sendMail($customer_email, $email_subject, $email_message);
                        if ($email_result !== 'success') {
                            error_log("Failed to send email notification for order_id: $order_id. Error: $email_result");
                        }
                    }
                }
                $customer_stmt->close();
            }
        } else {
            // Log error: echo "Error updating payment status: " . $stmt->error;
            error_log("Failed to update payment status for order_id: $order_id, billcode: $billcode. Error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        // Log error: echo "Error preparing statement: " . $dbc->error;
        error_log("Failed to prepare statement for updating payment status. Order_id: $order_id. Error: " . $dbc->error);
    }

} else {
    echo '<h1>Invalid Access</h1>';
    echo '<p>Payment information is missing. If you have made a payment, please contact us.</p>';
}

mysqli_close($dbc);

echo '<p><a href="index.php">Return to Homepage</a></p>'; // Link to your homepage or order history
echo '</div>';

include ('includes/footer.html'); // Assuming you have a common footer
?>
