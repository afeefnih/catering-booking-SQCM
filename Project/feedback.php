<?php
// Start the session so we can access session variables if needed
session_start();

// Set the page title and include the HTML header:
$page_title = 'Customer Feedback';
include ('includes/header.html');
// Include the CSS file for this page
echo '<link rel="stylesheet" href="includes/feedback.css">';
require_once ('mysqli_connect.php');

// Initialize variables for form data and error messages
$msg = '';
$name = $email = $phone = $feedback_text = $rating = '';
$category = $subcategory = '';

// Process the form if it's submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Validate and sanitize input
    $errors = array();
    
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = 'You forgot to enter your name.';
    } else {
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    }
    
    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email.';
    } else {
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email address is not valid.';
        }
    }
    
    // Validate phone (optional)
    if (!empty($_POST['phone'])) {
        $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
    }
    
    // Validate category
    if (empty($_POST['category'])) {
        $errors[] = 'Please select an event category.';
    } else {
        $category = mysqli_real_escape_string($dbc, trim($_POST['category']));
    }
    
    // Validate subcategory
    if (empty($_POST['subcategory'])) {
        $errors[] = 'Please select an event subcategory.';
    } else {
        $subcategory = mysqli_real_escape_string($dbc, trim($_POST['subcategory']));
    }
    
    // Validate rating
    if (empty($_POST['rating'])) {
        $errors[] = 'Please select a rating.';
    } else {
        $rating = mysqli_real_escape_string($dbc, trim($_POST['rating']));
    }
    
    // Validate feedback text
    if (empty($_POST['feedback_text'])) {
        $errors[] = 'Please enter your feedback.';
    } else {
        $feedback_text = mysqli_real_escape_string($dbc, trim($_POST['feedback_text']));
    }
    
    // If there are no errors, submit the feedback
    if (empty($errors)) {
          // Create the feedback table if it doesn't exist
        $q = "CREATE TABLE IF NOT EXISTS feedback (
            feedback_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(60) NOT NULL,
            phone VARCHAR(20),
            category VARCHAR(50) NOT NULL,
            subcategory VARCHAR(50) NOT NULL,
            rating INT NOT NULL,
            feedback_text TEXT NOT NULL,
            submission_date DATETIME NOT NULL,
            PRIMARY KEY (feedback_id)
        )";
        mysqli_query($dbc, $q);
        
        // Insert the feedback into the database
        $q = "INSERT INTO feedback (name, email, phone, category, subcategory, rating, feedback_text, submission_date) 
              VALUES ('$name', '$email', '$phone', '$category', '$subcategory', '$rating', '$feedback_text', NOW())";
        $r = mysqli_query($dbc, $q);
          if ($r) {
            $msg = '<div class="success-message">Thank you for your feedback! We appreciate your input.</div>';
            // Clear the form data
            $name = $email = $phone = $feedback_text = $rating = '';
            $category = $subcategory = '';
        } else {
            $msg = '<div class="error-message">We apologize, but there was an error submitting your feedback. Please try again later.</div>';
        }
        
    } else {
        // Display the errors
        $msg = '<div class="error-message">The following error(s) occurred:<br>';
        foreach ($errors as $error) {
            $msg .= " - $error<br>";
        }
        $msg .= 'Please try again.</div>';    }
}
?>

