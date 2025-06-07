<?php
// view_feedback.php
// Check if admin is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle export to CSV if requested
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    // Connect to the database for CSV export
    require_once('mysqli_connect.php');
    
    // Build where clause for filters
    $where = "1"; // Default where clause
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = mysqli_real_escape_string($dbc, $_GET['category']);
        $where .= " AND category='$category'";
    }

    if (isset($_GET['subcategory']) && !empty($_GET['subcategory'])) {
        $subcategory = mysqli_real_escape_string($dbc, $_GET['subcategory']);
        $where .= " AND subcategory='$subcategory'";
    }

    if (isset($_GET['rating']) && !empty($_GET['rating'])) {
        $rating = mysqli_real_escape_string($dbc, $_GET['rating']);
        $where .= " AND rating='$rating'";
    }

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = mysqli_real_escape_string($dbc, $_GET['search']);
        $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
    }

    if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
        $date_from = mysqli_real_escape_string($dbc, $_GET['date_from']);
        $where .= " AND DATE(submission_date) >= '$date_from'";
    }

    if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
        $date_to = mysqli_real_escape_string($dbc, $_GET['date_to']);
        $where .= " AND DATE(submission_date) <= '$date_to'";
    }
    
    // Create a filename with current date
    $filename = 'feedback_export_' . date('Y-m-d') . '.csv';
    
    // Set headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Add BOM for UTF-8 encoding in Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Add CSV header row
    fputcsv($output, ['Feedback ID', 'Date', 'Name', 'Email', 'Phone', 'Category', 'Subcategory', 'Rating', 'Feedback']);
    
    // Get all data for export (without pagination but keeping filters)
    $export_query = "SELECT * FROM feedback WHERE $where ORDER BY submission_date DESC";
    $export_result = mysqli_query($dbc, $export_query);
    
    // Add data rows
    while ($row = mysqli_fetch_assoc($export_result)) {
        fputcsv($output, [
            $row['feedback_id'],
            $row['submission_date'],
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['category'],
            $row['subcategory'],
            $row['rating'],
            $row['feedback_text']
        ]);
    }
    
    // Close the output stream
    fclose($output);
    exit;
}

$page_title = 'Feedback Management';
include('includes/header.html');
// Include the CSS file for this page
echo '<link rel="stylesheet" href="includes/view_feedback.css">';

// Connect to the database
require_once('mysqli_connect.php');

// Handle filtering
$where = "1"; // Default where clause
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = mysqli_real_escape_string($dbc, $_GET['category']);
    $where .= " AND category='$category'";
}

if (isset($_GET['subcategory']) && !empty($_GET['subcategory'])) {
    $subcategory = mysqli_real_escape_string($dbc, $_GET['subcategory']);
    $where .= " AND subcategory='$subcategory'";
}

if (isset($_GET['rating']) && !empty($_GET['rating'])) {
    $rating = mysqli_real_escape_string($dbc, $_GET['rating']);
    $where .= " AND rating='$rating'";
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($dbc, $_GET['search']);
    $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
    $date_from = mysqli_real_escape_string($dbc, $_GET['date_from']);
    $where .= " AND DATE(submission_date) >= '$date_from'";
}

if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    $date_to = mysqli_real_escape_string($dbc, $_GET['date_to']);
    $where .= " AND DATE(submission_date) <= '$date_to'";
}

// Pagination settings
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

// Count total records for pagination
$count_query = "SELECT COUNT(*) as total FROM feedback WHERE $where";
$count_result = mysqli_query($dbc, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $per_page);

// Get feedback data with pagination
$query = "SELECT * FROM feedback WHERE $where ORDER BY submission_date DESC LIMIT $start, $per_page";
$result = mysqli_query($dbc, $query);

// Get categories for filter
$cat_query = "SELECT DISTINCT category FROM feedback ORDER BY category";
$cat_result = mysqli_query($dbc, $cat_query);

// Get subcategories for the selected category
$subcat_query = "SELECT DISTINCT subcategory FROM feedback";
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $subcat_query .= " WHERE category = '" . mysqli_real_escape_string($dbc, $_GET['category']) . "'";
}
$subcat_query .= " ORDER BY subcategory";
$subcat_result = mysqli_query($dbc, $subcat_query);

// Get overall statistics
$stats_query = "SELECT 
                  COUNT(*) as total_feedback,
                  AVG(rating) as avg_rating,
                  COUNT(CASE WHEN rating >= 4 THEN 1 END) as positive_count,
                  COUNT(CASE WHEN rating <= 2 THEN 1 END) as negative_count
                FROM feedback";
