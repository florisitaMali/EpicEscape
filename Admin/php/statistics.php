<?php 
include_once '../../config.php';

function getStatistics($conn){
    $arr = ['total_clients' => $conn->query("SELECT COUNT(*) FROM clients")->fetch_row()[0],
        'active_packages' => $conn->query("SELECT COUNT(*) FROM packages WHERE available_spots > 0")->fetch_row()[0],
        'total_reservations' => $conn->query("SELECT COUNT(*) FROM reservations")->fetch_row()[0],
        'total_revenue' => $conn->query("SELECT SUM(price) FROM packages")->fetch_row()[0] ];
    return $arr;
}

function calculatePercentage($field, $conn){
    if($field == 'reservations'){
        $thisWeekSql = "SELECT COUNT(*) AS total FROM reservations WHERE YEARWEEK(reservation_date, 1) = YEARWEEK(CURDATE(), 1);";
        $thisWeek = $conn->query($thisWeekSql)->fetch_assoc();

        $lastWeekSql = "SELECT COUNT(*) AS total FROM reservations WHERE YEARWEEK(reservation_date, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1);";
        $lastWeek = $conn->query($thisWeekSql)->fetch_assoc();

        if($lastWeek['total'] == 0){
            $percentage = 100; 
        }else{
            $percentage = (($thisWeek['total'] - $lastWeek['total']) / $lastWeek['total']) * 100;
        }
    }else if($field == 'revenue'){
        $thisWeekSql = "SELECT SUM(price) AS total FROM packages p JOIN reservations ON PackageID = p.ID  WHERE YEARWEEK(reservation_date, 1) = YEARWEEK(CURDATE(), 1);";
        $thisWeek = $conn->query($thisWeekSql)->fetch_assoc();

        $lastWeekSql = "SELECT SUM(price) AS total FROM packages p JOIN reservations ON PackageID = p.ID  WHERE YEARWEEK(reservation_date, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1);";
        $lastWeek = $conn->query($lastWeekSql)->fetch_assoc();

        if($lastWeek['total'] == 0){
            $percentage = 100; 
        }else{
            $percentage = (($thisWeek['total'] - $lastWeek['total']) / $lastWeek['total']) * 100;
        }
    }
    return number_format($percentage, 2);
}

