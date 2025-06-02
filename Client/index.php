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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<title>Tour-A travel Agency</title>
</head>

<body>

<?php
 include ("header.php");
 ?>

<div class="hero">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<div class="intro-wrap">
						<h1 class="mb-5"><span class="d-block">                <?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : -1; ?>

Let's Enjoy Your</span> Trip In <span class="typed-words"></span></h1>
						<div class="row">
							<div class="col-12">
								<form id="searchForm" class="form" action="search.php" method="POST">
								<div class="row mb-3">
									<div class="col-12">
									<select name="type" id="type" class="form-control bg-dark text-white w-100">
										<option value="all">All Types</option>
										<option value="Airplane Trip with Guide">Airplane Trips with a Guide</option>
										<option value="All-Inclusive">All-Inclusive Vacations</option>
										<option value="Individual Package">Individual Packages</option>
									</select>
									</div>
								</div>

								<div class="row mb-2">
									<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
										<select name="destination" id="destination" class="form-control custom-select">
											<option value="all">All trips available</option>
										</select>
									</div>
										<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-5">
											<input type="text" class="form-control" id="datarange" name="daterange" required>
										</div>
										<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-3">
											<input type="text" class="form-control" placeholder="# of People" id="capacity" name="capacity" required>
										</div>
								</div>

								<div class="row align-items-center">
									<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
									<input type="submit" class="btn btn-primary btn-block" value="Search" >
									</div>
									<div class="col-lg-8">
									<label class="control control--checkbox mt-3">
										<span class="caption">Save this search</span>
										<input type="checkbox" checked="checked" />
										<div class="control__indicator"></div>
									</label>
									</div>
								</div>
								</form>
								<div id="search-results"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="slides">
						<img src="images/hero-slider-1.jpg" alt="Image" class="img-fluid active">
						<img src="images/hero-slider-2.jpg" alt="Image" class="img-fluid">
						<img src="images/hero-slider-3.jpg" alt="Image" class="img-fluid">
						<img src="images/hero-slider-4.jpg" alt="Image" class="img-fluid">
						<img src="images/hero-slider-5.jpg" alt="Image" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="untree_co-section">
		<div class="container">
			<div class="row mb-5 justify-content-center">
				<div class="col-lg-6 text-center">
					<h2 class="section-title text-center mb-3">Our Services</h2>
					<p>Far far away, is your wish to travel? Do you want to escape your everyday reality, with a marvelous trip to never forget? Tour is here for you.</p>
				</div>
			</div>
			<div class="row align-items-stretch">
				<div class="col-lg-4 order-lg-1">
					<div class="h-100"><div class="frame h-100"><div class="feature-img-bg h-100" style="background-image: url('images/hero-slider-1.jpg');"></div></div></div>
				</div>

				<div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-1" >

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-house display-4 text-primary"></span>
							<h3>Beautiful Condo</h3>
							<p class="mb-0">Where luxury checks in and stress checks out.</p>
						</div>
					</div>

					<div class="feature-1 ">
						<div class="align-self-center">
							<span class="flaticon-restaurant display-4 text-primary"></span>
							<h3>Restaurants & Cafe</h3>
							<p class="mb-0">Savor the moment at our curated dining spots—where local flavors meet global cuisine, and every meal becomes a cherished memory.</p>
						</div>
					</div>

				</div>

				<div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-3" >

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-mail display-4 text-primary"></span>
							<h3>Easy to Connect</h3>
							<p class="mb-0">Connectivity made invisible—so you can focus on being present, while we handle the tech behind the scenes.</p>
						</div>
					</div>

					<div class="feature-1 d-md-flex">
						<div class="align-self-center">
							<span class="flaticon-phone-call display-4 text-primary"></span>
							<h3>24/7 Support</h3>
							<p class="mb-0">Help is always on call—our dedicated support team wraps around your schedule, not ours, for peace of mind that never sleeps.</p>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<?php
