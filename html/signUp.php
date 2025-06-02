<?php
    if(isset($_SESSION['ID'])){
      header("Location: ../client");
    }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <link rel="icon" href="../images/logo.png" type="image/x-icon">
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
      gap: 1rem; /*space between columns*/
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="form-container-sign-up" id="sign-up-form">
    <h2 class="text-center">
        <img src="../images/logo.png" alt="Car Logo" height="50" width="120"> EpicEscape
    </h2>
    <hr>
    <h3 class="text-center">Sign Up</h3>
    <div id="sign-up-wrong-data" class="alert alert-danger" role="alert" style="display: none;">
        A client with this username already exists.
    </div>

    <form>
        <!-- Name and Surname -->
        <div class="row mb-3">
            <div class="col">
                <label for="sign-up-name" class="form-label">Name *</label>
                <input type="text" class="form-control" name="signUpName" id="sign-up-name" placeholder="Enter your name" required>
            </div>
            <div class="col">
                <label for="sign-up-surname" class="form-label">Surname *</label>
                <input type="text" class="form-control" name="signUpSurname" id="sign-up-surname" placeholder="Enter your surname" required>
            </div>
        </div>

        <!-- Username and Email -->
        <div class="row mb-3">
            <div class="col">
                <label for="sign-up-username" class="form-label">Username *</label>
                <input type="text" class="form-control" name="signUpUsername" id="sign-up-username" placeholder="Enter your username" required>
            </div>
            <div class="col">
                <label for="sign-up-email" class="form-label">Email *</label>
                <input type="email" class="form-control" name="signUpEmail" id="sign-up-email" placeholder="Enter your email" required>
            </div>
        </div>

        <!-- Age -->
        <div class="mb-3">
            <label for="sign-up-age" class="form-label">Age *</label>
            <input type="number" class="form-control" name="signUpAge" id="sign-up-age" placeholder="Enter your age" required>
        </div>

        <!-- Password and Confirm Password -->
        <div class="row mb-3">
            <div class="col">
                <label for="sign-up-password" class="form-label">Password *</label>
                <div class="position-relative">
                    <input type="password" class="form-control" name="signUpPassword" id="sign-up-password" placeholder="Enter your password" required>
                </div>
            </div>
            <div class="col">
                <label for="sign-up-confirm-password" class="form-label">Confirm Password *</label>
                <div class="position-relative">
                    <input type="password" class="form-control" name="signUpConfirmPassword" id="sign-up-confirm-password" placeholder="Confirm your password" required>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
    </form>
</div>

<script>
  $(document).on("submit", "#sign-up-form", function(event) {
    event.preventDefault();

    const signUpName = $("#sign-up-name").val().trim();
    const signUpSurname = $("#sign-up-surname").val().trim();
    const signUpUsername = $("#sign-up-username").val().trim();
    const signUpEmail = $("#sign-up-email").val().trim();
    const signUpAge = $("#sign-up-age").val().trim();
    const signUpPassword = $("#sign-up-password").val().trim();
    const signUpConfirmPassword = $("#sign-up-confirm-password").val().trim();

    console.log({ name: signUpName, surname: signUpSurname, username: signUpUsername, email: signUpEmail, age: signUpAge, password: signUpPassword, confirmPassword: signUpConfirmPassword });

    $("#sign-up-wrong-data").hide();

    $.ajax({
        url: "../php/signUp.php",
        method: "POST",
        data: {
            signUpName: signUpName,
            signUpSurname: signUpSurname,
            signUpUsername: signUpUsername,
            signUpEmail: signUpEmail,
            signUpAge: signUpAge,
            signUpPassword: signUpPassword,
            signUpConfirmPassword: signUpConfirmPassword
        },
        success: function(response) {
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
                case "exist":
                    $("#sign-up-wrong-data").text("This username or email already exists.").show();
                    break;
                case "error":
                    $("#sign-up-wrong-data").text("Please make sure the password and confirm password match.").show();
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