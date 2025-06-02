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


  <title>Search Results – EpicEscape</title>
</head>

<body>

  <?php include("header.php"); ?>

  <div class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="intro-wrap">
            <h1 class="mb-5">
              <span class="d-block">        <?php echo isset($_SESSION['ID']) ? $_SESSION['ID'] : -1; ?>Search</span>
              Results
            </h1>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="slides">
            <img src="images/hero-slider-1.jpg" class="img-fluid active" alt="...">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script> console.log("1"); </script>
<link rel="stylesheet" href="css/goBackButton.css">


<div class="untree_co-section">
  <div class="container">
    <a href="index.php" class="go-back-btn" style = "margin-bottom: 20px;">
      GO BACK TO HOMEPAGE
      <span class="go-back-icon"></span>
    </a>
    <div class="reservation-wrapper">
      <h2 class="section-title mb-4">Search Results</h2>
    <div class="container-fluid bg-dark text-white p-3 rounded" style = "margin-bottom: 20px">
      <div class="row g-3">
        <!-- First row -->
        <div class="col-md-3">
          <label for="sortSelect" class="form-label">Sort By</label>
          <select id="sortSelect" class="form-select">
            <option value="default">Default</option>
            <option value="name_asc">Name (A-Z)</option>
            <option value="name_desc">Name (Z-A)</option>
            <option value="price_asc">Price (Low to High)</option>
            <option value="price_desc">Price (High to Low)</option>
            <option value="start_asc">Start Date (Earliest)</option>
            <option value="start_desc">Start Date (Latest)</option>
            <option value="duration_asc">Duration (Shortest)</option>
            <option value="duration_desc">Duration (Longest)</option>
          </select>
        </div>

        <div class="col-md-3" >
          <label class="form-label">Available Spots</label>
          <div class="d-flex flex-wrap">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="spots5" value="5">
              <label class="form-check-label text-white" for="spots5">5+</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="spots10" value="10">
              <label class="form-check-label text-white" for="spots10">10+</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="spots15" value="15">
              <label class="form-check-label text-white" for="spots15">15+</label>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <label class="form-label">Min Duration (days)</label>
          <input type="number" class="form-control" id="minDuration">
        </div>
      </div>

      <div class="row g-3 mt-3">
        <!-- Second row -->
        <div class="col-md-3">
          <label class="form-label">Start Date</label>
          <input type="text" class="form-control" id="startDatePicker">
        </div>
        <div class="col-md-3">
          <label class="form-label">End Date</label>
          <input type="text" class="form-control" id="endDatePicker">
        </div>
        <div class="col-md-6">
          <label class="form-label">Price Range ($)</label>
          <div class="input-group">
            <input type="number" class="form-control" id="minPrice" placeholder="Min">
            <input type="number" class="form-control" id="maxPrice" placeholder="Max">
          </div>
        </div>
      </div>
    </div>

    <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $type = $conn->real_escape_string($_POST['type']);

          if(!$type){
            header("Location: index.php");
          }

          $destination = $conn->real_escape_string($_POST['destination']);
          $daterange = $conn->real_escape_string($_POST['daterange']);
          $placesRequested = $conn->real_escape_string($_POST['capacity']);

          [$start_date, $end_date] = explode(' - ', $daterange);
          $start_date = date('Y-m-d', strtotime($start_date));
          $end_date = date('Y-m-d', strtotime($end_date));

          // Build query based on selection
          if ($destination === 'all') {
              $stmt = "SELECT * FROM packages WHERE Date >= '$start_date' AND endDate <= '$end_date'";
          } else {
              $stmt = "SELECT * FROM packages WHERE ID = '$destination' AND Date >= '$start_date' AND endDate <= '$end_date'";
          }

          if ($type !== "all") {
              $stmt .= " AND Type = '$type'";
          }

          $res = $conn->query($stmt);

          if ($res->num_rows > 0) {
              echo '<div class="row" id="resultsContainer">';

              while ($row = $res->fetch_assoc()) {
                  $packageID = $row['ID'];

                  // Capacity Check
                  $capacityStmt = $conn->prepare("SELECT available_spots FROM packages WHERE ID = ?");
                  $capacityStmt->bind_param("i", $packageID);
                  $capacityStmt->execute();
                  $capacityResult = $capacityStmt->get_result()->fetch_assoc();
                  $capacity = (int)($capacityResult['available_spots'] ?? 0);
                  $capacityStmt->close();

                  $remaining = $capacity 
                  ?>

                  <div class="col-md-6 col-lg-4 mb-4" data-price="<?= htmlspecialchars($row['Price']); ?>" data-start="<?= htmlspecialchars($row['Date']); ?>">
                      <div class="card shadow-sm h-100 rounded overflow-hidden">
                          <img src="images/<?= htmlspecialchars($row['image_path']); ?>" class="card-img-top rounded-top object-fit-cover"
                              style="height: 220px;"
                              alt="<?= htmlspecialchars($row['Name']); ?>">
                          <div class="card-body d-flex flex-column justify-content-between">
                              <h5 class="card-title"><?= htmlspecialchars($row['Name']); ?></h5>
                              <p class="card-text"><strong>Place:</strong> <?= htmlspecialchars($row['Place']); ?></p>
                              <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['Type']); ?></p>
                              <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($row['Description']); ?></p>
                              <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($row['Date']); ?></p>
                              <p class="card-text"><strong>Duration:</strong> <?= htmlspecialchars($row['Duration']); ?> days</p>
                              <p class="card-text"><strong>Price: $</strong> <?= htmlspecialchars($row['Price']); ?></p>

                              <!-- Redirect to package.php -->
                              <form action="package.php" method="GET">
                                  <input type="hidden" name="package_id" value="<?= htmlspecialchars($packageID); ?>">
                                  <input type="hidden" name="nr_places" value="<?php echo htmlspecialchars($placesRequested); ?>">
                                  <button type="submit" class="btn btn-outline-success mt-3 w-100 rounded-pill py-2">
                                      📝 View Package Details
                                  </button>
                              </form>
                          </div>
                      </div>
                  </div>
              <?php }
              echo '</div>';
          } else {
              echo '<p>No trips available for the selected criteria.</p>';
          }
      }
    ?>
  </div>
