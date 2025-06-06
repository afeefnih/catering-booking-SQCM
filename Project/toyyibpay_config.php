<?php
// ToyyibPay Sandbox Configuration
define('TOYYIBPAY_USER_SECRET_KEY', 'p67olsm8-7hiu-zxzh-r7l1-fdwjx75sq0a4'); // Replace with your actual secret key
define('TOYYIBPAY_CATEGORY_CODE', '40dh3xtw'); // Replace with your actual category code
define('TOYYIBPAY_CREATE_BILL_URL', 'https://dev.toyyibpay.com/index.php/api/createBill');
define('TOYYIBPAY_PAYMENT_URL', 'https://dev.toyyibpay.com/'); // Base URL to redirect user for payment (append BillCode)

// These are example callback and redirect URLs.
// You will need to create these files to handle ToyyibPay's responses.
// The redirect URL is where the user is sent back to after payment.
// The callback URL is what ToyyibPay server calls in the background to notify your system of payment status.
define('TOYYIBPAY_REDIRECT_URL', 'http://localhost:8080/Project/toyyibpay_redirect.php'); // Adjust hostname if needed
define('TOYYIBPAY_CALLBACK_URL', 'http://localhost:8080/Project/toyyibpay_callback.php'); // Adjust hostname if needed
?>
