$(document).ready(function() {
    $('.edit-btn').on('click', function() {
        var employeeId = $(this).data('id'); // Get employee ID from button
        $('#editRowIndex').val(employeeId); // Set the ID in the modal input

        console.log("Edit button clicked for employee ID:" + employeeId);
        // Fetch employee data using AJAX
        $.ajax({
            url: '../php/getEmployees.php?id=' + employeeId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log("Employee data fetched:", data);
                if (data === "error") {
                    showAlert("Employee not found.");
                    console.log("Error fetching employee data.");
                } else {
                    console.log("Response from server:", data);
                    $('#editName').val(data.name);
                    $('#editSurname').val(data.surname);
                    $('#editEmail').val(data.email);
                    $('#editAge').val(data.age);
                    $('#editUsername').val(data.username);
                    $('#editModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                showAlert("Error fetching employee data.");
                console.log("AJAX error:", error);
                console.log("Status:", status);
                console.log("XHR:", xhr);
            }
        });
    });

    console.log("Edit Employee button clicked");
    // Save changes on form submit
    $('#editEmployeeForm').on('submit', function(event) {
        event.preventDefault();
        console.log("Edit Employee form submitted");
        
        const id = $('#editRowIndex').val();
        const name = $('#editName').val();
        const surname = $('#editSurname').val();
        const username = $('#editUsername').val();
        const password = $('#editPassword').val(); // optional
        const email = $('#editEmail').val();
        const age = $('#editAge').val();

        console.log("Form data:", { id, name, surname, username, password, email, age });
        $.ajax({
            url: '../php/editEmployee.php',
            type: 'POST',
            data: {
                id: id,
                name: name,
                surname: surname,
                username: username,
                password: password,
                email: email,
                age: age
            },
            success: function(response) {
                console.log("Response from server:", response);
                if (response === "success") {
                    $('#editEmployeeModal').modal('hide');
                    location.reload(); 
                } else {
                    showAlert("Update failed: " + response);
                }
            },
            error: function(xhr, status, error) {
                showAlert("Error updating employee.");
            }
        });
    });

    function showAlert(message, title = "Alert") {
        $('#alertModalTitle').text(title);
        $('#alertModalBody').text(message);
        let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
        alertModal.show();
    }
});
