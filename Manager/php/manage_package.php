<?php
include_once '../../config.php';
include_once '../../connect-db.php';

if (!isset($_SESSION['Token'])) {
    header("Location: ../login.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
 $id = intval($_GET['delete']);
 mysqli_query($conn, "DELETE FROM packages WHERE ID = $id");
 header("Location: manage_package.php");
 exit();
}

// Handle AJAX add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax_add'])) {
 $name = $_POST['name'];
 $type = $_POST['type'];
 $price = $_POST['price'];
 $date = $_POST['date'];
 $place = $_POST['place'];
 $description = $_POST['description'];
 $spots = $_POST['available_spots'];
 $endDate = $_POST['end-date'];
 $image = '';

 if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
 $uploadDir = '../../images/';
 $fileName = uniqid() . '_' . basename($_FILES['image_file']['name']);
 $targetFile = $uploadDir . $fileName;

 if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
 $image = $uploadDir . $fileName;
 }
 }
    $startDateTime = new DateTime($date);
    $endDateTime = new DateTime($endDate);
    $duration = $startDateTime->diff($endDateTime)->days;

 $sql = "INSERT INTO packages (Name, Type, Price, Date, Place, Description, available_spots, image_path, endDate, Duration) 
 VALUES ('$name', '$type', '$price', '$date', '$place', '$description', '$spots', '$image', '$endDate', $duration)";

 if (mysqli_query($conn, $sql)) {
 echo 'success';
 } else {
 echo 'error: ' . mysqli_error($conn);
 }
 exit();
} 


// Handle AJAX edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax_edit'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $place = $_POST['place'];
    $description = $_POST['description'];
    $spots = $_POST['available_spots'];
    $endDate = $_POST['end-date'];

    $startDateTime = new DateTime($date);
    $endDateTime = new DateTime($endDate);
    $duration = $startDateTime->diff($endDateTime)->days;

    $image = $_POST['image_path'] ?? ''; 

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $uploadDir = '../../images/';
        $fileName = uniqid() . '_' . basename($_FILES['image_file']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $image = $uploadDir . $fileName; 
        }
    }

    $sql = "UPDATE packages SET 
            Name='$name', Type='$type', Price='$price', Date='$date', Place='$place', 
            Description='$description', available_spots='$spots', endDate='$endDate', Duration=$duration";

    if (!empty($image)) {
        $sql .= ", image_path='$image'";
    }

    $sql .= " WHERE ID=$id";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($conn);
    }
    exit();
}

// Filtering
$where = [];
if (!empty($_GET['place'])) {
 $place = mysqli_real_escape_string($conn, $_GET['place']);
 $where[] = "Place LIKE '%$place%'";
}
if (!empty($_GET['type'])) {
 $type = mysqli_real_escape_string($conn, $_GET['type']);
 $where[] = "Type = '$type'";
}
if (!empty($_GET['max_price'])) {
 $max_price = floatval($_GET['max_price']);
 $where[] = "Price <= $max_price";
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$result = mysqli_query($conn, "SELECT * FROM packages $whereClause");

?>

<?php
include_once 'header.php';
?>

<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<div class="container" style="margin-top: 100px;">
 <div class="d-flex justify-content-between align-items-center mb-4">
 <h2 class="text-primary">Manage Travel Packages</h2>
 <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">➕ Add New Package</button>
 </div>

 <!-- FILTER FORM -->
 <form method="GET" class="row g-2 mb-4">
 <div class="col-md-3">
 <input type="text" id="place-filter" name="place" class="form-control" placeholder="Filter by Place" value="<?= htmlspecialchars($_GET['place'] ?? '') ?>">
 </div>
 <div class="col-md-3">
 <select name="type" class="form-control">
 <option value="">All Types</option>
 <option value="All-Inclusive" <?= (($_GET['type'] ?? '') === 'All-Inclusive') ? 'selected' : '' ?>>All-Inclusive</option>
 <option value="Airplane Trip with Guide" <?= (($_GET['type'] ?? '') === 'Airplane Trip with Guide') ? 'selected' : '' ?>>Airplane Trip with Guide</option>
 <option value="Individual Package" <?= (($_GET['type'] ?? '') === 'Individual Package') ? 'selected' : '' ?>>Individual Package</option>
 </select>
 </div>
 <div class="col-md-3">
 <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
 </div>
 <div class="col-md-3">
 <button class="btn btn-primary w-100">Apply Filters</button>
 </div>
 </form>

 <div class="row">
 <?php while ($row = mysqli_fetch_assoc($result)): ?>
 <div class="col-md-4 mb-4">
 <div class="card h-100">
 <img src="<?= !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : '../../images/default.jpg' ?>" 
 class="card-img-top" alt="Package Image" style="height: 200px; object-fit: cover;">
 <div class="card-body">
 <h5 class="card-title"><?= htmlspecialchars($row['Name']) ?></h5>
 <p><strong>Price:</strong> $<?= htmlspecialchars($row['Price']) ?></p>
 <p><strong>Type:</strong> <?= htmlspecialchars($row['Type']) ?></p>
 <p><?= nl2br(htmlspecialchars($row['Description'])) ?></p>
 <p><strong>Date:</strong> <?= htmlspecialchars($row['Date']) ?></p>
 <p><strong>Place:</strong> <?= htmlspecialchars($row['Place']) ?></p>
 <p><strong>Spots:</strong> <?= htmlspecialchars($row['available_spots']) ?></p>
 <p><strong>Duration:</strong> <?= htmlspecialchars($row['Duration']) ?> days</p>
 </div>
 <div class="card-footer d-flex justify-content-between">
 <button class="btn btn-warning btn-sm" onclick='openEditModal(<?= json_encode($row) ?>)'>Edit</button>
<button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['ID'] ?>)">Delete</button>
 </div>
 </div>
 </div>
 <?php endwhile; ?>
 </div>
