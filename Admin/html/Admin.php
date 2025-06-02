<?php
 include_once '../header.php';
 include_once '../../config.php';

 if(!isset($_SESSION['Token'])) {
    header("Location: ../login.php");
    exit();
 }
 ?>

<!-- Hero Section with animated background -->
<section class="hero-section">
  <div class="hero-text container">
    <h1>EpicEscape</h1>
    <p>Your journey starts here!</p>
  </div>
</section>

<?php
 include_once '../footer.php'; 
 ?>
