
<?php 
include "../connect-db.php";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/daterangepicker.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

  <title>Tour-About Us Page</title>
</head>

<body>

<?php
include("header.php");
?>


  <div class="hero hero-inner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mx-auto text-center">
          <div class="intro-wrap">
            <h1 class="mb-0">About Us</h1>
            <p class="text-white">At EpicEscape, we believe that travel is more than just visiting new places—it's about creating lasting memories. Our team of passionate travel experts is committed to curating unforgettable experiences, whether you're seeking adventure, relaxation, or cultural immersion. </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  
  <div class="untree_co-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <div class="owl-single dots-absolute owl-carousel">
            <img src="images/slider-1.jpg" alt="Free HTML Template by Untree.co" class="img-fluid rounded-20">
            <img src="images/slider-2.jpg" alt="Free HTML Template by Untree.co" class="img-fluid rounded-20">
            <img src="images/slider-3.jpg" alt="Free HTML Template by Untree.co" class="img-fluid rounded-20">
            <img src="images/slider-4.jpg" alt="Free HTML Template by Untree.co" class="img-fluid rounded-20">
            <img src="images/slider-5.jpg" alt="Free HTML Template by Untree.co" class="img-fluid rounded-20">
          </div>
        </div>
        <div class="col-lg-5 pl-lg-5 ml-auto">
          <h2 class="section-title mb-4">About Tours</h2>
          <p>Our tours are crafted to showcase the most breathtaking destinations while ensuring comfort, safety, and cultural authenticity. From scenic landscapes to vibrant cityscapes, every tour is designed with attention to detail and personalized service.</p>
          <ul class="list-unstyled two-col clearfix">
            <li>Outdoor Adventures</li>
            <li>Hotels</li>
            <li>Travel Insurance</li>
            <li>Package Tours</li>
            <li>Insurance</li>
            <li>Guide Tours</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php
	$stmt = $conn->prepare("
		SELECT packageID, Review 
		FROM reviews 
		WHERE Confirmed = True
	");
	$stmt->execute();
	$result = $stmt->get_result();
?>

  

  <div class="untree_co-section testimonial-section mt-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7 text-center">
				<h2 class="section-title text-center mb-5">Testimonials</h2>
				<div class="owl-single owl-carousel no-nav">
					<?php while ($row = $result->fetch_assoc()): 
						$packageID = $row['packageID'];
						$stm1 = $conn->prepare("SELECT Name, image_path FROM packages WHERE ID = ?");
						$stm1->bind_param("i", $packageID);
						$stm1->execute();
						$result1 = $stm1->get_result();
						$row1 = $result1->fetch_assoc();
						?>
						<div class="testimonial mx-auto">
							<figure class="img-wrap">
								<?php
								$imagePath=$row1['image_path'];
								
							  echo '<a class="media-thumb" href="images/' . $imagePath . '" data-fancybox="gallery"></a>'
							?>
							  </figure>
							<h3 class="name"><?= htmlspecialchars($row1['Name'] ?? 'Unknown Package') ?></h3>
							<blockquote>
								<p>&ldquo;<?= htmlspecialchars($row['Review']) ?>&rdquo;</p>
							</blockquote>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>

 
  
  <?php
	include("footer.php");
	?>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/daterangepicker.js"></script>

  <script src="js/typed.js"></script>
  
  <script src="js/custom.js"></script>

</body>

</html>
