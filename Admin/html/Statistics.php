<?php
include_once '../header.php';
include_once '../../config.php';
include_once '../../connect-db.php';
include_once '../php/statistics.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
    $stats = getStatistics($conn);
    $recent_bookings = getRecentBookings($conn);
    $topTours= getTopPerformingTours($conn);
    $upcomingTours =  getupcommingPackages($conn);
    $popularDestinations = getPopularDestinations($conn);
    
    $revenues = getRevenues($conn);
    $labels = array_keys($revenues);
    $values = array_values($revenues);

    $bookingsByCategory = getBookingsByCategory($conn);
    $barLabels = array_keys($bookingsByCategory);
    $barValues = array_values($bookingsByCategory);

    $selected_period = $_GET['period'] ?? 'last_6_months';
    $revenue_data = getRevenueData($conn, $selected_period);
?>

<div class="d-flex">
  
  <!-- Main content area -->
  <div id="main-content" class="flex-grow-1 ms-auto">
     <!-- Main Content -->
    <div class="container" id="general-stats" style="margin-top: 100px;">
      <h2 class="mb-4 fw-semibold text-dark" >General Statistics</h2>
      <div class="row g-4" >
        <!-- Stats Grid -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title">Total Clients</h6>
                <h3 class="text-primary mb-0"><?= number_format($stats['total_clients']) ?></h3>
              </div>
              <i class="bi bi-people-fill text-primary fs-2"></i>
            </div>
          </div>
        </div>

      <!-- Active Packages -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title">Active Packages</h6>
                <h3 class="text-success mb-0"><?= number_format($stats['active_packages']) ?></h3>
              </div>
              <i class="bi bi-box-seam text-success fs-2"></i>
            </div>
          </div>
        </div>

      <!-- Reservations -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title">Reservations</h6>
                <h3 class="text-info mb-0"><?= number_format($stats['total_reservations']) ?></h3>
                <?php 
                    $reservations_percentage = calculatePercentage('reservations', $conn);
                    if($reservations_percentage > 0) {
                        $arrow = 'bi-arrow-up';
                        $text = "text-success";
                        $sign = "+";
                    } else {
                        $arrow = 'bi-arrow-down';
                        $text = "text-danger";
                        $sign = "";
                    }
                
                  echo "<small class='$text'><i class='bi $arrow'></i> ".$sign.$reservations_percentage."% this week</small>";
                ?>
              </div>
              <i class="bi bi-calendar-check text-info fs-2"></i>
            </div>
          </div>
        </div>

      <!-- Revenue -->
        <div class="col-md-6 col-xl-3">
          <div class="card shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title">Revenue</h6>
                <h3 class="text-warning mb-0">€<?= number_format($stats['total_revenue'], 0) ?></h3>
                <?php 
                    $revenue_percentage = calculatePercentage('revenue', $conn);
                    if($revenue_percentage > 0) {
                        $arrow = 'bi-arrow-up';
                        $text = "text-success";
                        $sign = "+";
                    } else {
                        $arrow = 'bi-arrow-down';
                        $text = "text-danger";
                        $sign = "";
                    }
                
                  echo "<small class='$text'><i class='bi $arrow'></i> ".$sign.$revenue_percentage."% this week</small>";
                  ?>
              </div>
              <i class="bi bi-cash-coin text-warning fs-2"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mb-5"  id="detailed-stats">
      <h2 class="mb-4 fw-semibold text-dark">Detailed Statistics</h2>
      <div class="row g-4">
        <!-- Monthly Revenue Chart -->
        <div class="col-md-6">
          <div class="card shadow-sm p-4">
            <h5 class="card-title mb-3">Monthly Revenue</h5>
            <canvas id="lineChart"></canvas>
          </div>
        </div>

        <!-- Booking Statistics Chart -->
        <div class="col-md-6">
          <div class="card shadow-sm p-4">
            <h5 class="card-title mb-3">Booking Statistics</h5>
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
      <div class="card shadow-sm mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Recent Bookings</h5>
          <a href="Reservations.php" class="btn btn-link p-0 text-decoration-none">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Package</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Status</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($recent_bookings as $booking): ?>
              <tr>
                <td><?= htmlspecialchars($booking['package_name']) ?></td>
                <td><?= htmlspecialchars($booking['destination']) ?></td>
                <td><?= date('M d, Y', strtotime($booking['travel_date'])) ?></td>
                <td>
                  <span class="badge bg-<?= $booking['available_spots'] > 0 ? 'success' : 'danger' ?>">
                    <?= $booking['available_spots'] > 0 ? 'Available' : 'Fully Booked' ?>
                  </span>
                </td>
                <td>€<?= number_format($booking['amount'], 2) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div> 

    <div class="container mb-5" id="travel-revenue">
      <h2 class="mb-4 fw-semibold text-dark">Travel & Revenue Statistics</h2>
      <div class="row g-4">
        <!-- Popular Destinations -->
        <div class="col-md-6">
          <div class="card shadow-sm p-4">
            <h5 class="card-title mb-3">Popular Destinations</h5>
            <div class="vstack gap-3">
              <?php foreach ($popularDestinations as $index => $dest): ?>
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                  <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    <div>
                      <h6 class="mb-0"><?= htmlspecialchars($dest['place']) ?></h6>
                      <small class="text-muted"><?= $dest['reservation_count'] ?> bookings this month</small>
                    </div>
                  </div>
                  <!-- Optional trend info; here just as a static placeholder -->
                  <span class="text-success fw-semibold"><?= getStatisticsPerCountry($conn, $dest['place']); ?>%</span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Top Performing Tours -->
        <div class="col-md-6">
          <div class="card shadow-sm p-4">
            <h5 class="card-title mb-3">Top Performing Tours</h5>
            <div class="vstack gap-3">
              <?php foreach ($topTours as $tour): ?>
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                  <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-route text-primary"></i>
                    <div>
                      <h6 class="mb-0"><?= htmlspecialchars($tour['Name']) ?></h6>
                      <small class="text-muted">€<?= getStatisticsPerRevenue($conn, $tour['ID']); ?> revenue</small>
                    </div>
                  </div>
                  <span class="text-success fw-semibold">
                    <?= rand(10, 30) ?>%
                  </span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="card shadow-sm p-4 mt-4">
        <h5 class="card-title mb-3">Upcoming Tours</h5>
        <div class="row g-4">
          <?php foreach ($upcomingTours as $tour): ?>
            <div class="col-md-4">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h6 class="mb-1"><?= htmlspecialchars($tour['name']) ?></h6>
                    <small class="text-muted">
                      <?= date('M j', strtotime($tour['date'])) ?> - <?= date('M j', strtotime($tour['date'] . ' + ' . $tour['duration'] . ' days')) ?>
                    </small>
                  </div>
                  <span class="badge text-bg-primary"><?= $tour['available_spots'] ?> spots left</span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div id="revenue-overview" class="card shadow-sm p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title mb-0">Revenue Overview</h5>
          <form method="GET" class="d-inline" id="periodForm">
            <?php foreach($_GET as $key => $value): ?>
              <?php if($key !== 'period'): ?>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
              <?php endif; ?>
            <?php endforeach; ?>
            <input type="hidden" name="scroll" value="revenue-overview">
            <select name="period" class="form-select form-select-sm" onchange="updateRevenue(this)">
              <option value="last_6_months" <?= $selected_period == 'last_6_months' ? 'selected' : '' ?>>Last 6 Months</option>
              <option value="last_year" <?= $selected_period == 'last_year' ? 'selected' : '' ?>>Last Year</option>
              <option value="all_time" <?= $selected_period == 'all_time' ? 'selected' : '' ?>>All Time</option>
            </select>
          </form>
        </div>

        <div class="row g-4">
          <!-- Revenue Chart -->
          <div class="col-md-6">
            <canvas id="revenueChart"></canvas>
          </div>

          <!-- Revenue Stats -->
          <div class="col-md-6">
            <div class="row g-3">
              <div class="col-6">
                <div class="bg-light p-3 rounded text-center">
                  <p class="mb-1 small text-muted">Total Revenue</p>
                  <h4 class="text-primary mb-0">
                    €<?= number_format(array_sum(array_column($revenue_data, 'revenue')), 0) ?>
                  </h4>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-light p-3 rounded text-center">
                  <p class="mb-1 small text-muted">Average Booking Value</p>
                  <h4 class="text-success mb-0">
                    €<?= number_format(
                      array_sum(array_column($revenue_data, 'revenue')) /
                      max(1, array_sum(array_column($revenue_data, 'bookings'))),
                    0) ?>
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
$('#toggleSidebar').on('click', function () {
  const $sidebar = $('#sidebar');
  const $main = $('#main-content');
  $sidebar.toggleClass('collapsed');
  if ($sidebar.hasClass('collapsed')) {
    $main.css('margin-left', '70px');
    $(this).find('i').removeClass('bi-chevron-left').addClass('bi-chevron-right');
  } else {
    $main.css('margin-left', '220px');
    $(this).find('i').removeClass('bi-chevron-right').addClass('bi-chevron-left');
  }
});

