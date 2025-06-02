<?php

include_once '../../connect-db.php';
include_once '../header.php';
include_once '../../config.php';

$user_id = $_SESSION['ID'];

$query = "SELECT profile_image_path, name, surname, username, email, age, registration_date, role FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>

<body class="bg-light">
<div class="container mt-5 profile-page">
    <div class="card shadow rounded-4 overflow-hidden" style="margin-top: 100px; margin-bottom: 100px;">
        
        <!-- Card Header with image -->
        <div class="card-header">
            <div class="profile-image">
                <img src="<?= htmlspecialchars($user['profile_image_path']) ?>" alt="Profile Image">
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body mt-5">
            <h2 class="mb-4 text-center">My Profile</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <p><strong>👤 Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>👤 Surname:</strong> <?= htmlspecialchars($user['surname']) ?></p>
                    <p><strong>👥 Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    <p><strong>📧 Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>🎂 Age:</strong> <?= htmlspecialchars($user['age']) ?></p>
                    <p><strong>📅 Registration Date:</strong> <?= htmlspecialchars($user['registration_date']) ?></p>
                    <p><strong>🛡️ Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
                    <div class="text-center">
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>

</div>


    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="editProfileForm" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
              </div>
              <div class="mb-3">
                  <label>Surname</label>
                  <input type="text" name="surname" class="form-control" value="<?= htmlspecialchars($user['surname']) ?>" required>
              </div>
              <div class="mb-3">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
              </div>
              <div class="mb-3">
                 <label>New Password (leave blank to keep current)</label>
                 <input type="password" name="password" class="form-control" placeholder="••••••••">
                </div>

              <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
              </div>
              <div class="mb-3">
                  <label>Age</label>
                  <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($user['age']) ?>" required>
              </div>
              <div class="mb-3">
                  <label>Role</label>
                  <input type="text" name="role" class="form-control bg-light" value="<?= htmlspecialchars($user['role']) ?>" readonly>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="feedbackModalLabel">Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body" id="feedbackMessage">
            <!-- Message goes here -->
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>

        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    const feedbackMessage = document.getElementById('feedbackMessage');
    const feedbackTitle = document.getElementById('feedbackModalLabel');

    function showFeedback(title, message, reloadOnClose = false) {
    feedbackTitle.textContent = title;
    feedbackMessage.textContent = message;
    feedbackModal.show();

    if (reloadOnClose) {
        const modalEl = document.getElementById('feedbackModal');
        modalEl.addEventListener('hidden.bs.modal', () => {
        location.reload();
        }, { once: true });
    }
    }

    $('#editProfileForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '../php/update_profile.php',
        type: 'POST',
        data: $(this).serialize(), 
        dataType: 'json',
        success: function(response) {
        if (response.status === "success") {
            showFeedback("Success", "✅ " + response.message, true);
        } else {
            showFeedback("Error", "❌ " + response.message);
        }
        },
        error: function(xhr, status, error) {
        console.error("XHR:", xhr.responseText);
        console.error("Status:", status);
        console.error("Error:", error);
        showFeedback("Error", "❌ Failed to send request.");
        }
    });
    });
    </script>

    <?php include '../footer.php'; ?>
    </body>
</html>
