<?php
require_once '../../config.php';
include_once '../../connect-db.php';
include_once '../header.php';

// Fetch bookings
$sql = "SELECT p.Name AS package_name, 
            p.Date AS travel_date, 
            p.Duration, 
            p.Price, 
            r.reservation_date, 
            r.client_email, 
            r.client_name, 
            r.client_surname 
        FROM `reservations` r 
        JOIN `packages` p ON r.PackageID = p.ID";

if(isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type != '') {
        $sql .= " WHERE p.Type = $type";
    }
}

$result = $conn->query($sql);
$all_bookings = [];

while ($row = $result->fetch_assoc()) {
    $all_bookings[] = $row;
}
?>

<link rel="stylesheet" href="../css/client-management.css">

<div class="container-fluid mt-4" style="padding: 0 20px;">
    <h2 class="text-center mt-5 mb-4" style="padding-top: 50px; margin-top: 150px; margin-bottom:20px;">Manage Reservations</h2>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3 filter-sidebar" style="margin-bottom: 20px; background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
            <h5 class="mb-3"><i class="bi bi-funnel-fill"></i> Filters</h5>
            <form id="filterForm">
                <div class="mb-3">
                    <label for="searchInput" class="form-label">Search by Name</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Enter name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration (days)</label>
                    <input type="range" class="form-range" id="durationRange" min="1" max="30">
                    <span id="durationValue">15</span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price (€)</label>
                    <select id="priceSelect" class="form-select">
                        <option value="">Any</option>
                        <option value="lt500">Less than €500</option>
                        <option value="500to1000">€500 - €1000</option>
                        <option value="gt1000">More than €1000</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Travel Date</label>
                    <input type="date" class="form-control" id="travelDate">
                </div>
                <div class="mb-3">
                    <label class="form-label">Reservation Date</label>
                    <input type="date" class="form-control" id="reservationDate">
                </div>
                <button type="reset" class="btn btn-outline-primary w-100 mt-2" id="resetBtn">Reset Filters</button>
            </form>
        </div>

        <!-- Table Content -->
        <div class="col-md-9" >
            <div class="d-flex justify-content-end align-items-center mb-3">
                <label for="sortSelect" class="me-2 fw-semibold">Sort by:</label>
                <select id="sortSelect" class="form-select w-auto">
                    <option value="">Default</option>
                    <option value="client_name">Client Name (A-Z)</option>
                    <option value="package_name">Destination (A-Z)</option>
                    <option value="duration">Duration (Low to High)</option>
                    <option value="price">Price (Low to High)</option>
                    <option value="reservation_date">Reservation Date (Newest First)</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="clientTable">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Travel Date</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Reservation Date</th>
                            <th>Client Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_bookings as $index => $booking): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($booking['package_name']) ?></td>
                                <td><?= date('Y-m-d', strtotime($booking['travel_date'])) ?></td>
                                <td><?= htmlspecialchars($booking['Duration']) ?></td>
                                <td><?= number_format($booking['Price'], 2) ?></td>
                                <td><?= date('Y-m-d', strtotime($booking['reservation_date'])) ?></td>
                                <td><?= htmlspecialchars($booking['client_name']) ?></td>
                                <td><?= htmlspecialchars($booking['client_surname']) ?></td>
                                <td><?= htmlspecialchars($booking['client_email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="alert alert-warning text-center d-none" id="noResults">No results found.</div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    // Main filtering function
    function filterTable() {
        // 🔍 Get input values from filter fields
        const search = $('#searchInput').val().toLowerCase(); // Free text search
        const duration = parseInt($('#durationRange').val(), 10); // Max duration from range slider
        const priceFilter = $('#priceSelect').val(); // Selected price range option
        const travelDate = $('#travelDate').val(); // Exact travel date filter
        const reservationDate = $('#reservationDate').val(); // Exact reservation date filter

        let countVisible = 0; // To keep track of visible rows

        // Loop through each table row (client data)
        $('#clientTable tbody tr').each(function () {
            const row = $(this); // Current row reference

            // 🧾 Extract column data from the row
            const packageName = row.find('td:nth-child(2)').text().toLowerCase();
            const travel = row.find('td:nth-child(3)').text();
            const dur = parseInt(row.find('td:nth-child(4)').text(), 10);

            // 💵 Clean price text (remove commas or symbols), then convert to number
            const priceText = row.find('td:nth-child(5)').text().replace(/[^\d.]/g, '');
            const price = parseFloat(priceText);

            const reserve = row.find('td:nth-child(6)').text();
            const name = row.find('td:nth-child(7)').text().toLowerCase();
            const surname = row.find('td:nth-child(8)').text().toLowerCase();
            const email = row.find('td:nth-child(9)').text().toLowerCase();

            // ✅ Assume row should be shown unless a filter fails
            let show = true;

            // 🔍 Free text search: match if any field includes the search string
            const fullText = `${packageName} ${name} ${surname} ${email}`;
            if (search && !fullText.includes(search)) {
                show = false;
            }

            // ⏱ Duration filter: hide if duration is more than allowed
            if (!isNaN(duration) && dur > duration) {
                show = false;
            }

            // 💰 Price range filter
            if (!isNaN(price)) {
                if (priceFilter === "lt500" && price >= 500) {
                    show = false;
                }
                if (priceFilter === "500to1000" && (price < 500 || price > 1000)) {
                    show = false;
                }
                if (priceFilter === "gt1000" && price <= 1000) {
                    show = false;
                }
            }

            // 📅 Travel date filter (exact match)
            if (travelDate && travel !== travelDate) {
                show = false;
            }

            // 📅 Reservation date filter (exact match)
            if (reservationDate && reserve !== reservationDate) {
                show = false;
            }

            // 🚦 Show or hide the row based on the filtering result
            row.toggle(show);
            if (show) countVisible++; // Count visible rows for "no results" display
        });

        // 🙈 Show "no results" message if nothing matches
        $('#noResults').toggle(countVisible === 0);
        sortTable(); // Sort the table after filtering
    }


    // 📥 Trigger filtering when any filter input changes
    $('#filterForm input, #filterForm select').on('input change', filterTable);

    // ⏳ Update duration display and filter when range changes
    $('#durationRange').on('input', function () {
        $('#durationValue').text($(this).val()); // Show live slider value
        filterTable(); // Re-apply filter
    });

    // 🔄 Reset button: update slider value text and refilter after inputs reset
    $('#resetBtn').click(() => {
        setTimeout(() => {
            $('#durationValue').text($('#durationRange').val());
            filterTable();
        }, 10); // Small delay to allow inputs to reset before filtering
    });

    $('#sortSelect').on('change', sortTable);

    function sortTable() {
        var sortBy = $('#sortSelect').val();
        var rows = $('#clientTable tbody tr').get();

        rows.sort(function (a, b) {
            var $a = $(a).children();
            var $b = $(b).children();

            function parseVal($cell) {
                return $cell.text().trim().toLowerCase();
            }

            switch (sortBy) {
                case 'client_name':
                    return parseVal($a.eq(6)).localeCompare(parseVal($b.eq(6)));
                case 'package_name':
                    return parseVal($a.eq(1)).localeCompare(parseVal($b.eq(1)));
                case 'duration':
                    return parseInt($a.eq(3).text()) - parseInt($b.eq(3).text());
                case 'price':
                    return parseFloat($a.eq(4).text().replace(/[^\d.]/g, '')) - parseFloat($b.eq(4).text().replace(/[^\d.]/g, ''));
                case 'reservation_date':
                    return new Date($b.eq(5).text()) - new Date($a.eq(5).text()); // Descending
                default:
                    return 0;
            }
        });

        $.each(rows, function (index, row) {
            $('#clientTable tbody').append(row);
        });
    }

});


</script>
<?php
include_once '../footer.php';
?>
