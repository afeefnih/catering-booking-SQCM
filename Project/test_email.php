<?php
// Test script to verify email functionality
require_once('script.php');

// Test email details
$test_email = "izzdanial23@gmail.com"; // Replace with your test email
$test_subject = "ToyyibPay Integration Test - Email System Working";
$test_message = "
<html>
<head><title>Email Test</title></head>
<body>
    <h2>Email System Test</h2>
    <p>Dear User,</p>
    <p>This is a test email to verify that the email notification system is working properly for the ToyyibPay payment integration.</p>
    <h3>Test Details:</h3>
    <ul>
        <li><strong>Test Type:</strong> Email System Verification</li>
        <li><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</li>
        <li><strong>System:</strong> Catering Booking Payment Notifications</li>
        <li><strong>Status:</strong> Email sending functionality is working correctly</li>
    </ul>
    <p>If you receive this email, it means the email notification system is properly configured and ready for production use.</p>
    <br>
    <p>Best regards,<br>Catering Booking System</p>
</body>
</html>";

echo "<h1>Testing Email System</h1>";
echo "<p>Sending test email to: $test_email</p>";

$result = sendMail($test_email, $test_subject, $test_message);

if ($result === 'success') {
    echo "<p style='color: green;'><strong>✓ SUCCESS:</strong> Test email sent successfully!</p>";
    echo "<p>Check your email inbox to confirm receipt.</p>";
} else {
    echo "<p style='color: red;'><strong>✗ ERROR:</strong> Failed to send test email.</p>";
    echo "<p>Error details: $result</p>";
}

echo "<hr>";
echo "<h2>Email Configuration Status:</h2>";
echo "<ul>";
echo "<li><strong>SMTP Host:</strong> " . MAILHOST . "</li>";
echo "<li><strong>Username:</strong> " . USERNAME . "</li>";
echo "<li><strong>Send From:</strong> " . SEND_FROM . "</li>";
echo "<li><strong>Send From Name:</strong> " . SEND_FROM_NAME . "</li>";
echo "</ul>";
echo "<p><em>Note: This test file should be deleted after testing is complete.</em></p>";
?>
