<?php
// update_feedback_table.php
// This script ensures the feedback table has all necessary columns
// Run this script once to update your table structure

// Connect to the database
require_once('mysqli_connect.php');

// Create the feedback table if it doesn't exist with all required columns
$create_table_query = "CREATE TABLE IF NOT EXISTS feedback (
    feedback_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    phone VARCHAR(20),
    category VARCHAR(50) NOT NULL,
    subcategory VARCHAR(50) NOT NULL,
    rating INT NOT NULL,
    feedback_text TEXT NOT NULL,
    submission_date DATETIME NOT NULL,
    admin_notes TEXT NULL,
    admin_flag TINYINT(1) NOT NULL DEFAULT 0,
    marked_reviewed TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (feedback_id)
)";

if (mysqli_query($dbc, $create_table_query)) {
    echo "Feedback table created or already exists.<br>";
} else {
    echo "Error creating feedback table: " . mysqli_error($dbc) . "<br>";
}

// Check if the admin columns exist, and add them if they don't
$check_columns_query = "SHOW COLUMNS FROM feedback LIKE 'admin_notes'";
$check_result = mysqli_query($dbc, $check_columns_query);

if (mysqli_num_rows($check_result) == 0) {
    // Add the admin columns
    $alter_query = "ALTER TABLE feedback 
                    ADD COLUMN admin_notes TEXT NULL,
                    ADD COLUMN admin_flag TINYINT(1) NOT NULL DEFAULT 0,
                    ADD COLUMN marked_reviewed TINYINT(1) NOT NULL DEFAULT 0";
    
    if (mysqli_query($dbc, $alter_query)) {
        echo "Admin columns added to feedback table.<br>";
    } else {
        echo "Error adding admin columns: " . mysqli_error($dbc) . "<br>";
    }
} else {
    echo "Admin columns already exist in feedback table.<br>";
}

echo "Table structure update complete.";
?>
