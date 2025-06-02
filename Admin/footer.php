<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<footer class="py-3" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
    <div class="container">
    <ul class="nav justify-content-center mb-3">
      <li class="nav-item">
        <a href="Admin.php" class="nav-link text-dark px-2">
          <i class="bi bi-house-door-fill me-1"></i>Home
        </a>
      </li>
      <li class="nav-item">
        <a href="travelPackages.php" class="nav-link text-dark px-2">
          <i class="bi bi-briefcase-fill me-1"></i>Travel Packages
        </a>
      </li>
      <li class="nav-item">
        <a href="Clients.php" class="nav-link text-dark px-2">
          <i class="bi bi-people-fill me-1"></i>Clients
        </a>
      </li>
      <li class="nav-item">
        <a href="Employees.php" class="nav-link text-dark px-2">
          <i class="bi bi-person-badge-fill me-1"></i>Employees
        </a>
      </li>
      <li class="nav-item">
        <a href="Statistics.php" class="nav-link text-dark px-2">
          <i class="bi bi-bar-chart-fill me-1"></i>Statistics
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link text-dark px-2 dropdown-toggle" href="#" id="footerReservationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-calendar-check-fill me-1"></i>Reservations
        </a>
        <ul class="dropdown-menu" aria-labelledby="footerReservationDropdown">
          <li><a class="dropdown-item" href="Reservations.php?type='Airplane Trip with Guide'">Airplane Trips with a Guide</a></li>
          <li><a class="dropdown-item" href="Reservations.php?type='All-Inclusive'">All-Inclusive Vacations</a></li>
          <li><a class="dropdown-item" href="Reservations.php?type='Individual Package'">Individual Packages</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="../html/Profile.php" class="nav-link text-dark px-2">
          <i class="bi bi-person-circle me-1"></i>Profile
        </a>
      </li>
      <li class="nav-item">
        <a href="../logout.php?token=<?php echo $_SESSION['Token']; ?>" class="nav-link text-dark px-2">
          <i class="bi bi-box-arrow-right me-1"></i>Logout
        </a>
      </li>
    </ul>
        <p class="text-center text-muted mb-0">© 2025 EpicEscape</p>
    </div>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous">
  </script>
</body>
</html>