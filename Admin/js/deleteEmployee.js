$(document).ready(function () {
  // Handle delete button click
  $('.delete-btn').on('click', function () {
    const employeeId = $(this).data('id');
    $('#deleteEmployeeId').val(employeeId);
    console.log('Employee ID:', employeeId);
    $('#confirmPassword').val('');
    $('#confirmPassword').removeClass('is-invalid is-valid');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
  });

  // Client-side validation for delete form
  $('#deleteForm').on('submit', function (e) {
    const passwordField = $('#confirmPassword')[0];
    console.log('Password field:', passwordField);
    if (!passwordField.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
      passwordField.classList.add('is-invalid');
    } else {
      passwordField.classList.remove('is-invalid');
    }
  });
});
