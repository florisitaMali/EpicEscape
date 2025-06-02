<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epicescape";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE reviews SET Confirmed = 1 WHERE ReviewID = $id");
    $_SESSION['message'] = "Review #$id has been approved.";
    $_SESSION['msg_type'] = "success";
}
if (isset($_GET['disapprove'])) {
    $id = intval($_GET['disapprove']);
    $conn->query("UPDATE reviews SET Confirmed = 0 WHERE ReviewID = $id");
    $_SESSION['message'] = "Review #$id has been disapproved.";
    $_SESSION['msg_type'] = "warning";
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM reviews WHERE ReviewID = $id");
    $_SESSION['message'] = "Review #$id has been deleted.";
    $_SESSION['msg_type'] = "danger";
}

$result = $conn->query("SELECT * FROM reviews ORDER BY ReviewID DESC");
?>

<?php include '../php/header.php'; ?>

<!-- Page Wrapper -->
<div class="container my-5 d-flex justify-content-center" >
    <div class="page-content text-center w-100" style="">

        <!-- Notification Alert -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['msg_type'] ?>" id="notification">
                <?= $_SESSION['message'] ?>
                <button class="close-btn float-end btn btn-sm" onclick="dismissNotification()">×</button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['msg_type']); ?>
        <?php endif; ?>

        <!-- Header -->
        <h2 class="mb-4" style="margin-top: 50px">Manage Reviews ⭐️⭐️⭐️⭐️⭐️</h2>

        <!-- Reviews Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Review ID</th>
                        <th>Package ID</th>
                        <th>Review</th>
                        <th>Confirmed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ReviewID'] ?></td>
                        <td><?= $row['packageID'] ?></td>
                        <td><?= htmlspecialchars($row['Review']) ?></td>
                        <td><?= $row['Confirmed'] ? "Yes" : "No" ?></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <?php if (!$row['Confirmed']): ?>
                                    <a class="btn btn-success btn-sm" href="?approve=<?= $row['ReviewID'] ?>" onclick="return confirm('Approve this review?')">✅ Approve</a>
                                <?php else: ?>
                                    <a class="btn btn-warning btn-sm" href="?disapprove=<?= $row['ReviewID'] ?>" onclick="return confirm('Disapprove this review?')">⚠️ Disapprove</a>
                                <?php endif; ?>
                                <a class="btn btn-danger btn-sm" href="?delete=<?= $row['ReviewID'] ?>" onclick="return confirm('Delete this review?')">🗑️ Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Notification Script -->
<script>
    function dismissNotification() {
        const alertBox = document.getElementById('notification');
        if (alertBox) {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500);
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.getElementById('notification');
        if (alertBox) {
            setTimeout(dismissNotification, 3000);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<?php include '../php/footer.php'; ?>
