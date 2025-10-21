<?php
// insurance.php - การหักค่าประกัน (ตัวอย่าง)
$employees = [
    ['id' => 'E001', 'name' => 'สมชาย', 'salary' => 15000],
    ['id' => 'E002', 'name' => 'สมหญิง', 'salary' => 18000],
    ['id' => 'E003', 'name' => 'อนุชา', 'salary' => 35000],
];
$insurance_type = 'fixed'; // 'fixed' or 'percent'
$insurance_fixed = 500; // บาท/เดือน
$insurance_percent = 1.5; // % ของเงินเดือน
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>หักค่าประกัน</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
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

        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th {
            background: #0b63d4;
            color: #fff;
            padding: 10px
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #eee
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>เมนูหลัก</h3>
        <a href="admin_dashboard.php">🏠 Dashboard</a><br>
        <a href="insurance.php">🩺 ประกัน</a><br>
    </div>
    <div class="main">
        <h1>หักค่าประกันอุบัติเหตุ</h1>
        <p>ประเภทการหัก:
            <?php echo ($insurance_type == 'fixed') ? 'หักเป็นจำนวนเงิน (' . $insurance_fixed . ' ฿/เดือน)' : 'หักเป็นเปอร์เซ็นต์ (' . $insurance_percent . '%)'; ?>
        </p>

        <table class="table" style="margin-top:12px">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>เงินเดือน</th>
                    <th>ค่าประกัน (฿)</th>
                    <th>เงินที่ได้รับสุทธิ (฿)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $e):
                    $deduct = ($insurance_type == 'fixed') ? $insurance_fixed : ($e['salary'] * $insurance_percent / 100);
                    $net = $e['salary'] - $deduct;
                    ?>
                    <tr>
                        <td><?php echo $e['id']; ?></td>
                        <td><?php echo $e['name']; ?></td>
                        <td><?php echo number_format($e['salary']); ?></td>
                        <td><?php echo number_format($deduct, 0); ?></td>
                        <td><?php echo number_format($net, 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>