</div>

  <script> console.log("3"); </script>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.js"></script>

<script>
$(function () {
  $('#startDatePicker, #endDatePicker').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    locale: { format: 'YYYY-MM-DD' }
  });

  // Get predefined search dates from PHP
  let startDateFromPHP = "<?php echo $start_date; ?>";
  let endDateFromPHP = "<?php echo $end_date; ?>";

  // Pre-fill date pickers with search values
  $('#startDatePicker').val(startDateFromPHP);
  $('#endDatePicker').val(endDateFromPHP);

  function getRemainingSpots(card) {
    const text = $(card).find('p.mt-2').text();
    const match = text.match(/only (\d+) place\(s\)/);
    if (match) return parseInt(match[1]);
    const match2 = text.match(/reservation for (\d+)/);
    return match2 ? parseInt(match2[1]) : 0;
  }

  function matchesFilters(card) {
    const duration = parseInt($(card).find(".card-text:contains('Duration')").text().match(/\d+/));
    const startDate = new Date($(card).data('start'));
    const price = parseFloat($(card).data('price'));
    const spots = getRemainingSpots(card);

    const minDur = parseInt($('#minDuration').val()) || 0;
    const minDate = startDateFromPHP ? new Date(startDateFromPHP) : null;
    const maxDate = endDateFromPHP ? new Date(endDateFromPHP) : null;
    const minP = parseFloat($('#minPrice').val()) || 0;
    const maxP = parseFloat($('#maxPrice').val()) || Infinity;
    const spotVals = $('input[type=checkbox]:checked').map((_, el) => parseInt($(el).val())).get();

    const filtersActive = minDur > 0 || minP > 0 || maxP !== Infinity || spotVals.length > 0 || startDateFromPHP || endDateFromPHP;

    if (!filtersActive) return true; // Show all results if no filters are selected

    if (duration < minDur) return false;
    if (minDate && startDate < minDate) return false;
    if (maxDate && startDate > maxDate) return false;
    if (price < minP || price > maxP) return false;
    if (spotVals.length > 0 && !spotVals.some(val => spots >= val)) return false;

    return true;
  }

  function sortAndFilter() {
    let cards = $('#resultsContainer .col-md-6');
    cards.hide();

    const sortBy = $('#sortSelect').val();
    cards.sort((a, b) => {
      const $a = $(a), $b = $(b);
      if (sortBy.includes('name')) {
        const nA = $a.find('.card-title').text().toLowerCase();
        const nB = $b.find('.card-title').text().toLowerCase();
        return sortBy.endsWith('asc') ? nA.localeCompare(nB) : nB.localeCompare(nA);
      }
      if (sortBy.includes('price')) {
        const pA = parseFloat($a.data('price'));
        const pB = parseFloat($b.data('price'));
        return sortBy.endsWith('asc') ? pA - pB : pB - pA;
      }
      if (sortBy.includes('duration')) {
        const dA = parseInt($a.find(".card-text:contains('Duration')").text().match(/\d+/));
        const dB = parseInt($b.find(".card-text:contains('Duration')").text().match(/\d+/));
        return sortBy.endsWith('asc') ? dA - dB : dB - dA;
      }
      if (sortBy.includes('start')) {
        const sA = new Date($a.data('start'));
        const sB = new Date($b.data('start'));
        return sortBy.endsWith('asc') ? sA - sB : sB - sA;
      }
      return 0;
    });

    cards.each(function () {
      if (matchesFilters(this)) $(this).show();
    });

    $('#resultsContainer').append(cards);
  }

  // Trigger sorting and filtering when inputs change
  $('select, input').on('change keyup', sortAndFilter);
});
</script>
  <script> console.log("4"); </script>

<?php include("footer.php"); ?>
</body>
</html> 

