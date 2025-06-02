<?php
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    exit;
}
include_once '../connect-db.php';

$user_id = $_SESSION['ID'];

$query = "SELECT name, surname, username, Email, Age, Registration_Date FROM clients WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$reservationsQuery = "
SELECT 
    p.Name,
    r.reservation_date,
    r.client_name,
    r.client_surname,
    r.passportID,
    
FROM reservations r
JOIN packages p ON r.packageID = p.ID
WHERE r.clientID = ?
ORDER BY r.reservation_date DESC
";

$resStmt = $conn->prepare($reservationsQuery);
$resStmt->bind_param("i", $user_id);
$resStmt->execute();
$resResult = $resStmt->get_result();
$reservations = $resResult->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .profile-header {
      position: relative;
      background-color: #0d6efd;
      height: 180px;
    }
    .profile-img {
      position: absolute;
      bottom: -60px;
      left: 50%;
      transform: translateX(-50%);
      width: 120px;
      height: 120px;
      border: 4px solid white;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="profile-header text-center text-white d-flex align-items-center justify-content-center">
    <h2 class="mt-5">Welcome, <?= htmlspecialchars($user['name']) ?></h2>
    <img src="images/person_1.jpg" alt="Profile Image" class="rounded-circle profile-img">
  </div>

  <div class="container mt-5 pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8"> <!-- made wider -->
      <div class="card shadow-lg border-0">
        <div class="card-body text-center">
          <h3 class="card-title mb-4">My Profile</h3>
          <ul class="list-unstyled text-start fs-5">
            <li><i class="bi bi-person-fill text-primary"></i> <strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></li>
            <li><i class="bi bi-person text-primary"></i> <strong>Surname:</strong> <?= htmlspecialchars($user['surname']) ?></li>
            <li><i class="bi bi-person-badge text-primary"></i> <strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></li>
            <li><i class="bi bi-envelope text-primary"></i> <strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></li>
            <li><i class="bi bi-cake text-primary"></i> <strong>Age:</strong> <?= htmlspecialchars($user['Age']) ?></li>
            <li><i class="bi bi-calendar3 text-primary"></i> <strong>Registration Date:</strong> <?= htmlspecialchars($user['Registration_Date']) ?></li>
          </ul>
          <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
          <a href="index.php" class="btn btn-outline-secondary mt-3 ms-2">Return to Homepage</a>

          <?php if (count($reservations) > 0): ?>
          <div class="row justify-content-center mt-5">
            <div class="col-12">
              <div class="card shadow border-0">
                <div class="card-body">
                  <h4 class="card-title mb-4 text-center text-primary">My Reservations</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle table-striped">
                      <thead class="table-primary text-center">
                        <tr>
                          <th>Package</th>
                          <th>Reservation Date</th>
                          <th>Client Name</th>
                          <th>Client Surname</th>
                          <th>Age</th>
                          <th>Passport ID</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($reservations as $res): ?>
                        <tr class="text-center">
                          <td><?= htmlspecialchars($res['Name']) ?></td>
                          <td><?= htmlspecialchars($res['reservation_date']) ?></td>
                          <td><?= htmlspecialchars($res['client_name']) ?></td>
                          <td><?= htmlspecialchars($res['client_surname']) ?></td>
                          <td><?= htmlspecialchars($res['client_age']) ?></td>
                          <td><?= htmlspecialchars($res['passportID']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php else: ?>
          <div class="row justify-content-center mt-4">
            <div class="col-md-10 text-center">
              <p class="text-muted">You have no reservations yet.</p>
            </div>
          </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Modal Form -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editForm">
          <div class="modal-header">
            <h5 class="modal-title">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Surname</label>
              <input type="text" name="surname" class="form-control" value="<?= htmlspecialchars($user['surname']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Password (leave blank to keep current)</label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['Email']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Age</label>
              <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($user['Age']) ?>">
            </div>
            <div id="formMessage"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
    
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $('#editForm').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: 'update_profile.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
          let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
          $('#formMessage').html(`<div class="alert ${alertClass}">${response.message}</div>`);
          if (response.status === 'success') {
            setTimeout(() => location.reload(), 1500);
          }
        },
        error: function(){
          $('#formMessage').html('<div class="alert alert-danger">Error saving changes.</div>');
        }
      });
    });
  </script>
</body>
</html>
