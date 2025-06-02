<?php
  error_reporting(E_ERROR | E_PARSE);
  include_once '../config.php';
  include "../connect-db.php";

  if(!isset($_SESSION['packageID']) || !isset($_SESSION['placesRequested'])){

  $packageID = (int) ($_POST['package_id'] ?? 0);
  $placesRequested = (int) ($_POST['places_requested'] ?? 0);

  $_SESSION['packageID'] = $packageID;
  $_SESSION['placesRequested'] = $placesRequested;

  if ($packageID < 0 || $placesRequested <= 0) {
    header("Location: index.php");
    exit;
  }

  $userData = [];
  if (isset($_SESSION['ID'])) {
      $userID = $_SESSION['ID'];
      $stmt = $conn->prepare("SELECT name, surname, email, Age FROM clients WHERE ID = ?");
      $stmt->bind_param("i", $userID);
      $stmt->execute();
      $result = $stmt->get_result();
      $userData = $result->fetch_assoc();
      $stmt->close();
  }
}
else{
  $packageID = $_SESSION['packageID'];
  unset($_SESSION['packageID']);
  $placesRequested = $_SESSION['placesRequested'];
  unset($_SESSION['placesRequested']);

  if ($packageID < 0 || $placesRequested <= 0) {
    header("Location: index.php");
    exit;
  }

  $userData = [];
  if (isset($_SESSION['ID'])) {
      $userID = $_SESSION['ID'];
      $stmt = $conn->prepare("SELECT name, surname, email, Age FROM clients WHERE ID = ?");
      $stmt->bind_param("i", $userID);
      $stmt->execute();
      $result = $stmt->get_result();
      $userData = $result->fetch_assoc();
      $stmt->close();
  }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">

    <link rel="shortcut icon" href="favicon.png">
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

    <title>Enter Customer Details – EpicEscape</title>
  </head>
  <body>

    <?php include("header.php"); ?>

    <?php
    session_start(); // Ensure the session is started

    if (!isset($_SESSION['ID'])) {
          $_SESSION['redirection_needed'] = 'complete_reservation.php';
    ?>
  
    <!-- Sign-In Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="signInModalLabel">Sign In Required</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>To make your reservation, you need to <strong>sign in</strong>. This helps us offer you better deals and keep track of your reservations.</p>
            <p>If you want to proceed, please click the <strong>Sign In</strong> button below.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="../html/index.php" class="btn btn-primary">🔑 Sign In</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Automatically trigger the modal when needed -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      var signInModal = new bootstrap.Modal(document.getElementById('signInModal'));
      signInModal.show(); // Show modal when user is not signed in
    });
    </script>

    <?php
    } // End conditional check
    ?>
    <script> console.log(<?php echo $_SESSION['ID']?>); </script>
    <div class="hero">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <div class="intro-wrap">
              <h1 class="mb-5">
                <span class="d-block"> <?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : -1; ?>Reservation</span>
                Details
              </h1>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="slides">
              <img src="images/hero-slider-2.jpg" class="img-fluid active" alt="...">
            </div>
          </div>
        </div>
      </div>
    </div>

   
  <div class="container">
    <h2 class="section-title mb-4" style="color: #0d6efd;">Enter Details for <?php echo $placesRequested; ?> Customer(s)</h2> <br/>

    <form action="confirm_reservation.php" method="POST">
      <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($packageID); ?>">
      <input type="hidden" name="places_requested" value="<?php echo htmlspecialchars($placesRequested); ?>">

      <?php for ($i = 0; $i < $placesRequested; $i++): ?>
        <div class="border p-4 mb-4 rounded-4 shadow" style="background-color: #f8f9fa;">
          <h4 class="mb-3" style="color: #0d6efd;">Customer <?php echo $i + 1; ?></h4>
          
          <div class="form-group mb-3">
            <label style="color: #0d6efd;">First Name</label>
            <input type="text" name="customers[<?php echo $i; ?>][name]" class="form-control border-primary" required
              value="<?php echo ($i === 0 && $userData) ? htmlspecialchars($userData['name']) : ''; ?>">
          </div>
          <div class="form-group mb-3">
            <label style="color: #0d6efd;">Last Name</label>
            <input type="text" name="customers[<?php echo $i; ?>][surname]" class="form-control border-primary" required
              value="<?php echo ($i === 0 && $userData) ? htmlspecialchars($userData['surname']) : ''; ?>">
          </div>
          <div class="form-group mb-3">
            <label style="color: #0d6efd;">Email</label>
            <input type="email" name="customers[<?php echo $i; ?>][email]" class="form-control border-primary" required
              value="<?php echo ($i === 0 && $userData) ? htmlspecialchars($userData['email']) : ''; ?>">
          </div>
          <div class="form-group mb-3">
            <label style="color: #0d6efd;">Age</label>
            <input type="text" name="customers[<?php echo $i; ?>][age]" class="form-control border-primary" required
              value="<?php echo ($i === 0 && $userData) ? htmlspecialchars($userData['Age']) : ''; ?>">
          </div>
          <div class="form-group mb-3">
            <label style="color: #0d6efd;">passport Identification Number</label>
            <input type="text" name="customers[<?php echo $i; ?>][passportID]" class="form-control border-primary" required
              value="">
          </div>
        </div>
      <?php endfor; ?> 

          <button type="submit" class="btn btn-success btn-lg">✅ Confirm Reservation</button>
          <?php
          echo '
          <a href="index.php" style="
              display: inline-block;
              padding: 12px 25px;
              background-color: #007bff;
              color: white;
              text-decoration: none;
              border-radius: 8px;
              font-size: 16px;
              font-weight: bold;
              margin-top: 10px;
          ">
              ⬅️ Go Back to Homepage
          </a>
          ';
          ?>
        </form>
      </div>
    </div>

    <!-- Sign-In Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="signInModalLabel">Sign In Required</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>To make your reservation, you need to **sign in**. This helps us offer you better deals and keep track of your reservations.</p>
            <p>If you want to proceed, please click the **Sign In** button below.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="signin.php" class="btn btn-primary">🔑 Sign In</a>
          </div>
        </div>
      </div>
    </div>


    <?php include("footer.php"); ?>

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
