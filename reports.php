<?php
require 'db.php';


$dailyQuery = "SELECT DATE(date) as date, COUNT(*) as total FROM sms_history GROUP BY DATE(date) ORDER BY DATE(date)";
$dailyResult = mysqli_query($conn, $dailyQuery);
$dates = [];
$totals = [];
while ($row = mysqli_fetch_assoc($dailyResult)) {
    $dates[] = $row['date'];
    $totals[] = $row['total'];
}


$statusQuery = "SELECT status, COUNT(*) as count FROM sms_history GROUP BY status";
$statusResult = mysqli_query($conn, $statusQuery);
$statuses = [];
$statusCounts = [];
while ($row = mysqli_fetch_assoc($statusResult)) {
    $statuses[] = $row['status'];
    $statusCounts[] = $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SMS Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .chart-container {
        width: 100%;
        max-width: 500px; /* reduced from 800px */
        margin: 30px auto;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    h2 {
        font-size: 18px;
        text-align: center;
        margin-bottom: 15px;
    }

    canvas {
        max-height: 280px; /* adjust to your desired chart height */
    }
</style>

</head>
<body>

<div class="chart-container">
    <h2>Messages Sent Per Day</h2>
    <canvas id="dailyChart"></canvas>
</div>

<div class="chart-container">
    <h2>Message Status Distribution</h2>
    <canvas id="statusChart"></canvas>
</div>

<script>
    // Line Chart - Messages per Day
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dates) ?>,
            datasets: [{
                label: 'Total Messages',
                data: <?= json_encode($totals) ?>,
                backgroundColor: '#2196f3',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pie Chart - Status Distribution
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($statuses) ?>,
            datasets: [{
                label: 'Status',
                data: <?= json_encode($statusCounts) ?>,
                backgroundColor: ['#4caf50', '#f44336', '#ff9800', '#2196f3']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

</body>
</html>