function getRecentBookings($conn){
    $result = $conn->query("SELECT p.name as package_name, p.place as destination, p.date as travel_date, p.price as amount, p.available_spots FROM packages p ORDER BY p.date ASC LIMIT 5");
    $recent_bookings = [];
    while ($row = $result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
    return $result;
}

function getTopPerformingTours($conn) {
    $result = $conn->query("
        SELECT p.ID, Name, SUM(price) AS total_revenue
        FROM packages p
        JOIN reservations r ON p.ID = r.PackageID
        GROUP BY p.ID
        ORDER BY total_revenue DESC
        LIMIT 3
    ");

    $topTours = [];
    while ($row = $result->fetch_assoc()) {
        $topTours[] = $row;
    }
    return $topTours;
}

function getUpcommingPackages($conn){
    $result = $conn->query("
        SELECT name, date, available_spots, place, duration
        FROM packages
        WHERE date > CURRENT_DATE
        ORDER BY date ASC
        LIMIT 3
    ");

    $upcoming_tours = [];
    while ($row = $result->fetch_assoc()) {
        $upcoming_tours[] = $row;
    }
    return $upcoming_tours;
}

function getPopularDestinations($conn){
    $result = $conn->query("
        SELECT place, COUNT(*) as reservation_count
        FROM packages p
        JOIN reservations r ON p.ID = r.PackageID
        GROUP BY place
        ORDER BY reservation_count DESC
        LIMIT 3
    ");

    $popular_destinations = [];
    while ($row = $result->fetch_assoc()) {
        $popular_destinations[] = $row;
    }
    return $popular_destinations;
}

function getRevenues($conn) {
    $result = $conn->query("
        SELECT DATE_FORMAT(reservation_date, '%b %Y') AS label,
               SUM(price) AS total_revenue
        FROM packages p
        JOIN reservations r ON p.ID = r.PackageID
        GROUP BY label
        ORDER BY MAX(reservation_date) DESC
        LIMIT 12
    ");

    $revenues = [];

    while ($row = $result->fetch_assoc()) {
        $revenues[$row['label']] = (float)$row['total_revenue'];
    }

    // Maintain chronological order
    return array_reverse($revenues, true);
}

function getBookingsByCategory($conn) {
    $result = $conn->query("SELECT Type, COUNT(*) AS total_bookings
        FROM reservations r
        JOIN packages p ON r.PackageID = p.ID
        GROUP BY Type
        ORDER BY total_bookings DESC
    ");

    $bookings = [];

    while ($row = $result->fetch_assoc()) {
        $bookings[$row['Type']] = (int)$row['total_bookings'];
    }

    return $bookings;
}

function getStatisticsPerCountry($conn, $country) {
    $result = $conn->query("SELECT COUNT(*) AS total_bookings
        FROM reservations r
        JOIN packages p ON r.PackageID = p.ID
        WHERE p.place = '$country'
    ");

    $total = $conn->query("SELECT COUNT(*) AS total
        FROM reservations r
        JOIN packages p ON r.PackageID = p.ID;");
    $total = $total->fetch_assoc();
    $total = $total['total'];

    $result = $result->fetch_assoc();
    $result = $result['total_bookings'];

    if($total == 0){
        return 0;
    }else{
        $percentage = ($result / $total) * 100;
        return number_format($percentage, 2);
    }

}

function getStatisticsPerRevenue($conn, $id){
    $result = $conn->query("SELECT SUM(price) AS total_revenue
        FROM reservations r
        JOIN packages p ON r.PackageID = p.ID
        WHERE p.ID = '$id'
    ");

    $total = $conn->query("SELECT SUM(price) AS total_revenue
        FROM reservations r
        JOIN packages p ON r.PackageID = p.ID;");
    $total = $total->fetch_assoc();
    $total = $total['total_revenue'];

    $result = $result->fetch_assoc();
    $result = $result['total_revenue'];

    if($total == 0){
        return 0;
    }else{
        $percentage = ($result / $total) * 100;
        return number_format($percentage, 2);
    }
}

function getRevenueData($conn, $period) {
    $query = match($period) {
        'last_month' => "
            SELECT DATE_FORMAT(date, '%Y-%m') as period_key, -- For sorting if needed
            DATE_FORMAT(date, '%b %Y') as label,       -- What users see
            SUM(price) as revenue,
            COUNT(*) as bookings
            FROM packages
            WHERE date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR)
            GROUP BY period_key, label
            ORDER BY MIN(date) ASC
        ",
        'last_year' => "
            SELECT DATE_FORMAT(date, '%b') as label,
                   SUM(price) as revenue,
                   COUNT(*) as bookings
            FROM packages
            WHERE date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 YEAR)
            GROUP BY label
            ORDER BY MIN(date) ASC
        ",
        'all_time' => "
            SELECT DATE_FORMAT(date, '%Y') as label,
                   SUM(price) as revenue,
                   COUNT(*) as bookings
            FROM packages
            GROUP BY label
            ORDER BY MIN(date) ASC
        ",
        default => "
            SELECT DATE_FORMAT(date, '%b') as label,
                   SUM(price) as revenue,
                   COUNT(*) as bookings
            FROM packages
            WHERE date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
            GROUP BY label
            ORDER BY MIN(date) ASC
        "
    };

    $result = $conn->query($query);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'month' => $row['label'],
            'revenue' => (float)$row['revenue'],
            'bookings' => (int)$row['bookings']
        ];
    }

    return $data;
}