$resTravels = $conn->query("SELECT COUNT(*) AS travels FROM reservations");
$travels = $resTravels->fetch_assoc()['travels'];

$resClients = $conn->query("SELECT COUNT(ID) AS clients FROM reservations");
$clients = $resClients->fetch_assoc()['clients'];

$resCountries = $conn->query("
    SELECT COUNT(DISTINCT place) AS countries
    FROM packages 
");
$countries = $resCountries->fetch_assoc()['countries'];

$resEmployees=$conn->query("SELECT COUNT(ID) AS employees FROM employees");
$employees = $resEmployees->fetch_assoc()['employees'];
?>


	<div class="untree_co-section count-numbers py-5">
    <div class="container">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="<?= $travels ?>"><?= $travels ?></span>
                    </div>
                    <span class="caption">No. of Travels</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="<?= $clients ?>"><?= $clients ?></span>
                    </div>
                    <span class="caption">No. of Clients</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="<?= $employees ?>"><?= $employees ?></span>
                    </div>
                    <span class="caption">No. of Employees</span>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="counter-wrap">
                    <div class="counter">
                        <span class="" data-number="<?= $countries ?>"><?= $countries ?></span>
                    </div>
                    <span class="caption">No. of Countries</span>
                </div>
            </div>
        </div>
    </div>
</div>




	<div class="untree_co-section"> 
    <div class="container">
        <div class="row text-center justify-content-center mb-5">
            <div class="col-lg-7"><h2 class="section-title text-center">Popular Destination</h2></div>
        </div>

        <div class="owl-carousel owl-3-slider">

        <?php

            $query = "SELECT ID, Place, Name, image_path FROM packages";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $destination = htmlspecialchars($row['Name']);
                    $country = htmlspecialchars($row['Place']);
                    $imagePath = htmlspecialchars($row['image_path']);

                    echo '
                    <div class="item">
                        <a class="media-thumb" href="images/' . $imagePath . '" data-fancybox="gallery">
                            <div class="media-text">
                                <h3>' . $destination . '</h3>
                                <span class="location">' . $country . '</span>
                            </div>
                            <img src="images/' . $imagePath . '" alt="Image of ' . $destination . '" class="img-fluid">
                        </a> 
                    </div>';
                }
            } else {
                echo '<p class="text-center">No destinations found.</p>';
            }
        ?>

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
	

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.animateNumber.min.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<script src="js/aos.js"></script>
	<spt src="js/moment.min.js"></script>
	<script src="js/daterangepicker.js"></script>

	<script src="js/typed.js"></script>
	<script>
		$(function() {
			var slides = $('.slides'),
			images = slides.find('img');

			images.each(function(i) {
				$(this).attr('data-id', i + 1);
			})

			var typed = new Typed('.typed-words', {
				strings: ["San Francisco."," Paris."," New Zealand.", " Maui.", " London."],
				typeSpeed: 80,
				backSpeed: 80,
				backDelay: 4000,
				startDelay: 1000,
				loop: true,
				showCursor: true,
				preStringTyped: (arrayPos, self) => {
					arrayPos++;
					console.log(arrayPos);
					$('.slides img').removeClass('active');
					$('.slides img[data-id="'+arrayPos+'"]').addClass('active');
				}

			});
		})
	</script>

	<script src="js/custom.js"></script>
	<script>
	$(function() {
		$('#daterange').daterangepicker({
			opens: 'left',
			locale: {
				format: 'YYYY-MM-DD'
			}
		});
	});
	</script>

	<script>
		$(document).ready(function () {
		$('#type').on('change', function () {
			const selectedType = $(this).val();

			$.ajax({
			url: 'php/get_destinations.php',
			type: 'POST',
			data: { type: selectedType },
			success: function (data) {
				$('#destination').html(data);
			}
			});
		});
		});
	</script>

	
	<?php
	include("footer.php");
	?>