$stats_result = mysqli_query($dbc, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Get ratings by category
$cat_stats_query = "SELECT 
                      category, 
                      COUNT(*) as count, 
                      AVG(rating) as avg_rating 
                    FROM feedback 
                    GROUP BY category 
                    ORDER BY avg_rating DESC";
$cat_stats_result = mysqli_query($dbc, $cat_stats_query);

// Handle export to CSV if requested
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    // Create a filename with current date
    $filename = 'feedback_export_' . date('Y-m-d') . '.csv';
    
    // Set headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Add BOM for UTF-8 encoding in Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Add CSV header row
    fputcsv($output, ['Feedback ID', 'Date', 'Name', 'Email', 'Phone', 'Category', 'Subcategory', 'Rating', 'Feedback']);
    
    // Get all data for export (without pagination but keeping filters)
    $export_query = "SELECT * FROM feedback WHERE $where ORDER BY submission_date DESC";
    $export_result = mysqli_query($dbc, $export_query);
    
    // Add data rows
    while ($row = mysqli_fetch_assoc($export_result)) {
        fputcsv($output, [
            $row['feedback_id'],
            $row['submission_date'],
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['category'],
            $row['subcategory'],
            $row['rating'],
            $row['feedback_text']
        ]);
    }
    
    // Close the output stream
    fclose($output);
    exit;
}
?>

