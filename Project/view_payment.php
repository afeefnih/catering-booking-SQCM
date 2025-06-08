<?php 
// This script retrieves all the records from the payment table.
// It allows admin to update payment status and generate bill codes.
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['user_id'])) {
	// Need the functions:
	require ('includes/login_functions.inc.php');
	redirect_user();	
}

$page_title = 'Payment Management';
include ('includes/header.html');

// Include the function to generate bill code
function generateBillCode($payment_id) {
    // Generate a unique bill code with prefix BILL, payment ID, and random numbers
    $randomNum = mt_rand(1000, 9999);
    return 'BILL' . $payment_id . $randomNum;
}

// Process status update if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require ('../mysqli_connect.php');
    
    // Check if payment_id and status are set
    if (isset($_POST['payment_id']) && isset($_POST['status'])) {
        $payment_id = mysqli_real_escape_string($dbc, $_POST['payment_id']);
        $status = mysqli_real_escape_string($dbc, $_POST['status']);
        
        // Check current payment status
        $check_q = "SELECT payment_status, transaction_id FROM payment WHERE payment_id = $payment_id";
        $check_r = @mysqli_query($dbc, $check_q);
        $payment_data = mysqli_fetch_assoc($check_r);
        
        $transaction_id = null;
        
        // If status is changing to "Success", generate bill code if none exists
        if ($status == 'Success') {
            if ($payment_data['payment_status'] != 'Success' || empty($payment_data['transaction_id'])) {
                // Only generate new bill code if none exists or status was not Success before
                $transaction_id = generateBillCode($payment_id);
            } else {
                // Keep existing transaction_id
                $transaction_id = $payment_data['transaction_id'];
            }
        }
        
        // Update payment status
        $q = "UPDATE payment SET payment_status = '$status'";
        
        // Add transaction_id if status is Success and we have a transaction_id
        if ($status == 'Success' && $transaction_id) {
            $q .= ", transaction_id = '$transaction_id'";
        }
        
        $q .= " WHERE payment_id = $payment_id";
        
        $r = @mysqli_query($dbc, $q);
        
        if ($r) {
            echo '<p class="success">Payment status updated successfully.</p>';
        } else {
            echo '<p class="error">Error updating payment status: ' . mysqli_error($dbc) . '</p>';
        }
    }
}
?>
<link rel="stylesheet" href="includes/view_customer.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="wrapper0">
    <div class="wrapper">
        <?php
        echo '<h1 id="logo">Payment Management</h1>';

        require ('../mysqli_connect.php');
        
                 // Define the query:
         $q = "SELECT p.payment_id, p.order_id, p.amount, p.payment_status, p.transaction_id, 
               p.created_at, p.updated_at, o.contact_person, o.email, o.contact_no, o.occasion, o.event_date
               FROM payment AS p 
               LEFT JOIN orders AS o ON p.order_id = o.order_id 
               ORDER BY p.created_at DESC";
        $r = @mysqli_query($dbc, $q);

        // Count the number of returned rows:
        $num = mysqli_num_rows($r);

        if ($num > 0) { // If it ran OK, display the records.

            // Print how many payments there are:
            echo "<p>There are currently $num payment(s).</p>\n";
            ?>
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>" class="form-control" placeholder="Search by customer name or order ID">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            <?php 
            if(isset($_GET['search'])) {
                $filtervalues = mysqli_real_escape_string($dbc, $_GET['search']);
                                 $q = "SELECT p.payment_id, p.order_id, p.amount, p.payment_status, p.transaction_id, 
                      p.created_at, p.updated_at, o.contact_person, o.email, o.contact_no, o.occasion, o.event_date
                      FROM payment AS p 
                      LEFT JOIN orders AS o ON p.order_id = o.order_id 
                      WHERE o.contact_person LIKE '%$filtervalues%' OR p.order_id LIKE '%$filtervalues%' 
                      ORDER BY p.created_at DESC";
                $r = @mysqli_query($dbc, $q);
            }

            if(mysqli_num_rows($r) > 0) {
                echo '<table class="fl-table" align="center" cellspacing="10" cellpadding="10" width="100%">
                <tr>
                    <th align="left"><b>Update Status</b></th>
                    <th align="left"><b>Payment ID</b></th>
                    <th align="left"><b>Order ID</b></th>
                                         <th align="left"><b>Customer</b></th>
                     <th align="left"><b>Contact</b></th>
                     <th align="left"><b>Event</b></th>
                     <th align="left"><b>Amount</b></th>
                     <th align="left"><b>Status</b></th>
                     <th align="left"><b>Bill Code</b></th>
                     <th align="left"><b>Created</b></th>
                     <th align="left"><b>Last Updated</b></th>
                </tr>';
                
                // Fetch and print all the records:
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo '<tr>
                        <td align="left">
                            <form method="post" action="">
                                <input type="hidden" name="payment_id" value="' . $row['payment_id'] . '">
                                                                 <select name="status">
                                    <option value="Pending" ' . ($row['payment_status'] == 'Pending' ? 'selected' : '') . '>Pending</option>
                                    <option value="Success" ' . ($row['payment_status'] == 'Success' ? 'selected' : '') . '>Success</option>
                                    <option value="Reject" ' . ($row['payment_status'] == 'Reject' ? 'selected' : '') . '>Reject</option>
                                </select>
                                <button type="submit" class="button primary edit">Update</button>
                            </form>
                        </td>
                        <td align="left">' . $row['payment_id'] . '</td>
                                                 <td align="left">' . $row['order_id'] . '</td>
                         <td align="left">' . $row['contact_person'] . '</td>
                         <td align="left">' . $row['contact_no'] . '<br>' . $row['email'] . '</td>
                         <td align="left">' . $row['occasion'] . '<br>' . date('d M Y', strtotime($row['event_date'])) . '</td>
                         <td align="left">RM ' . $row['amount'] . '</td>
                        <td align="left"><span class="status-' . strtolower($row['payment_status']) . '">' . $row['payment_status'] . '</span></td>
                        <td align="left">' . ($row['transaction_id'] ? '<span class="bill-code">' . $row['transaction_id'] . '</span>' : 'N/A') . '</td>
                        <td align="left">' . $row['created_at'] . '</td>
                        <td align="left">' . $row['updated_at'] . '</td>
                    </tr>';
                }

                echo '</table>';
                mysqli_free_result($r); // Free memory associated with $r
            } else {
                echo '<tr><td colspan="10">No Record Found</td></tr>';
            }
        } else { // If no records were returned.
            echo '<p class="error">There are currently no payment records.</p>';
        }
        ?>
    </div>
