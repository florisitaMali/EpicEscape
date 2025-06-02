<?php
  include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="images/logo.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EpicEscape - Sign In</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
</head>
<body>
  <div class="form-container" id="sign-in-form">
    <div>
      <h2 class="text-center"
        style="font-family: Georgia, 'Times New Roman', Times, serif; font-weight: bold; margin-bottom: 2rem;">
        <img src="images/logo.png" alt="Car Logo" height="50" width="120"> Car Dealership
      </h2>
      <hr>
      <h3 class="text-center"
        style="font-family: Georgia, 'Times New Roman', Times, serif; margin-top: -1rem; margin-bottom: 1rem;">Sign In
      </h3>
      <div id="sign-in-wrong-data" class="alert alert-danger" role="alert" style="display: none;">
        Username or Password is incorrect!
      </div>      

    </div>
    <form id="sign-in-form"> 
      <!-- Username Field -->
      <div class="mb-3">
        <label for="sign-in-username" class="form-label">Username *</label>
        <input type="text" class="form-control" name="username" id="sign-in-username" placeholder="Enter your username or password"
          required>
      </div>

      <!-- Password Field -->
      <div class="mb-3" style="position: relative;">
        <label for="sign-in-password" class="form-label">Password *</label>
        <input type="password" class="form-control" name="password" id="sign-in-password"
          placeholder="Enter your password" style="padding-right: 2.5rem;" required>
        <i class="togglePassword"
          style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 1.2rem;">
          👁️
        </i>
      </div>

      <!-- Submit Button -->
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Sign In</button>
      </div>
    </form>

  </div>
  
  <!-- JavaScript for Toggle Functionality -->
  <script>
    const togglePasswordIcons = document.querySelectorAll(".togglePassword");

    togglePasswordIcons.forEach(icon => {
      icon.addEventListener("click", () => {
        const inputField = icon.previousElementSibling;

        const type = inputField.getAttribute("type") === "password" ? "text" : "password";
        inputField.setAttribute("type", type);

        icon.textContent = type === "password" ? "👁️" : "🙈";
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/login.js"></script>

<div >
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>