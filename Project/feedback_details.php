<?php
// feedback_details.php
// Check if admin is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Any other header operations should be placed here

// Only include the header after all possible header() calls
$page_title = 'Feedback Details';
include('includes/header.html');
// Include the CSS file for this page
echo '<link rel="stylesheet" href="includes/feedback_details.css">';

// Connect to the database
require_once('mysqli_connect.php');

// Check for valid feedback ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="container"><div class="error-message">Invalid feedback ID.</div><a href="view_feedback.php" class="back-btn">Back to Feedback List</a></div>';
    include('includes/footer.html');
    exit();
}

$feedback_id = mysqli_real_escape_string($dbc, $_GET['id']);

// Process admin notes update if submitted
$note_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_notes'])) {
    $admin_notes = mysqli_real_escape_string($dbc, $_POST['admin_notes']);
    $admin_flag = isset($_POST['admin_flag']) ? 1 : 0;
    $marked_reviewed = isset($_POST['marked_reviewed']) ? 1 : 0;
    
    // Check if the feedback table has the admin columns, if not add them
    $check_columns_query = "SHOW COLUMNS FROM feedback LIKE 'admin_notes'";
    $check_result = mysqli_query($dbc, $check_columns_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        // Add the needed columns
        $alter_query = "ALTER TABLE feedback 
                        ADD COLUMN admin_notes TEXT NULL,
                        ADD COLUMN admin_flag TINYINT(1) NOT NULL DEFAULT 0,
                        ADD COLUMN marked_reviewed TINYINT(1) NOT NULL DEFAULT 0";
        mysqli_query($dbc, $alter_query);
    }
    
    // Update the feedback with admin notes
    $update_query = "UPDATE feedback 
                    SET admin_notes = '$admin_notes',
                        admin_flag = $admin_flag,
                        marked_reviewed = $marked_reviewed
                    WHERE feedback_id = $feedback_id";
    
    if (mysqli_query($dbc, $update_query)) {
        $note_message = '<div class="success-message">Feedback details updated successfully.</div>';
    } else {
        $note_message = '<div class="error-message">Error updating feedback details: ' . mysqli_error($dbc) . '</div>';
    }
}

// Get the feedback details
$query = "SELECT * FROM feedback WHERE feedback_id = $feedback_id";
$result = mysqli_query($dbc, $query);

// Check if feedback exists
if (mysqli_num_rows($result) == 0) {
    echo '<div class="container"><div class="error-message">Feedback not found.</div><a href="view_feedback.php" class="back-btn">Back to Feedback List</a></div>';
    include('includes/footer.html');
    exit();
}

$feedback = mysqli_fetch_assoc($result);

// Check if the admin columns exist
$has_admin_columns = false;
$admin_notes = '';
$admin_flag = 0;
$marked_reviewed = 0;

$columns_query = "SHOW COLUMNS FROM feedback";
$columns_result = mysqli_query($dbc, $columns_query);
$column_names = array();

while ($column = mysqli_fetch_assoc($columns_result)) {
    $column_names[] = $column['Field'];
}

if (in_array('admin_notes', $column_names)) {
    $has_admin_columns = true;
    $admin_notes = $feedback['admin_notes'];
    $admin_flag = $feedback['admin_flag'];
    $marked_reviewed = $feedback['marked_reviewed'];
}
?>

<div class="container">
    <div class="header-section">
        <h1>Feedback Details</h1>
        <a href="view_feedback.php" class="back-btn">Back to Feedback List</a>
    </div>
    
    <?php echo $note_message; ?>
    
    <div class="feedback-details">
        <div class="details-card">
            <h2>Customer Information</h2>
            <div class="detail-row">
                <div class="detail-label">Name:</div>
                <div class="detail-value"><?php echo htmlspecialchars($feedback['name']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value"><?php echo htmlspecialchars($feedback['email']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone:</div>
                <div class="detail-value"><?php echo htmlspecialchars($feedback['phone'] ?: 'Not provided'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Submitted On:</div>
                <div class="detail-value"><?php echo date('F j, Y, g:i a', strtotime($feedback['submission_date'])); ?></div>
            </div>
        </div>
        
        <div class="details-card">
            <h2>Feedback Information</h2>
            <div class="detail-row">
                <div class="detail-label">Category:</div>
                <div class="detail-value"><?php echo htmlspecialchars($feedback['category']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Subcategory:</div>
                <div class="detail-value"><?php echo htmlspecialchars($feedback['subcategory']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Rating:</div>
                <div class="detail-value stars">
                    <?php for ($i = 1; $i <= 5; $i++) { 
                        echo ($i <= $feedback['rating']) ? '★' : '☆';
                    } ?>
                    <span class="rating-text">(<?php echo $feedback['rating']; ?> out of 5)</span>
                </div>
            </div>
        </div>
        
        <div class="details-card full-width">
            <h2>Feedback</h2>
            <div class="feedback-text">
                <?php echo nl2br(htmlspecialchars($feedback['feedback_text'])); ?>
            </div>
        </div>
        
        <div class="details-card full-width">
            <h2>Admin Notes</h2>
            <form method="post" action="feedback_details.php?id=<?php echo $feedback_id; ?>">
                <div class="form-group">
                    <label for="admin_notes">Notes:</label>
                    <textarea id="admin_notes" name="admin_notes" rows="4"><?php echo htmlspecialchars($admin_notes); ?></textarea>
                </div>
                
                <div class="checkbox-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="admin_flag" name="admin_flag" <?php echo $admin_flag ? 'checked' : ''; ?>>
                        <label for="admin_flag">Flag as Important</label>
                    </div>
                    
                    <div class="checkbox-container">
                        <input type="checkbox" id="marked_reviewed" name="marked_reviewed" <?php echo $marked_reviewed ? 'checked' : ''; ?>>
                        <label for="marked_reviewed">Mark as Reviewed</label>
                    </div>
                </div>
                
                <button type="submit" name="update_notes" class="btn-primary">Update Notes</button>
            </form>
        </div>    </div>
</div>

<?php
include('includes/footer.html');
?>
