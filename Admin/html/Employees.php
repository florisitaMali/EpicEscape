<?php
include_once '../header.php';
include_once '../../config.php';
?>

<!-- Title Header -->
<div class="container centered-section" style="background-color: #f8f9fa; border-radius: 10px;">
  <h2 class="mb-4 text-center" style="margin-top: 120px; padding: 20px;">
    <i class="bi bi-people-fill me-2"></i>Employee & Contract Management
  </h2>
</div>

<!-- Add Employee Section -->
<div class="row g-0 shadow" style="margin: 40px; border-radius: 15px; overflow: hidden;">
  <!-- Left Panel -->
  <div class="col-md-4 d-flex flex-column justify-content-center align-items-center text-white p-4"
       style="background: linear-gradient(135deg, #3b60ff, #00d4ff); min-height: 100%;">
    <i class="bi bi-person-plus fs-1 mb-3"></i>
    <h3 class="fw-bold mb-2">New Employee</h3>
    <p class="text-center">Add a team member to your system!</p>
    <a href="#employeeTableSection" class="btn btn-light text-dark mt-3 fw-bold shadow-sm px-4 py-2 rounded-pill">
      Go to Employee Table
    </a>
  </div>

  <!-- Add Employee Form -->
  <div class="col-md-8 bg-white p-5">
    <h4 class="mb-4 text-center fw-semibold">Add Employee</h4>
    <form id="EmployeeForm" class="row g-3 needs-validation" novalidate>
      <div class="invalid-feedback text-danger text-center w-100" id="inval-input" hidden>
        Please fulfill all required fields!
      </div>

      <div class="col-md-6">
        <input type="text" class="form-control" name="name" id="name" placeholder="First name" pattern="[A-Za-z]{3,}" required />
        <div class="invalid-feedback">At least 3 letters, letters only.</div>
      </div>

      <div class="col-md-6">
        <input type="text" class="form-control" name="surname" id="surname" placeholder="Last name" pattern="[A-Za-z]{3,}" required />
        <div class="invalid-feedback">At least 3 letters, letters only.</div>
      </div>

      <div class="col-md-6">
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" pattern="[A-Za-z0-9_]{8,}" required />
        <div class="invalid-feedback">At least 8 characters (letters, numbers, or underscore).</div>
      </div>

      <div class="col-md-6 position-relative">
        <input type="password" class="form-control pe-5" name="password" id="password" placeholder="Password" pattern=".{8,}" required />
        <i class="bi bi-eye-slash togglePassword" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
        <div class="invalid-feedback">Minimum 8 characters.</div>
      </div>

      <div class="col-md-6">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required />
        <div class="invalid-feedback">Enter a valid email.</div>
      </div>

      <div class="col-md-6">
        <input type="number" class="form-control" name="age" id="age" placeholder="Age" min="18" max="100" required />
        <div class="invalid-feedback">Enter a valid age (18+).</div>
      </div>

      <div class="col-md-6">
        <select class="form-select" name="role" id="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="Admin">Admin</option>
          <option value="Manager">Manager</option>
        </select>
        <div class="invalid-feedback">Please select a role.</div>
      </div>

      <div class="col-md-6 d-none" id="adminPinWrapper">
        <input type="password" class="form-control" id="admin_pin" name="admin_pin" placeholder="Admin PIN" pattern="\d{4}" required />
        <div class="invalid-feedback">Enter a 4-digit Admin PIN.</div>
      </div>

      <div class="col-md-12">
        <label for="profileImage" class="form-label">Profile Image</label>
        <input type="file" class="form-control" name="profileImage" id="profileImage" accept="image/*" required />
        <div class="invalid-feedback">Please upload a valid image.</div>
      </div>

      <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary px-4 shadow-sm rounded-pill">Add Employee</button>
      </div>
    </form>
  </div>
</div>

<!-- Employee Card Swiper Section -->
<div class="profile py-5" style="background:rgb(234, 234, 234); ">
  <div id="employeeTableSection" class="container">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php include_once '../php/getEmployees.php'; ?>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editEmployeeForm" class="row g-3 needs-validation" novalidate>
          <input type="hidden" id="editRowIndex" />

          <div class="col-md-4">
            <label for="editName" class="form-label"><i class="bi bi-person-fill me-1"></i>First Name</label>
            <input type="text" class="form-control" id="editName" required pattern="[A-Za-z]{3,}">
            <div class="invalid-feedback">Name must be at least 3 letters and contain only letters.</div>
          </div>

          <div class="col-md-4">
            <label for="editSurname" class="form-label"><i class="bi bi-person-fill me-1"></i>Last Name</label>
            <input type="text" class="form-control" id="editSurname" required pattern="[A-Za-z]{3,}">
            <div class="invalid-feedback">Surname must be at least 3 letters and contain only letters.</div>
          </div>

          <div class="col-md-4">
            <label for="editEmail" class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email</label>
            <input type="email" class="form-control" id="editEmail" required>
            <div class="invalid-feedback">Please provide a valid email.</div>
          </div>

          <div class="col-md-4">
            <label for="editAge" class="form-label"><i class="bi bi-calendar2-week-fill me-1"></i>Age</label>
            <input type="number" class="form-control" id="editAge" min="18" max="100" required>
            <div class="invalid-feedback">Age must be between 18 and 100.</div>
          </div>

          <div class="col-md-4">
            <label for="editUsername" class="form-label"><i class="bi bi-person-badge-fill me-1"></i>Username</label>
            <input type="text" class="form-control" id="editUsername" minlength="8" required>
            <div class="invalid-feedback">Username must be at least 8 characters.</div>
          </div>

          <div class="col-md-4 position-relative">
            <label for="editPassword" class="form-label"><i class="bi bi-lock-fill me-1"></i>Password</label>
            <input type="password" class="form-control" id="editPassword" pattern="^$|.{8,}" title="Leave blank or enter at least 8 characters">
            <div class="invalid-feedback">Password must be at least 8 characters or left blank.</div>
          </div>

          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle me-1"></i>Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteForm" method="POST" action="../php/deleteEmployee.php">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Please provide your password to confirm deletion of this employee.</p>
          <input type="hidden" name="employee_id" id="deleteEmployeeId">
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Your Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            <div class="invalid-feedback">Password is required to confirm deletion.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalTitle">Alert</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="alertModalBody">
        <!-- message will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="../js/addEmployee.js"></script>