</div>

<!-- ...everything above remains unchanged... -->

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
 <div class="modal-dialog modal-lg">
 <form id="addForm" class="modal-content" enctype="multipart/form-data" method="post">
 <div class="modal-header">
 <h5 class="modal-title">Add New Package</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div class="modal-body row g-3">
 <input type="hidden" name="ajax_add" value="1">
 <?php include 'package_form_fields.php'; ?>
 </div>
 <div class="modal-footer">
 <button type="submit" class="btn btn-success">Add Package</button>
 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
 </div>
 </form>
 </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
 <div class="modal-dialog modal-lg">
 <form id="editForm" class="modal-content" enctype="multipart/form-data" method="post">
 <div class="modal-header">
 <h5 class="modal-title">Edit Package</h5>
 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
 </div>
 <div class="modal-body row g-3">
 <input type="hidden" name="ajax_edit" value="1">
 <input type="hidden" name="id" id="edit-id">
 <input type="hidden" name="image_path" id="edit-image-path"> 
 <?php include 'package_form_fields.php'; ?>
 </div>
 <div class="modal-footer">
 <button type="submit" class="btn btn-primary">Save Changes</button>
 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
 </div>
 </form>
 </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete the selected package?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>

    </div>
  </div>
</div>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModalLabel">Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="feedbackMessage">
        <!-- Message goes here -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
let deletePackageId = null;

function confirmDelete(id) {
  deletePackageId = id;
  const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
  modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
  if (deletePackageId !== null) {
    window.location.href = 'manage_package.php?delete=' + deletePackageId;
  }
});
</script>

<script>
const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
const feedbackMessage = document.getElementById('feedbackMessage');
const feedbackTitle = document.getElementById('feedbackModalLabel');

function showFeedback(title, message, reloadOnClose = false) {
  feedbackTitle.textContent = title;
  feedbackMessage.textContent = message;
  feedbackModal.show();

  if (reloadOnClose) {
    const modalEl = document.getElementById('feedbackModal');
    modalEl.addEventListener('hidden.bs.modal', () => {
      location.reload();
    }, { once: true });
  }
}

document.getElementById('addForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('manage_package.php', {
    method: 'POST',
    body: formData
  }).then(res => res.text())
  .then(response => {
    if (response.trim() === 'success') {
      showFeedback("Success", "Package added successfully!", true);
    } else {
      showFeedback("Error", "Failed to add package.\n" + response);
    }
  });
});

document.getElementById('editForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('manage_package.php', {
    method: 'POST',
    body: formData
  }).then(res => res.text())
  .then(response => {
    if (response.trim() === 'success') {
      showFeedback("Success", "Package updated successfully!", true);
    } else {
      showFeedback("Error", "Failed to update package.\n" + response);
    }
  });
});

function openEditModal(data) {
  const form = document.getElementById('editForm');

  // Safely set values using form.elements
  form.elements['id'].value = data.ID;
  form.elements['name'].value = data.Name;
  form.elements['type'].value = data.Type;
  form.elements['price'].value = data.Price;
  form.elements['date'].value = data.Date;
  form.elements['place'].value = data.Place;
  form.elements['available_spots'].value = data.available_spots;
  form.elements['description'].value = data.Description;
  form.elements['end-date'].value = data.endDate;
  form.elements['image_path'].value = data.image_path;

  // Reset the file input (you can't pre-fill it)
  form.elements['image_file'].value = '';

  // Show the modal
  new bootstrap.Modal(document.getElementById('editModal')).show();
}


// Autocomplete for place filter
$(function() {
 $("#place-filter").autocomplete({
 source: function(request, response) {
 $.ajax({
 url: "place_suggestions.php",
 dataType: "json",
 data: {
 term: request.term
 },
 success: function(data) {
 response(data);
 }
 });
 },
 minLength: 1
 });
});
</script>

<!-- jQuery (must be loaded first) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- jQuery UI JS -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<?php include 'footer.php'; ?>
