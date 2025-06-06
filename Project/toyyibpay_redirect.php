<?php
require_once('toyyibpay_config.php');
require_once('../mysqli_connect.php'); // Adjust path if your DB connection script is elsewhere
require_once('script.php'); // Include the email sending function

// Handle PHP processing first (before any HTML output)
$status_id = $_GET['status_id'] ?? null; // Payment status ID: 1 = success, 2 = pending, 3 = failed
$billcode = $_GET['billcode'] ?? null;
$order_id = $_GET['order_id'] ?? null; // This is our billExternalReferenceNo
$message = $_GET['msg'] ?? ''; // Message from ToyyibPay

$customer_data = null;
$new_payment_status = 'pending'; // Default to pending

if ($order_id && $billcode) {
    if ($status_id == '1') { // Success
        $new_payment_status = 'success';
    } elseif ($status_id == '2') { // Pending
        $new_payment_status = 'pending';
    } elseif ($status_id == '3') { // Failed
        $new_payment_status = 'failed';
    }

    // Update the payment status in your database
    $stmt = $dbc->prepare("UPDATE payment SET payment_status = ?, updated_at = NOW() WHERE order_id = ? AND transaction_id = ?");
    if ($stmt) {
        $stmt->bind_param('sis', $new_payment_status, $order_id, $billcode);
        if ($stmt->execute()) {
            // Get customer details for both display and email notification
            $customer_stmt = $dbc->prepare("SELECT email, contact_person, occasion, event_date, event_time, event_address, location, budget, num_pax, total_budget, company_name, special_req, promo_code, subscribe, contact_no FROM orders WHERE order_id = ?");
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
            error_log("Failed to update payment status for order_id: $order_id, billcode: $billcode. Error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for updating payment status. Order_id: $order_id. Error: " . $dbc->error);
    }
}

mysqli_close($dbc);

// Now start HTML output
$page_title = 'Payment Status';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="includes/req_quotation_form.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .payment-status-wrapper {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .status-success {
            border-left: 5px solid #28a745;
        }
        
        .status-failed {
            border-left: 5px solid #dc3545;
        }
        
        .status-pending {
            border-left: 5px solid #ffc107;
        }
        
        .status-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .status-success h1 { color: #28a745; }
        .status-failed h1 { color: #dc3545; }
        .status-pending h1 { color: #f57c00; }
        
        .order-details {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e9ecef;
        }
        
        .order-details h2 {
            color: #343a40;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: bold;
            color: #495057;
            min-width: 150px;
        }
        
        .detail-value {
            color: #6c757d;
            text-align: right;
            flex: 1;
        }
        
        .transaction-info {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #bbdefb;
        }
        
        .navigation-links {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 0 10px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #0056b3;
            color: white;
        }
        
        .divider {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, #007bff, transparent);
            margin: 30px 0;
        }
        
        .confirmation-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include ('includes/header.html'); ?>

<div class="payment-status-wrapper <?php 
    if ($new_payment_status == 'success') echo 'status-success';
    elseif ($new_payment_status == 'failed') echo 'status-failed';
    else echo 'status-pending';
?>">

<?php if ($order_id && $billcode && $customer_data): ?>
    
    <div class="status-header">
        <?php if ($new_payment_status == 'success'): ?>
            <h1><i class="fa fa-check-circle"></i> Thank you!</h1>
            <p style="font-size: 18px; color: #28a745;">You are now registered!</p>
        <?php elseif ($new_payment_status == 'failed'): ?>
            <h1><i class="fa fa-times-circle"></i> Payment Failed</h1>
            <p style="font-size: 18px; color: #dc3545;">Unfortunately, your payment could not be processed.</p>
        <?php else: ?>
            <h1><i class="fa fa-clock-o"></i> Payment Pending</h1>
            <p style="font-size: 18px; color: #f57c00;">Your payment is currently being processed.</p>
        <?php endif; ?>
    </div>

    <div class="order-details">
        <h2>Here are your event details:</h2>
        
        <div class="detail-item">
            <span class="detail-label">Occasion:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['occasion']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Event Date:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['event_date']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Event Time:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['event_time']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Event Address:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['event_address']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Location:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['location']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Budget/Pax:</span>
            <span class="detail-value">RM<?php echo htmlspecialchars($customer_data['budget']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Number of Pax:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['num_pax']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Total Budget:</span>
            <span class="detail-value"><strong>RM<?php echo htmlspecialchars($customer_data['total_budget']); ?></strong></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Contact Person:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['contact_person']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Contact Number:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['contact_no']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Email:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['email']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Company Name:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['company_name']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Special Request:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['special_req']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Promo Code:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['promo_code']); ?></span>
        </div>
        
        <div class="detail-item">
            <span class="detail-label">Subscribe:</span>
            <span class="detail-value"><?php echo htmlspecialchars($customer_data['subscribe']); ?></span>
        </div>
    </div>

    <div class="transaction-info">
        <h3><i class="fa fa-credit-card"></i> Payment Information</h3>
        <div class="detail-item">
            <span class="detail-label">Order ID:</span>
            <span class="detail-value">#<?php echo htmlspecialchars($order_id); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Transaction ID:</span>
            <span class="detail-value"><?php echo htmlspecialchars($billcode); ?></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Payment Status:</span>
            <span class="detail-value">
                <?php 
                if ($new_payment_status == 'success') echo '<strong style="color: #28a745;">Successful</strong>';
                elseif ($new_payment_status == 'failed') echo '<strong style="color: #dc3545;">Failed</strong>';
                else echo '<strong style="color: #f57c00;">Pending</strong>';
                ?>
            </span>
        </div>
        <?php if ($message): ?>
        <div class="detail-item">
            <span class="detail-label">Gateway Message:</span>
            <span class="detail-value"><?php echo htmlspecialchars($message); ?></span>
        </div>
        <?php endif; ?>
    </div>

    <hr class="divider">

    <?php if ($new_payment_status == 'success'): ?>
        <div class="confirmation-message">
            <p><strong>Thank you for registering with us. We will contact you soon.</strong></p>
            <p>Email has been sent successfully.</p>
        </div>
    <?php elseif ($new_payment_status == 'failed'): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; margin: 20px 0; text-align: center;">
            <p><strong>Payment failed. Please try again or contact us for assistance.</strong></p>
            <p>Your order is still reserved. You can retry the payment or arrange an alternative payment method.</p>
        </div>
    <?php else: ?>
        <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; border: 1px solid #ffeaa7; margin: 20px 0; text-align: center;">
            <p><strong>Your payment is being processed. We will update you once the status changes.</strong></p>
            <p>This may take a few minutes to several hours depending on your payment method.</p>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="status-header">
        <h1><i class="fa fa-exclamation-triangle"></i> Invalid Access</h1>
        <p>Payment information is missing. If you have made a payment, please contact us.</p>
    </div>
<?php endif; ?>

    <div class="navigation-links">
        <a href="index.php" class="btn"><i class="fa fa-home"></i> Return to Homepage</a>
        <a href="req_quotation_form.php" class="btn"><i class="fa fa-plus"></i> New Order</a>
    </div>

</div>

<?php include ('includes/footer.html'); ?>

</body>
</html>
