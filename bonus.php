<?php
// bonus.php - คำนวณโบนัสแบบง่าย (ตัวอย่าง)
$company_revenue = 1200000;
$company_target = 1000000;
$employees = [
    ['id' => 'E001', 'name' => 'สมชาย', 'salary' => 15000, 'bonus_percent' => 5],
    ['id' => 'E002', 'name' => 'สมหญิง', 'salary' => 18000, 'bonus_percent' => 6],
    ['id' => 'E003', 'name' => 'อนุชา', 'salary' => 35000, 'bonus_percent' => 10],
];
// ถ้าเกินเป้าได้โบนัสตาม percent
$bonus_enabled = ($company_revenue > $company_target);
$total_bonus = 0;
if ($bonus_enabled) {
    foreach ($employees as $e)
        $total_bonus += ($e['salary'] * $e['bonus_percent'] / 100);
}
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>คำนวณโบนัส</title>
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

        .note {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04)
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>เมนูหลัก</h3>
        <a href="admin_dashboard.php">🏠 Dashboard</a><br>
        <a href="bonus.php">🎁 โบนัส</a><br>
    </div>
    <div class="main">
        <h1>คำนวณโบนัส</h1>
        <div class="note">
            <p>ยอดรายได้บริษัท: <?php echo number_format($company_revenue); ?> ฿ | เป้าหมาย:
                <?php echo number_format($company_target); ?> ฿</p>
            <p>ผลลัพธ์: <?php echo $bonus_enabled ? 'เกินเป้า — คำนวณโบนัสแล้ว' : 'ไม่ถึงเป้า — ไม่มีโบนัส'; ?></p>
        </div>

        <table class="table" style="margin-top:12px">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>เงินเดือน</th>
                    <th>เปอร์เซ็นต์โบนัส</th>
                    <th>ยอดโบนัส (฿)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $e):
                    $b = ($bonus_enabled) ? ($e['salary'] * $e['bonus_percent'] / 100) : 0;
                    ?>
                    <tr>
                        <td><?php echo $e['id']; ?></td>
                        <td><?php echo $e['name']; ?></td>
                        <td><?php echo number_format($e['salary']); ?></td>
                        <td><?php echo $e['bonus_percent']; ?>%</td>
                        <td><?php echo number_format($b, 0); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="font-weight:700;background:#fff">
                    <td colspan="4">รวมโบนัสทั้งหมด</td>
                    <td><?php echo number_format($total_bonus, 0); ?> ฿</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>