<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = $conn->real_escape_string($_POST['type']) ;
        $destination =  $conn->real_escape_string($_POST['destination']) ;
        $daterange =  $conn->real_escape_string($_POST['daterange']);
        $placesRequested =  $conn->real_escape_string($_POST['capacity']);

        
          [$start_date, $end_date] = explode(' - ', $daterange);
          $start_date = date('Y-m-d', strtotime($start_date));
          $end_date = date('Y-m-d', strtotime($end_date));

          // Use parameterized queries for both cases
          if ($destination === 'all') {
            $stmt = "SELECT * FROM packages WHERE Date >= '$start_date' AND endDate <= '$end_date'";
          } else {
            $stmt = "SELECT * FROM packages WHERE ID = '$destination' AND Date >= '$start_date' AND endDate <= ' $end_date'";
          }

          if($type !== "all"){
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

              $reservedStmt = $conn->prepare("SELECT COUNT(*) AS total_reserved FROM reservations WHERE PackageID = ?");
              $reservedStmt->bind_param("i", $packageID);
              $reservedStmt->execute();
              $reserved = (int)($reservedStmt->get_result()->fetch_assoc()['total_reserved'] ?? 0);
              $reservedStmt->close();

              $remaining = $capacity - $reserved;
              ?>

              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 rounded overflow-hidden">
                  <img src="images/<?= htmlspecialchars($row['image_path']); ?>" class="card-img-top rounded-top object-fit-cover" 
                    style="height: 220px;" 
                    alt="<?= htmlspecialchars($row['Name']); ?>">
                  <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><?= htmlspecialchars($row['Name']); ?></h5>
                    <p class="card-text"><strong>Place:</strong> <?= htmlspecialchars($row['Place']); ?></p>
                    <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['Type']); ?></p>
                    <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($row['Description']); ?></p>
                    <p class="card-text"><strong>Duration:</strong> <?= htmlspecialchars($row['Duration']); ?> days</p>

                    <button class="btn btn-outline-primary mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#reviews_<?= $packageID ?>" aria-expanded="false" aria-controls="reviews_<?= $packageID ?>">Check Reviews</button>

                    <div class="collapse mt-3" id="reviews_<?= $packageID ?>">
                      <div class="bg-light p-3 border rounded">
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
                            <div class="border rounded p-3 position-relative mb-3 bg-white">
                              <div class="d-flex justify-content-between align-items-start">
                                <div>
                                  <strong><?= htmlspecialchars($review['Name'] . ' ' . $review['Surname']); ?></strong>
                                  <div class="text-muted small"><?= $date; ?></div>
                                </div>
                                <img src="../images/google-icon.png" alt="Google" style="width: 20px; height: 20px;">
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

                    <form action="complete_reservation.php" method="POST">
                        <input type="hidden" name="package_id" value="<?= htmlspecialchars($packageID); ?>">
                        <input type="hidden" name="places_requested" value="<?= htmlspecialchars($placesRequested); ?>">
                        <button type="submit"
                                class="btn <?= $placesRequested <= $remaining ? 'btn-outline-success' : 'btn-outline-secondary disabled' ?> mt-3 w-100 rounded-pill py-2">
                          📝 Make Reservation
                        </button>
                      </form>

                      <p class="mt-2 fw-bold text-<?= $placesRequested <= $remaining ? 'success' : 'danger' ?>">
                        <?= $placesRequested <= $remaining
                          ? "✅ Great news! Your reservation for <strong>$placesRequested</strong> place(s) is available."
                          : "❌ Sorry, only <strong>$remaining</strong> place(s) left. Please reduce your request." ?>
                      </p> 
                  </div>
                </div>
              </div>
              <?php
            }
            echo '</div>';
        }
           else {
            echo '<p>No trips available for the selected criteria.</p>';
          }

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
        }
?>