<script>
    function updateSubcategories() {
        var category = document.getElementById('category').value;
        var subcategorySelect = document.getElementById('subcategory');
        
        // Clear all options
        subcategorySelect.innerHTML = '';
        
        // Add default option
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Select a subcategory';
        subcategorySelect.appendChild(defaultOption);
        
        // Add subcategories based on the selected category
        if (category === 'Company Event') {
            addSubcategoryOption(subcategorySelect, 'Asian or Western Seminar', 'Asian or Western Seminar');
            addSubcategoryOption(subcategorySelect, 'Brand Hi Tea', 'Brand Hi Tea');
            addSubcategoryOption(subcategorySelect, 'Breakfast and Tea', 'Breakfast and Tea');
        } else if (category === 'Wedding') {
            addSubcategoryOption(subcategorySelect, 'Western Wedding', 'Western Wedding');
            addSubcategoryOption(subcategorySelect, 'Malay Wedding', 'Malay Wedding');
            addSubcategoryOption(subcategorySelect, 'Chinese Buffet', 'Chinese Buffet');
        } else if (category === 'Birthday Party') {
            addSubcategoryOption(subcategorySelect, 'Lada Merah', 'Lada Merah');
            addSubcategoryOption(subcategorySelect, 'Deli Delights', 'Deli Delights');
            addSubcategoryOption(subcategorySelect, 'Joe Roast Lamb', 'Joe Roast Lamb');
        }
    }
    
    function addSubcategoryOption(selectElement, value, text) {
        var option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        selectElement.appendChild(option);
    }
    
    // Initialize subcategories if category is already selected (e.g., after form submission with errors)
    document.addEventListener('DOMContentLoaded', function() {
        var category = document.getElementById('category').value;
        if (category) {
            updateSubcategories();
            
            // Set the previously selected subcategory
            var subcategorySelect = document.getElementById('subcategory');
            var subcategoryValue = '<?php echo $subcategory; ?>';
            
            if (subcategoryValue) {
                for (var i = 0; i < subcategorySelect.options.length; i++) {
                    if (subcategorySelect.options[i].value === subcategoryValue) {
                        subcategorySelect.options[i].selected = true;
                        break;
                    }
                }
            }
        }
    });
</script>

<div class="feedback-container">
    <div class="feedback-header">
        <h1>Customer Feedback</h1>
        <p>We value your opinion! Please take a moment to share your thoughts about our catering services.</p>
    </div>
    
    <?php echo $msg; ?>
    
    <form action="feedback.php" method="post" class="feedback-form">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
          <div class="form-group">
            <label for="phone">Phone Number (Optional)</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        
        <div class="form-group">
            <label for="category">Event Category *</label>
            <select class="form-control" id="category" name="category" required onchange="updateSubcategories()">
                <option value="" disabled selected>Select a category</option>
                <option value="Company Event" <?php if ($category == 'Company Event') echo 'selected'; ?>>Company Event</option>
                <option value="Wedding" <?php if ($category == 'Wedding') echo 'selected'; ?>>Wedding</option>
                <option value="Birthday Party" <?php if ($category == 'Birthday Party') echo 'selected'; ?>>Birthday Party</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="subcategory">Event Subcategory *</label>
            <select class="form-control" id="subcategory" name="subcategory" required>
                <option value="" disabled selected>Select a category first</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>How would you rate our service? *</label>
            <div class="rating-container">
                <input type="radio" id="star5" name="rating" value="5" <?php if ($rating == '5') echo 'checked'; ?>>
                <label for="star5" title="Excellent"></label>
                
                <input type="radio" id="star4" name="rating" value="4" <?php if ($rating == '4') echo 'checked'; ?>>
                <label for="star4" title="Very Good"></label>
                
                <input type="radio" id="star3" name="rating" value="3" <?php if ($rating == '3') echo 'checked'; ?>>
                <label for="star3" title="Good"></label>
                
                <input type="radio" id="star2" name="rating" value="2" <?php if ($rating == '2') echo 'checked'; ?>>
                <label for="star2" title="Fair"></label>
                
                <input type="radio" id="star1" name="rating" value="1" <?php if ($rating == '1') echo 'checked'; ?>>
                <label for="star1" title="Poor"></label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="feedback_text">Your Feedback *</label>
            <textarea class="form-control" id="feedback_text" name="feedback_text" rows="5" required><?php echo htmlspecialchars($feedback_text); ?></textarea>
        </div>
        
        <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>
</div>

<?php
include ('includes/footer.html');
?>
