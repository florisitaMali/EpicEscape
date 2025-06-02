<?php
include_once '../php/header.php';
include_once '../../connect-db.php';
include_once '../../config.php';

// Fetch all clients
$sql = "SELECT ID, Name, Surname, Username, Email, Age, Registration_Date FROM clients";
$result = $conn->query($sql);
$clients = [];
if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $clients[] = $row;
  }
}
?>

<link rel="stylesheet" href="../css/main.css">

<div class="main-content">
  <h3><i class="bi bi-people-fill me-2"></i>Client Management</h3>

  <!-- Search and filter section -->
  <div id="search-container" class="d-flex align-items-start gap-2 mb-3 flex-wrap" style="max-width: 1000px; position: relative;">
    <div style="flex: 2; position: relative;">
      <input type="text" id="search" class="form-control" placeholder="Search by name..." autocomplete="off">
      <div id="autocomplete" class="autocomplete-suggestions position-absolute w-100"></div>
    </div>
    <input type="date" id="date-from" class="form-control" style="flex: 1;" placeholder="From date">
    <input type="date" id="date-to" class="form-control" style="flex: 1;" placeholder="To date">
    <button id="reset-btn" class="btn btn-primary btn-sm">Reset</button>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle text-center" id="clients-table">
      <thead>
        <tr>
          <th>Initials</th>
          <th>Name</th>
          <th>Surname</th>
          <th>Username</th>
          <th>Email</th>
          <th>Age</th>
          <th>Registration Date</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <?php foreach ($clients as $row): ?>
          <tr>
            <td>
              <div class="avatar">
                <?= strtoupper(substr($row['Name'], 0, 1) . substr($row['Surname'], 0, 1)) ?>
              </div>
            </td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Surname']) ?></td>
            <td><?= htmlspecialchars($row['Username']) ?></td>
            <td><?= htmlspecialchars($row['Email']) ?></td>
            <td><?= htmlspecialchars($row['Age']) ?></td>
            <td>
              <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                <?= htmlspecialchars($row['Registration_Date']) ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const clients = <?php echo json_encode($clients); ?>;
  const searchInput = document.getElementById('search');
  const dateFrom = document.getElementById('date-from');
  const dateTo = document.getElementById('date-to');
  const tableBody = document.getElementById('table-body');
  const autocomplete = document.getElementById('autocomplete');
  const resetBtn = document.getElementById('reset-btn');

  function renderTable(data) {
    tableBody.innerHTML = '';
    data.forEach(client => {
      tableBody.innerHTML += `
        <tr>
          <td>
            <div class="avatar">
              ${client.Name[0].toUpperCase()}${client.Surname[0].toUpperCase()}
            </div>
          </td>
          <td>${client.Name}</td>
          <td>${client.Surname}</td>
          <td>${client.Username}</td>
          <td>${client.Email}</td>
          <td>${client.Age}</td>
          <td>
            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
              ${client.Registration_Date}
            </span>
          </td>
        </tr>
      `;
    });
  }

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    autocomplete.innerHTML = '';
    if (query.length === 0) return;

    const matches = clients.filter(client =>
      client.Name.toLowerCase().includes(query) ||
      client.Surname.toLowerCase().includes(query)
    );

    matches.slice(0, 8).forEach(client => {
      const div = document.createElement('div');
      div.textContent = `${client.Name} ${client.Surname}`;
      div.onclick = () => {
        searchInput.value = `${client.Name} ${client.Surname}`;
        autocomplete.innerHTML = '';
        filterTable(client.ID);
      };
      autocomplete.appendChild(div);
    });
  });

  function filterTable(id) {
    const client = clients.find(c => c.ID == id);
    if (!client) return;
    renderTable([client]);
  }

  function applyDateFilter() {
    const from = dateFrom.value;
    const to = dateTo.value;

    const filtered = clients.filter(client => {
      const regDate = client.Registration_Date;
      if (from && regDate < from) return false;
      if (to && regDate > to) return false;
      return true;
    });

    renderTable(filtered);
  }

  dateFrom.addEventListener('change', applyDateFilter);
  dateTo.addEventListener('change', applyDateFilter);

  resetBtn.addEventListener('click', () => {
    searchInput.value = '';
    dateFrom.value = '';
    dateTo.value = '';
    autocomplete.innerHTML = '';
    renderTable(clients);
  });

  renderTable(clients);
</script>

<?php
$conn->close();
include_once '../php/footer.php';
?>
