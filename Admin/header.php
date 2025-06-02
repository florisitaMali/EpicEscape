<?php
include_once '../../config.php';

if(!isset($_SESSION['Token']) || $_SESSION['Role'] != 'Admin') {
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EpicEscape</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- In <head> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

  <!-- Before </body> -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="../css/statistics.css">

</head>
<body>

<!-- Navbar with icons -->
<nav class="navbar navbar-expand-lg shadow-sm py-3 fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="../../images/horizontal_logo.png" alt="EpicEscape Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="Admin.php"><i class="bi bi-house-door-fill me-1"></i>Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="travelPackages.php"><i class="bi bi-briefcase-fill me-1"></i>Travel Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Clients.php"><i class="bi bi-people-fill me-1"></i>Clients</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="Employees.php">
          <i class="bi bi-person-badge-fill me-1"></i> Employees
        </a>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="Statistics.php"><i class="bi bi-bar-chart-fill me-1"></i>Statistics</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="reservationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-calendar-check-fill me-1"></i>Reservations
          </a>
          <ul class="dropdown-menu" aria-labelledby="reservationDropdown">
            <li><a class="dropdown-item" href="Reservations.php?type='Airplane Trip with Guide'">Airplane Trips with a Guide</a></li>
            <li><a class="dropdown-item" href="Reservations.php?type='All-Inclusive'">All-Inclusive Vacations</a></li>
            <li><a class="dropdown-item" href="Reservations.php?type='Individual Package'">Individual Packages</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../html/Profile.php"><i class="bi bi-person-circle me-1"></i>Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php?token=<?php echo $_SESSION['Token']; ?>">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
