<?php
// reports.php - สรุปรายเดือน/รายปี (ตัวอย่าง)
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
$salary = [600000, 610000, 605000, 620000, 615000, 630000];
$ot = [10000, 9000, 12000, 8000, 11000, 10000];
$penalty = [2000, 1500, 1800, 1700, 1600, 1900];

// คำนวณรวม
$total_salary = array_sum($salary);
$total_ot = array_sum($ot);
$total_penalty = array_sum($penalty);
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>รายงานสรุป</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background: #f4f7fb;
            margin: 0
        }

        .sidebar {
            width: 220px;
            position: fixed;
            left: 16px;
            top: 16px;
            bottom: 16px;
            background: #fff;
            padding: 14px;
            border-radius: 10px
        }

        .main {
            margin-left: 260px;
            padding: 24px
        }

        .card {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            margin-bottom: 12px
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>เมนูหลัก</h3>
        <a href="admin_dashboard.php">🏠 Dashboard</a><br>
        <a href="reports.php">📊 รายงาน</a><br>
    </div>
    <div class="main">
        <h1>รายงานสรุป</h1>
        <div class="card">
            <strong>รวมเงินเดือน (6 เดือน):</strong> <?php echo number_format($total_salary); ?> ฿
            &nbsp; | &nbsp; <strong>รวมโอที:</strong> <?php echo number_format($total_ot); ?> ฿
            &nbsp; | &nbsp; <strong>รวมหัก:</strong> <?php echo number_format($total_penalty); ?> ฿
        </div>

        <canvas id="reportChart" height="120"></canvas>

        <script>
            const ctx = document.getElementById('reportChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [
                        { label: 'เงินเดือน', data: <?php echo json_encode($salary); ?>, stack: 's1' },
                        { label: 'โอที', data: <?php echo json_encode($ot); ?>, stack: 's1' },
                        { label: 'หัก', data: <?php echo json_encode($penalty); ?>, stack: 's1' }
                    ]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        </script>
    </div>
</body>

</html>