<!-- Dashboard and filters -->
<div class="container">
    <h1>Feedback Management</h1>
    
    <!-- Statistics Dashboard -->
    <div class="dashboard">
        <div class="stat-card">
            <h3>Total Feedback</h3>
            <p class="stat-number"><?php echo $stats['total_feedback']; ?></p>
        </div>
        <div class="stat-card">
            <h3>Average Rating</h3>
            <p class="stat-number"><?php echo number_format($stats['avg_rating'], 1); ?> / 5</p>
        </div>
        <div class="stat-card">
            <h3>Positive Feedback</h3>
            <p class="stat-number"><?php echo $stats['positive_count']; ?></p>
            <p class="stat-subtitle">(4-5 Stars)</p>
        </div>
        <div class="stat-card">
            <h3>Negative Feedback</h3>
            <p class="stat-number"><?php echo $stats['negative_count']; ?></p>
            <p class="stat-subtitle">(1-2 Stars)</p>
        </div>
    </div>
    
    <!-- Category Performance Chart -->
    <div class="chart-container">
        <h2>Category Performance</h2>
        <table class="chart-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Count</th>
                    <th>Avg. Rating</th>
                    <th>Performance</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cat_stat = mysqli_fetch_assoc($cat_stats_result)) { 
                    $rating_percentage = ($cat_stat['avg_rating'] / 5) * 100;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($cat_stat['category']); ?></td>
                    <td><?php echo $cat_stat['count']; ?></td>
                    <td><?php echo number_format($cat_stat['avg_rating'], 1); ?></td>
                    <td>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?php echo $rating_percentage; ?>%"></div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <!-- Filter Form -->
    <div class="filter-container">
        <h2>Filter Feedback</h2>
        <form method="get" action="view_feedback.php" class="filter-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php mysqli_data_seek($cat_result, 0); // Reset the pointer
                        while ($cat = mysqli_fetch_assoc($cat_result)) { ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $cat['category']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="subcategory">Subcategory:</label>
                    <select name="subcategory" id="subcategory">
                        <option value="">All Subcategories</option>
                        <?php while ($subcat = mysqli_fetch_assoc($subcat_result)) { ?>
                            <option value="<?php echo htmlspecialchars($subcat['subcategory']); ?>" <?php if (isset($_GET['subcategory']) && $_GET['subcategory'] == $subcat['subcategory']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($subcat['subcategory']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating">
                        <option value="">All Ratings</option>
                        <option value="5" <?php if (isset($_GET['rating']) && $_GET['rating'] == '5') echo 'selected'; ?>>5 Stars</option>
                        <option value="4" <?php if (isset($_GET['rating']) && $_GET['rating'] == '4') echo 'selected'; ?>>4 Stars</option>
                        <option value="3" <?php if (isset($_GET['rating']) && $_GET['rating'] == '3') echo 'selected'; ?>>3 Stars</option>
                        <option value="2" <?php if (isset($_GET['rating']) && $_GET['rating'] == '2') echo 'selected'; ?>>2 Stars</option>
                        <option value="1" <?php if (isset($_GET['rating']) && $_GET['rating'] == '1') echo 'selected'; ?>>1 Star</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="date_from">From Date:</label>
                    <input type="date" name="date_from" id="date_from" value="<?php echo isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="date_to">To Date:</label>
                    <input type="date" name="date_to" id="date_to" value="<?php echo isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="search">Search:</label>
                    <input type="text" name="search" id="search" placeholder="Search by name or email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-primary">Apply Filters</button>
                <a href="view_feedback.php" class="btn-secondary">Reset Filters</a>
                <button type="submit" name="export" value="csv" class="btn-export">Export to CSV</button>
            </div>
        </form>
    </div>
    
    <!-- Feedback Table -->
    <div class="table-container">
        <h2>Feedback Results</h2>
        <?php if ($total_records > 0) { ?>
            <p class="results-count">Showing <?php echo ($start + 1); ?>-<?php echo min($start + $per_page, $total_records); ?> of <?php echo $total_records; ?> results</p>
        <?php } ?>
        
        <table class="feedback-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) { 
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['feedback_id']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['submission_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['subcategory']); ?></td>
                        <td>
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++) { 
                                    echo ($i <= $row['rating']) ? '★' : '☆';
                                } ?>
                            </div>
                        </td>
                        <td>
                            <div class="feedback-text"><?php echo htmlspecialchars(substr($row['feedback_text'], 0, 100)) . (strlen($row['feedback_text']) > 100 ? '...' : ''); ?></div>
                        </td>
                        <td>
                            <a href="feedback_details.php?id=<?php echo $row['feedback_id']; ?>" class="btn-view">View</a>
                        </td>
                    </tr>
                <?php } 
                } else { ?>
                    <tr>
                        <td colspan="8" class="no-data">No feedback found matching your criteria.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1) { ?>
        <div class="pagination">
            <?php if ($page > 1) { ?>
                <a href="?page=<?php echo ($page - 1); ?><?php echo isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : ''; ?><?php echo isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : ''; ?><?php echo isset($_GET['rating']) ? '&rating=' . urlencode($_GET['rating']) : ''; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['date_from']) ? '&date_from=' . urlencode($_GET['date_from']) : ''; ?><?php echo isset($_GET['date_to']) ? '&date_to=' . urlencode($_GET['date_to']) : ''; ?>" class="page-link">&laquo; Previous</a>
            <?php } ?>
            
            <?php
            // Calculate range of page numbers to display
            $range = 2; // Display 2 pages before and after current page
            $start_page = max(1, $page - $range);
            $end_page = min($total_pages, $page + $range);
            
            // Always show first page
            if ($start_page > 1) {
                echo '<a href="?page=1' . (isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '') . (isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : '') . (isset($_GET['rating']) ? '&rating=' . urlencode($_GET['rating']) : '') . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . (isset($_GET['date_from']) ? '&date_from=' . urlencode($_GET['date_from']) : '') . (isset($_GET['date_to']) ? '&date_to=' . urlencode($_GET['date_to']) : '') . '" class="page-link">1</a>';
                if ($start_page > 2) {
                    echo '<span class="page-dots">...</span>';
                }
            }
            
            // Display page numbers
            for ($i = $start_page; $i <= $end_page; $i++) {
                echo '<a href="?page=' . $i . (isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '') . (isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : '') . (isset($_GET['rating']) ? '&rating=' . urlencode($_GET['rating']) : '') . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . (isset($_GET['date_from']) ? '&date_from=' . urlencode($_GET['date_from']) : '') . (isset($_GET['date_to']) ? '&date_to=' . urlencode($_GET['date_to']) : '') . '" class="page-link ' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
            }
            
            // Always show last page
            if ($end_page < $total_pages) {
                if ($end_page < $total_pages - 1) {
                    echo '<span class="page-dots">...</span>';
                }
                echo '<a href="?page=' . $total_pages . (isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : '') . (isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : '') . (isset($_GET['rating']) ? '&rating=' . urlencode($_GET['rating']) : '') . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . (isset($_GET['date_from']) ? '&date_from=' . urlencode($_GET['date_from']) : '') . (isset($_GET['date_to']) ? '&date_to=' . urlencode($_GET['date_to']) : '') . '" class="page-link">' . $total_pages . '</a>';
            }
            ?>
            
            <?php if ($page < $total_pages) { ?>
                <a href="?page=<?php echo ($page + 1); ?><?php echo isset($_GET['category']) ? '&category=' . urlencode($_GET['category']) : ''; ?><?php echo isset($_GET['subcategory']) ? '&subcategory=' . urlencode($_GET['subcategory']) : ''; ?><?php echo isset($_GET['rating']) ? '&rating=' . urlencode($_GET['rating']) : ''; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['date_from']) ? '&date_from=' . urlencode($_GET['date_from']) : ''; ?><?php echo isset($_GET['date_to']) ? '&date_to=' . urlencode($_GET['date_to']) : ''; ?>" class="page-link">Next &raquo;</a>
            <?php } ?>
        </div>
        <?php } ?>    </div>
</div>

<script>
    // JavaScript for dynamic subcategory loading
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const subcategorySelect = document.getElementById('subcategory');
        
        // Pre-select subcategory if it's in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const selectedSubcategory = urlParams.get('subcategory');
        
        if (selectedSubcategory) {
            Array.from(subcategorySelect.options).forEach(option => {
                if (option.value === selectedSubcategory) {
                    option.selected = true;
                }
            });
        }
    });
</script>

<?php
include('includes/footer.html');
?>
