$(document).ready(function() {
    $('#EmployeeForm').on('submit', function(event) {
        event.preventDefault(); // Prevents default form submission

        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email').val();
        var age = $('#age').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var role = $('#role').val();
        var admin_pin = $('#admin_pin').val();
        var image = $('#profileImage')[0].files[0];

        console.log("Form Data:", {
            name: name,
            surname: surname,
            email: email,
            age: age,
            username: username,
            password: password,
            role: role,
            admin_pin: admin_pin,
            image: image
        });

        if (!name || !surname || !email || !age || !username || !password || !role || !image) {
            showAlert("Please fill in all fields, including profile image.");
            return;
        }

        var formData = new FormData();
        formData.append("name", name);
        formData.append("surname", surname);
        formData.append("email", email);
        formData.append("age", age);
        formData.append("username", username);
        formData.append("password", password);
        formData.append("role", role);
        formData.append("admin_pin", admin_pin);
        formData.append("profileImage", image);

        $.ajax({
            url: '../php/addEmployee.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response.trim() === "success") {
                    window.location.href = '../html/Employees.php';
                } else {
                    showAlert('Error adding employee: ' + response);
                }
            },
            error: function(xhr, status, error) {
                showAlert('An error occurred while adding the employee. Please try again.');
            }
        });
    });
});

function showAlert(message, title = "Alert") {
  $('#alertModalTitle').text(title);
  $('#alertModalBody').text(message);
  let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
  alertModal.show();
}
