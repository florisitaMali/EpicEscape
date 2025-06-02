<?php
// Include the config file
include_once '../../config.php';

if(!isset($_SESSION['Token']) || $_SESSION['Role'] != 'Manager') {
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
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <!-- Custom CSS -->
  <link href="../css/main.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
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
        <a class="nav-link active" href="../html/Manager.php"><i class="bi bi-house-door-fill me-1"></i>Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../php/manage_clients.php"><i class="bi bi-people-fill me-1"></i>Manage Clients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/manage_package.php"><i class="bi bi-box-seam me-1"></i>Manage Packages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../php/manage_reviews.php"><i class="bi bi-box-seam me-1"></i>Manage Reviews</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="reservationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-calendar-check-fill me-1"></i>Manage Reservations
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
          <a class="nav-link" href="../php/logout.php?token=<?php echo $_SESSION['Token']; ?>">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