</script>

  <script>
    // Define baby blue color palette
    const babyBlueColors = {
        primary: '#89CFF0',    // Baby Blue
        light: '#BFE6FF',      // Light Baby Blue
        lighter: '#D6F3FF',    // Lighter Baby Blue
        dark: '#5DADE2',       // Dark Baby Blue
        darker: '#3498DB',     // Darker Baby Blue
        transparent: 'rgba(137, 207, 240, 0.2)' // Baby Blue with transparency
    };

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
          label: 'Revenue (€)',
          data: <?= json_encode($values) ?>,
          borderColor: babyBlueColors.primary,
          tension: 0.3,
          fill: true,
          backgroundColor: babyBlueColors.transparent
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            callbacks: {
              label: function(context) {
                return '€' + context.parsed.y.toLocaleString();
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '€' + value.toLocaleString();
              }
            }
          }
        }
      }
    });

    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($barLabels) ?>,
        datasets: [{
          label: 'Bookings',
          data: <?= json_encode($barValues) ?>,
          backgroundColor: [
            `${babyBlueColors.primary}CC`,
            `${babyBlueColors.light}CC`,
            `${babyBlueColors.lighter}CC`,
            `${babyBlueColors.dark}CC`,
            `${babyBlueColors.darker}CC`
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueChartCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode(array_column($revenue_data, 'month')) ?>,
        datasets: [{
          label: 'Revenue (€)',
          data: <?= json_encode(array_column($revenue_data, 'revenue')) ?>,
          borderColor: babyBlueColors.primary,
          backgroundColor: babyBlueColors.transparent,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            callbacks: {
              label: function(context) {
                return '€' + context.parsed.y.toLocaleString();
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '€' + value.toLocaleString();
              }
            }
          }
        }
      }
    });

    <?php if ($_GET['scroll'] ?? '' === 'revenue-overview'): ?>  
        document.addEventListener("DOMContentLoaded", function() {
          const section = document.getElementById("revenue-overview");
          if (section) section.scrollIntoView({ behavior: "smooth" });
        });
    <?php endif; ?>

  </script>
<?php
include_once '../footer.php';
?>