<!-- Footer -->
<footer class="py-3 mt-5 bg-white border-top">
  <div class="container">
    <ul class="nav justify-content-center mb-3">
    <li class="nav-item">
        <a class="nav-link text-dark px-3" href="../html/Manager.php"><i class="bi bi-house-door-fill me-1"></i>Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../php/manage_clients.php"><i class="bi bi-people-fill me-1"></i>Manage Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/manage_package.php"><i class="bi bi-box-seam me-1"></i>Manage Packages</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="reservationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-calendar-check-fill me-1"></i> Manage Reservations
          </a>
          <ul class="dropdown-menu" aria-labelledby="reservationDropdown">
            <li><a class="dropdown-item" href="../php/reservations.php?type='Airplane Trip with Guide'">Airplane Trips with a Guide</a></li>
            <li><a class="dropdown-item" href="../php/reservations.php?type='All-Inclusive'">All-Inclusive Vacations</a></li>
            <li><a class="dropdown-item" href="../php/reservations.php?type='Individual Package'">Individual Packages</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/profile.php"><i class="bi bi-person-circle me-1"></i>Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="#"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </li>
    </ul>
    <p class="text-center text-muted mb-0">© 2025 EpicEscape</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous">
</script>

</body>
</html>
