<?php
// overtime.php - จัดการโอที (ตัวอย่าง)
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}
include("connect_db.php");
$adminid = $_SESSION['adminid'];

$sql = "SELECT ot.OTID, ot.Dates, ot.OTMin, ot.OTAmount, employee.EmployeeID, employee.FirstName
FROM ot
JOIN employee ON ot.EmployeeID = employee.EmployeeID";
$result = $conn->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
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
            <!-- <strong>อัตราโอที:</strong> <?php echo number_format($ot_rate); ?> ฿/ชั่วโมง &nbsp; | &nbsp;
            <strong>รวมชั่วโมง:</strong> <?php echo $total_ot_hours; ?> ชม. &nbsp; | &nbsp;
            <strong>รวมยอดโอที:</strong> <?php echo number_format($total_ot_pay); ?> ฿ -->
        </div>

        <a class="btn" href="insertOT.php">+ บันทึกโอทีใหม่</a>

        <table class="table" style="margin-top:12px">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>วันที่</th>
                    <th>ชั่วโมง</th>
                    <th>จำนวนเงิน (฿)</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($rows)): ?>
                    <tr>
                        <td colspan="9" class="text-center">ไม่มีข้อมูลพนักงาน</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rows as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['EmployeeID']) ?></td>
                            <td><?= htmlspecialchars($r['FirstName'] ) ?></td>
                            <td><?= htmlspecialchars($r['Dates']) ?></td>
                            <td><?= htmlspecialchars($r['OTMin']) ?></td>
                            <td><?= number_format($r['OTAmount'], 2) ?> ฿</td>
                            <td>
                                <a href="form_update_ot.php?OTID=<?= urlencode($r['OTID']) ?>" class="btn btn-sm btn-warning text-white">แก้ไข</a>
                                <a href="overtime_delete.php?OTID=<?= urlencode($r['OTID']) ?>"
                                   class="btn btn-sm btn-danger text-white"
                                   onclick="return confirm('ยืนยันการลบข้อมูล ot <?= addslashes(htmlspecialchars($r['EmployeeID'] . ' ' . $r['FirstName'])) ?> ?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
        </table>
    </div>
</body>

</html>