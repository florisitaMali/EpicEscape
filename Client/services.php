<!-- /*
* Template Name: Tour
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
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

  <title>Tour-Services</title>
</head>

<body>

<?php
include ("header.php");
?>


  <div class="hero hero-inner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mx-auto text-center">
          <div class="intro-wrap">
            <h1 class="mb-0">Our Services</h1>
            <p class="text-white">         <?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : -1; ?>At EpicEscape, we believe travel should be more than just a trip — it should be an experience you'll never forget. </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  
  <div class="untree_co-section">
    <div class="container">
      <div class="row">
        <div class="col-6 col-md-6 col-lg-3">
          <div class="media-1">
            <a href="#" class="d-block mb-3"><img src="images/hero-slider-1.jpg" alt="Image" class="img-fluid"></a>
            <div class="d-flex">
              <div>
                <h3><a href="#">Excellence in Travel</a></h3>
                <p>At EpicEscape, we believe that travel is more than reaching a destination — it's about discovering the best the world has to offer and creating unforgettable moments that stay with you forever.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="media-1">
            <a href="#" class="d-block mb-3"><img src="images/hero-slider-2.jpg" alt="Image" class="img-fluid"></a>
            <div class="d-flex">
              <div>
                <h3><a href="#">Discovering Best</a></h3>
                <p>The best journeys aren't found — they're crafted.
                Let EpicEscape guide you to the finest destinations, moments, and memories.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="media-1">
            <a href="#" class="d-block mb-3"><img src="images/hero-slider-3.jpg" alt="Image" class="img-fluid"></a>
            <div class="d-flex">
              <div>
                <h3><a href="#">A New Moments of Life</a></h3>
                <p>New destinations, new emotions, new moments of life.
                With EpicEscape, every trip is a fresh beginning.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="media-1">
            <a href="#" class="d-block mb-3"><img src="images/hero-slider-4.jpg" alt="Image" class="img-fluid"></a>
            <div class="d-flex">
              <div>
                <h3><a href="#">Joy To Your Journey</a></h3>
                <p>Bring joy to every journey with EpicEscape.
                Because every adventure deserves a smile.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="untree_co-section">
    <div class="container">
      <div class="row">
        <div class="col-6 col-md-6 col-lg-3">
          <div class="service text-center">
            <span class="icon-paper-plane"></span>
            <h3>Excellence in Travel</h3>
            <p>Crafting Journeys with Precision and Passion.</p>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="service text-center">
            <span class="icon-tag"></span>
            <h3>Discover Best</h3>
            <p>Your Gateway to the World's Finest.</p>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="service text-center">
            <span class="icon-user"></span>
            <h3>A New Moments of Life</h3>
            <p>Unlock New Moments with Every Step.</p>
          </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
          <div class="service text-center">
            <span class="icon-support"></span>
            <h3>Joy To Your Journey</h3>
            <p>Where Every Journey Smiles Back at You.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="untree_co-section">
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-lg-6 text-center">
          <h2 class="section-title text-center mb-3">More Services</h2>
          <p>At EpicEscape, we believe every detail matters. That's why we offer more than just travel — we create a full experience. Here with us your journey is made simple, smooth, and full of joy — from your first coffee to your last sunset.</p>
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
              <p class="mb-0"> Relax in our comfortable, handpicked condos — your home away from home.</p>
            </div>
          </div>

          <div class="feature-1 ">
            <div class="align-self-center">
              <span class="flaticon-restaurant display-4 text-primary"></span>
              <h3>Restaurants & Cafe</h3>
              <p class="mb-0"> Enjoy delicious meals and cozy atmospheres at our selected partner spots.</p>
            </div>
          </div>

        </div>

        <div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-3" >

          <div class="feature-1 d-md-flex">
            <div class="align-self-center">
              <span class="flaticon-mail display-4 text-primary"></span>
              <h3>Easy to Connect</h3>
              <p class="mb-0">Seamless transfers and effortless coordination — so you can focus on enjoying every moment.</p>
            </div>
          </div>

          <div class="feature-1 d-md-flex">
            <div class="align-self-center">
              <span class="flaticon-phone-call display-4 text-primary"></span>
              <h3>24/7 Support</h3>
              <p class="mb-0">Wherever you are, whenever you need us, we're always just a call or message away.
               
              </p>
            </div>
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
