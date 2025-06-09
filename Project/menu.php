
<html>
  <?php
        $page_title = 'Menu';
        include ('includes/header.html');
        require ('../mysqli_connect.php');
  ?> 
<head>
  <link rel="stylesheet" href="includes/menu.css">
</head>
<body>
<h1>Menu</h1>
<div class="row">
  <h2>Company Event</h2>
  <div class="column">
    <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf1();">
    <div class="menuImage">
        <img src="includes/images/company1.jpg" alt="company 1">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf1() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/catering1.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>

    <p>Asian or Western Seminar</p>
  </div>
  <div class="column">
      <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf2();">
    <div class="menuImage">
        <img src="includes/images/company2.jpg" alt="company 1">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>
<script>
    function openPdf2() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/catering2.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
<p>Brand Hi Tea</p>

    
  </div>
  <div class="column">
     <!-- Add this around your image in menu.php -->
  <a href="" onclick="openPdf3();">
    <div class="menuImage">
        <img src="includes/images/company3.jpg" alt="company 1">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
  </a>
<script>
    function openPdf3() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/catering3.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
  
    <p>Breakfast and Tea</p>
</div>
</div>
<!-------------------------------------------WEDDING------------------------------------------------------>

<div class="row2">
  <h2>Wedding</h2>
  <div class="column">
    <!-- Add this around your image in menu.php -->
    <a href="" onclick="openPdf4();">
      <div class="menuImage">
        <img src="includes/images/wed.jpg" alt="wedding 1">
        <div class="hov">
          <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
          <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
      </div>
    </a>

    <script>
      function openPdf4() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/wedding1.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
      }
    </script>

    <p>Western Wedding</p>
  </div>

  <div class="column">
    <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf5();">
    <div class="menuImage">
        <img src="includes/images/wed2.jpg" alt="wedding 2">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf5() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/wedding2.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>

    <p>Malay Wedding</p>
  </div>
  <div class="column">
    <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf6();">
    <div class="menuImage">
        <img src="includes/images/wed3.jpg" alt="wedding 3">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf6() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/wedding3.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
    <p>Chinese Buffet</p>
</div>
</div>

<!--------------------------------------------BIRTHDAY--------------------------------------------------------------->
<div class="row2">
<h2>Birthday Party</h2>
<div class="column">
     <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf7();">
    <div class="menuImage">
        <img src="includes/images/birth.jpg" alt="birthday 1">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf7() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/bf1.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
    <p>Lada Merah </p>
  </div>
  <div class="column">
     <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf8();">
    <div class="menuImage">
        <img src="includes/images/birth2.jpg" alt="birthday 2">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf8() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/bf2.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
    <p>Deli Delights</p>
  </div>
  <div class="column">
     <!-- Add this around your image in menu.php -->
<a href="" onclick="openPdf9();">
    <div class="menuImage">
        <img src="includes/images/bbq.jpg" alt="birthday 3">
        <div class="hov">
            <h1>Click to See Menu</h1>
        </div>
        <div class="text-box">
            <a href="req_quotation_form.php" class="but but-white">Free Quotation</a>
        </div>
    </div>
</a>

<script>
    function openPdf9() {
        // Replace 'your_pdf_file.pdf' with the actual path to your PDF file
        var pdfPath = 'includes/pdf/bf3.pdf';

        // Open the PDF file in a new window or tab
        window.open(pdfPath, '_blank');
    }
</script>
    <p>Joe Roast Lamb</p>
</div>
</div>

<?php
$export_query = "SELECT name, category, rating, feedback_text, submission_date 
                 FROM feedback 
                 WHERE 1
                 ORDER BY submission_date DESC";
$export_result = mysqli_query($dbc, $export_query);
?>

<style>
    .feedback-container {
        max-width: 1050px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .feedback-box {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #ddd;
    }

    .feedback-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .feedback-box h3 {
        margin: 0 0 10px;
        font-size: 20px;
        color: #333;
    }

    .meta {
        font-size: 14px;
        color: #777;
        margin-bottom: 10px;
    }

    .stars {
        color: #f5a623;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .feedback-text {
        font-size: 15px;
        color: #444;
        line-height: 1.5;
    }

    .feedback-box h3 {
    margin: 0 0 10px;
    font-size: 16px;
    color: #333;
}
</style>


<h1>Feedback from Our Client</h1>
<div class="feedback-container">
<?php if (mysqli_num_rows($export_result) === 0): ?>
    <p>No feedback available.</p>
<?php else: ?>
    <?php while ($row = mysqli_fetch_assoc($export_result)): ?>
        <div class="feedback-box">
            <h3 ><?= htmlspecialchars($row['name']) ?></h3>
            <div class="meta"><?= htmlspecialchars($row['category']) ?> | <?= date("F j, Y", strtotime($row['submission_date'])) ?></div>
            <div class="stars"><?= str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']) ?></div>
            <div class="feedback-text"><?= nl2br(htmlspecialchars($row['feedback_text'])) ?></div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
</div>



</body>
<?php include ('includes/footer.html'); ?>
</html>
