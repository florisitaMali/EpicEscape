$(document).on("submit", "#sign-in-form", function (event) {
    event.preventDefault();
    $("#sign-in-wrong-data").hide(); 

    const username = $("#sign-in-username").val().trim();
    const password = $("#sign-in-password").val().trim();

    if( username === "" || password === "") {
      $("#sign-in-wrong-data").text("Please fill in all fields.").show();   
        return; 
    }

    // Validate username and password   
    if (username.length < 3 || username.length > 20) {
      $("#sign-in-wrong-data").text("Username must be between 3 and 20 characters.").show();   
      return; 
    }
    if (password.length < 6 || password.length > 20) {
      $("#sign-in-wrong-data").text("Password must be between 6 and 20 characters.").show();   
      return; 
    }

    // Send AJAX request
    $.ajax({
      url: "php/AMlogin.php",
      method: "POST",
      data: { username: username, password: password},
      success: function (response) {
        console.log("Response from server:", response);
        switch (response) {

          case "admin":
            window.location.href = "Admin/html/Admin.php";
            break;
          case "manager":
            window.location.href = "Manager/html/Manager.php";
            break;
          case "error":
            $("#sign-in-wrong-data").show();
            break;
          case "allow-attempt":
            $("#sign-in-wrong-data").text("Too many failed attempts. Please try again later.").show();
            $("#sign-in-username, #sign-in-password").prop("disabled", true);
            setTimeout(function () {
              $("#sign-in-username, #sign-in-password").prop("disabled", false);
              $("#sign-in-wrong-data").hide();
            }, 60000);
            break;
          default:
            console.error("Unexpected response:", response);
        }
      }
    });
  });