<script src="../js/editEmployee.js"></script>
<script src="../js/deleteEmployee.js"></script>

<script>
$(document).ready(function () {
  const form = document.getElementById('EmployeeForm');
  const $form = $(form);
  const $submitButton = $form.find('button[type="submit"]');

  // Real-time validation: on input, blur, change
  $form.find('input, select').on('input blur change', function () {
    // Handle conditional validation for admin_pin
    if (this.id === 'role') {
      if (this.value === 'Admin') {
        $('#adminPinWrapper').removeClass('d-none');
        $('#admin_pin').attr('required', true);
      } else {
        $('#adminPinWrapper').addClass('d-none');
        $('#admin_pin').removeAttr('required').removeClass('is-valid is-invalid');
      }
    }

    // Handle field validation
    this.classList.remove('is-valid', 'is-invalid');

    if (this.checkValidity()) {
      this.classList.add('is-valid');
    } else {
      this.classList.add('is-invalid');
    }

    checkFormValidity();
  });

  // Toggle password visibility
  $('.togglePassword').on('click', function () {
    const $password = $('#password');
    const type = $password.attr('type') === 'password' ? 'text' : 'password';
    $password.attr('type', type);
    $(this).toggleClass('bi-eye-slash bi-eye');
  });

  // Disable submit if form is not valid
  form.addEventListener('submit', function (e) {
    if (!form.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  // Function to check entire form validity and toggle submit button
  function checkFormValidity() {
    const allValid = [...form.elements].every(input => {
      if (input.required && !input.closest('#adminPinWrapper')?.classList.contains('d-none')) {
        return input.checkValidity();
      }
      // if not required, or inside a hidden admin pin, ignore it
      return !input.required || input.closest('#adminPinWrapper')?.classList.contains('d-none');
    });

    $submitButton.prop('disabled', !allValid);
  }

  // Initial disable on page load
  $submitButton.prop('disabled', true);

  $(document).ready(function () {
    const editForm = $('#editEmployeeForm');

    // Instant validation on input/blur
    editForm.find('input, select').on('input blur change', function () {
      this.classList.remove('is-invalid');
      this.classList.remove('is-valid');

      if (this.checkValidity()) {
        this.classList.add('is-valid');
      } else {
        this.classList.add('is-invalid');
      }
    });

    // Special rule: password can be blank or >= 8 characters
    $('#editPassword').on('input', function () {
      const value = $(this).val();
      if (value.length === 0 || value.length >= 8) {
        this.setCustomValidity('');
      } else {
        this.setCustomValidity('Password must be blank or at least 8 characters.');
      }

      this.classList.remove('is-invalid', 'is-valid');
      if (this.checkValidity()) {
        this.classList.add('is-valid');
      } else {
        this.classList.add('is-invalid');
      }
    });

    // Prevent submit if form is invalid
    editForm.on('submit', function (e) {
      if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      this.classList.add('was-validated');
    });

    // Reset validation when modal opens
    $('#editModal').on('shown.bs.modal', function () {
      const form = document.getElementById('editEmployeeForm');
      form.classList.remove('was-validated');
      $(form).find('input, select').removeClass('is-valid is-invalid');
    });
  });


new Swiper(".mySwiper", {
  slidesPerView: 3, // Show three cards at once
  centeredSlides: true,
  loop: false, // Ensure it stops at the last slide
  spaceBetween: 30,
  slideToClickedSlide: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  speed: 600,
  breakpoints: {
    640: { slidesPerView: 1, centeredSlides: false },
    768: { slidesPerView: 2, centeredSlides: false },
    1024: { slidesPerView: 3, centeredSlides: true }
  }
});
  document.querySelectorAll('.employee-card').forEach(card => {
    card.addEventListener('click', () => {
      card.classList.toggle('expanded');
    });
  });

  const toastElement = new bootstrap.Toast(document.getElementById("toastMessage"));
  const toastBody = document.querySelector(".toast-body");

  function showToast(message) {
    toastBody.textContent = message;
    toastElement.show();
  }
});
</script>

<?php include_once '../footer.php'; ?>