</div>

<style>
    /* Additional styles for payment status */
    .status-pending {
        color: #FF8C00;
        font-weight: bold;
    }
    .status-success {
        color: #008000;
        font-weight: bold;
    }
    .status-reject {
        color: #FF0000;
        font-weight: bold;
    }
    
    /* Success message style */
    .success {
        color: #008000;
        font-weight: bold;
        background-color: #DFFFDF;
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
    }
    
    /* Error message style */
    .error {
        color: #FF0000;
        font-weight: bold;
        background-color: #FFECEC;
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
    }
    
    /* Form and button styles */
    select {
        padding: 5px;
        border-radius: 3px;
        border: 1px solid #ccc;
        margin-right: 5px;
    }
    
         .button.primary.edit {
        padding: 5px 10px;
        font-size: 12px;
        line-height: 20px;
    }
    
    .button.primary.edit:hover {
        background-color: #0e8b73;
    }
    
    select {
        background-color: #ffffff;
    }
    
    /* Add style for bill code */
    .bill-code {
        font-family: monospace;
        font-weight: bold;
        padding: 3px 6px;
        background-color: #f0f0f0;
        border-radius: 3px;
        border: 1px solid #ddd;
    }
</style>

<?php
mysqli_close($dbc); // Close database connection
include ('includes/footer.html');
?>
</body>
</html> 