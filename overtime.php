<?php
// overtime.php - จัดการโอที (ตัวอย่าง)
$ot_records = [
    ['id' => 'E001', 'name' => 'สมชาย', 'date' => '2025-10-02', 'hours' => 2.5],
    ['id' => 'E002', 'name' => 'สมหญิง', 'date' => '2025-10-03', 'hours' => 1.0],
    ['id' => 'E004', 'name' => 'กาญจนา', 'date' => '2025-10-01', 'hours' => 4.0],
];
$ot_rate = 150; // บาท/ชั่วโมง
// รวมโอที
$total_ot_hours = array_sum(array_column($ot_records, 'hours'));
$total_ot_pay = $total_ot_hours * $ot_rate;
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>จัดการโอที</title>
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
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05)
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

        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th {
            background: #0b63d4;
            color: #fff;
            padding: 10px;
            text-align: left
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #eee
        }

        .btn {
            background: #0b63d4;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>เมนูหลัก</h3>
        <a href="admin_dashboard.php">🏠 Dashboard</a><br>
        <a href="overtime.php">💼 โอที</a><br>
        <a href="attendance.php">⏰ เวลาเข้างาน</a><br>
    </div>
    <div class="main">
        <h1>จัดการโอที</h1>
        <div class="card">
            <strong>อัตราโอที:</strong> <?php echo number_format($ot_rate); ?> ฿/ชั่วโมง &nbsp; | &nbsp;
            <strong>รวมชั่วโมง:</strong> <?php echo $total_ot_hours; ?> ชม. &nbsp; | &nbsp;
            <strong>รวมยอดโอที:</strong> <?php echo number_format($total_ot_pay); ?> ฿
        </div>

        <a class="btn" href="#">+ บันทึกโอทีใหม่</a>

        <table class="table" style="margin-top:12px">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>วันที่</th>
                    <th>ชั่วโมง</th>
                    <th>จำนวนเงิน (฿)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ot_records as $r):
                    $pay = $r['hours'] * $ot_rate; ?>
                    <tr>
                        <td><?php echo $r['id']; ?></td>
                        <td><?php echo $r['name']; ?></td>
                        <td><?php echo $r['date']; ?></td>
                        <td><?php echo $r['hours']; ?></td>
                        <td><?php echo number_format($pay, 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>