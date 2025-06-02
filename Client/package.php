
<?php 
include "../connect-db.php";
?>
<?php 
// Retrieve package ID from GET
if (!isset($_GET['package_id'])) {
    die("Invalid package selection.");
}

$packageID = intval($_GET['package_id']);
$nr_places = intval($_GET['nr_places']);

// Fetch package details
$stmt = $conn->prepare("SELECT * FROM packages WHERE ID = ?");
$stmt->bind_param("i", $packageID);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$package) {
    die("Package not found.");
}

// Fetch available spots
$capacityStmt = $conn->prepare("SELECT available_spots FROM packages WHERE ID = ?");
$capacityStmt->bind_param("i", $packageID);
$capacityStmt->execute();
$capacityResult = $capacityStmt->get_result()->fetch_assoc();
$capacity = (int)($capacityResult['available_spots'] ?? 0);
$capacityStmt->close();

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
  <style>
  .review-success {
    margin-top: 10px;
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    transition: opacity 1s ease-out;
    opacity: 1;
}
.review-success.fade-out {
    opacity: 0;
}

.rounded-container {
  background-color: white;
  border-radius: 60px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  height: 100%;
}

.card-img-top {
  width: 100%;
  height: 220px; /* Adjust this to control image height */
  object-fit: cover;
  border-top-left-radius: 60px;
  border-top-right-radius: 60px;
}

.card-body {
  padding: 20px;
  min-height: 200px; /* Adjust this if you add content below */
}

.hero {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 100vh; /* Adjust based on how tall you want it */
  padding: 100px 0; /* Adjust vertical spacing */
  border-bottom-left-radius: 100px;
  border-bottom-right-radius: 100px;
}


</style>

  <title>Search Results – EpicEscape</title>
</head>

<body>
  <?php include_once("header.php"); ?>
<div class="hero" style="background-image: url('images/<?= htmlspecialchars($package['image_path']); ?>');">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <div class="intro-wrap">
          <h1 class="mb-5">
            <span class="d-block">        <?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : -1; ?><?= htmlspecialchars($package['Name']); ?></span>
          </h1>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="image-card rounded-container">
          <div class="card-body" style="padding-left: 20px;">
      
            <h4 class="card-title"><?= htmlspecialchars($package['Name']); ?></h4>
            <p><strong>Place:</strong> <?= htmlspecialchars($package['Place']); ?></p>
            <p><strong>Type:</strong> <?= htmlspecialchars($package['Type']); ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($package['Description']); ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($package['Date']); ?></p>
            <p><strong>Duration:</strong> <?= htmlspecialchars($package['Duration']); ?> days</p>
            <p><strong>Price: $</strong> <?= htmlspecialchars($package['Price']); ?></p>
          
          <!-- Make Reservation -->
                    <form action="complete_reservation.php" method="POST">
                        <input type="hidden" name="places_requested" value="<?php echo htmlspecialchars($nr_places); ?>">
                        <input type="hidden" name="package_id" value="<?= htmlspecialchars($packageID); ?>">
                        <button type="submit"  class="btn btn-outline-success w-100 rounded-pill py-2">
                            📝 Make Reservation
                        </button>
                    </form>

                    <p class="mt-2 text-center fw-bold text-<?= ($capacity-$nr_places) > 0 ? 'success' : 'danger' ?>">
                        <?= ($capacity-$nr_places) > 0
                            ? "✅ Available spots: <strong>$capacity</strong>"
                            : "❌ No spots left."; ?>
                    </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="css/goBackButton.css">

  </div>
    <div class="container mt-5">
        <div class="row">
            <!-- Right Side - Actions -->
            <div class="col-md-12" style= "margin-bottom: 30px;">
                <div class="card shadow-sm bg-light text-white p-4">
                    <a href="index.php" class="go-back-btn">
                      GO BACK TO HOMEPAGE
                      <span class="go-back-icon"></span>
                    </a>
                    <!-- Check Reviews -->
                    <button class="btn btn-outline-primary w-100 rounded-pill py-2 mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#reviews">
                        ⭐ Check Reviews
                    </button>

                    <div class="collapse mt-3" id="reviews">
                        <div class="bg-light text-dark p-3 border rounded">
                            <h6 class="mb-3">Customer Reviews:</h6>
                            <?php
                            $reviewStmt = $conn->prepare("SELECT r.review, r.DateSubmitted, c.Name, c.Surname FROM reviews r JOIN clients c ON r.ClientID = c.ID WHERE r.packageID = ? AND r.Confirmed = 1");
                            $reviewStmt->bind_param("i", $packageID);
                            $reviewStmt->execute();
                            $reviews = $reviewStmt->get_result();

                            if ($reviews->num_rows > 0):
                                echo '<div class="row g-4">';
                                while ($review = $reviews->fetch_assoc()):
                                    $date = date("F j, Y", strtotime($review['DateSubmitted']));
                                    ?>
                                    <div class="border rounded p-3 mb-3 bg-white">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong><?= htmlspecialchars($review['Name'] . ' ' . $review['Surname']); ?></strong>
                                                <div class="text-muted small"><?= $date; ?></div>
                                            </div>
                                        </div>
                                        <div class="mt-2">“<?= htmlspecialchars($review['review']); ?>”</div>
                                    </div>
                                <?php endwhile;
                                echo '</div>';
                            else: ?>
                                <p class="small fst-italic text-muted">No reviews yet.</p>
                            <?php endif;
                            $reviewStmt->close();
                            ?>
                        </div>
                    </div>

                    <!-- Add Review -->
                    <form action="submit_review.php" method="POST">
                        <input type="hidden" name="package_id" value="<?= htmlspecialchars($packageID); ?>">
                         <input type="hidden" name="nr_places" value="<?= htmlspecialchars($nr_places); ?>">
                        <textarea class="form-control mt-3" name="review_text" placeholder="Write your review here..." required></textarea>
                        <button type="submit" class="btn btn-outline-info w-100 rounded-pill py-2 mt-3">✍️ Add Review</button>
                    </form>
                    <?php if (isset($_GET['review']) && $_GET['review'] === 'success'): ?>
                  <div class="review-success" style="margin-top:10px; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">
                    ✅ Your review was submitted successfully and is pending approval.
                  </div>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'login_required'): ?>
                  <div class="review-success" style="margin-top: 10px;padding: 12px 15px;
                  background-color: #3a2a21;      /* dark brownish background */
                  color: #f1c40f;                 /* warm golden yellow text */
                  border: 1.5px solid #f39c12;   /* slightly brighter yellow border */
                  border-radius: 6px;
                  text-align: center;
                  font-weight: 600;
                  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                ">
                  You need to 
                  <a href="login.php" style="
                    color: #f39c12;               /* match border/yellow for link */
                    text-decoration: underline;
                    font-weight: 700;
                  ">
                    log in
                  </a> 
                  first to submit a review.
                </div>

                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<script>
    setTimeout(function() {
        const alert = document.querySelector('.review-success');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 1000); // Wait for the fade-out animation to finish before hiding
        }
    }, 4000);
     if (window.location.search.includes('review=success')) {
        const url = new URL(window.location);
        url.searchParams.delete('review');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
     if (window.location.search.includes('error=login_required')) {
        const url = new URL(window.location);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
</script>


<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include("footer.php"); ?>
</body>
</html>