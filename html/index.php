<!DOCTYPE html>
<html lang="en">
  <?php
    if(isset($_SESSION['ID'])){
      header("Location: ../client");
    }
    ?>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="images/logo.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EpicEscape - Sign In</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('../images/bc.png') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      width: 100%;
      max-width: 400px;
    }

    .form-container h2 img {
      width: 50px;
      margin-right: 10px;
      vertical-align: middle;
    }

    .form-container-sign-up{
      width: 100%;
      max-width: 800px;
      margin: 10px;
      padding: 30px;
      border-radius: 10px;
      vertical-align: middle;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      background-color: rgba(255, 255, 255, 0.9);
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem; /space between columns/
    }

    .col {
      flex: 1; /* Ensures equal width for columns */
    }

    .mb-3 {
      margin-bottom: 1rem; /* Standard spacing between form elements */
    }

    .align-items-center {
      display: flex;
      align-items: center;
    }

    label {
      margin-right: 0.5rem; /* Adds spacing between label and input */
    }
  </style>
</head>
<body>
  <div class="form-container">
    <div>
      <h2 class="text-center"
        style="font-family: Georgia, 'Times New Roman', Times, serif; font-weight: bold; margin-bottom: 2rem;">
        <img src="../images/logo.png" alt="Car Logo" height="50" width="120"> EpicEscape
      </h2>
      <hr>
      <h3 class="text-center"
        style="font-family: Georgia, 'Times New Roman', Times, serif; margin-top: -1rem; margin-bottom: 1rem;">Sign In
      </h3>
      <div id="sign-in-wrong-data" class="alert alert-danger" role="alert" style="display: none;">
        Username or Password is incorrect!
      </div>      

    </div>
    <form id="sign-in-form"> <!-- Add id for the form -->
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
          👁
        </i>
      </div>
      <!-- Submit Button -->
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Sign In</button>
      </div>

      <div class="mb-3">
        <label> Don't you have an account? <a href="signUp.php">Sign Up</a></label>
      </div>
    </form>

  </div>
  
  <!-- JavaScript for Toggle Functionality -->
  <script>
    // Add functionality for all toggle password icons
    const togglePasswordIcons = document.querySelectorAll(".togglePassword");

    togglePasswordIcons.forEach(icon => {
      icon.addEventListener("click", () => {
        // Find the corresponding input field (previous sibling)
        const inputField = icon.previousElementSibling;

        // Toggle the input type between password and text
        const type = inputField.getAttribute("type") === "password" ? "text" : "password";
        inputField.setAttribute("type", type);

        // Change the icon for visual feedback
        icon.textContent = type === "password" ? "👁" : "🙈";
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).on("submit", "#sign-in-form", function (event) {
      event.preventDefault();

      $("#sign-in-wrong-data").hide(); 

      const username = $("#sign-in-username").val().trim();
      const password = $("#sign-in-password").val().trim();
      console.log("Username:", username);
      console.log("Password:", password);

      $.ajax({
        url: "../php/signIn.php",
        method: "POST",
        data: { username: username, password: password },
        success: function (response) {
          console.log("Response from server:", response.trim());

          switch(response.trim()) {
            case "success":
              $.ajax({
                url: "../php/getSessionRedirection.php", 
                method: "GET",
                success: function(redirectResponse) {
                  const redirectionUrl = redirectResponse.trim();
                  if (redirectionUrl !== "") {
                    window.location.href = "../client/" + redirectionUrl; 
                  } else {
                    window.location.href = "../client";
                  }
                }
              });
              break;
            case "error":
              $("#sign-in-wrong-data").show();
              break;

            case "notfound":
              $("#sign-in-wrong-data").text("Username or password is incorrect. Try it again.").show();
              break;

            default:
              console.error("Unexpected response:", response);
          }
        }
      });
  });
</script>

<div >
  <!-- JQuery CND -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
