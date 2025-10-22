<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

include("connect_db.php");

$adminid = $_SESSION['adminid'];

$sql = "SELECT EmployeeID, FirstName, Lastname, Position, DepartmentID, BaseSalary, Startdate, Workstart, WorkEnd 
        FROM employee 
        ORDER BY EmployeeID ASC";
$result = $conn->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>จัดการข้อมูลพนักงาน - Payroll System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #0b63d4;
            --muted: #65738a;
        }

        * {
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: #12222b;
        }

        .sidebar {
            width: 220px;
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: fixed;
            left: 20px;
            top: 20px;
            bottom: 20px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 16px;
            color: var(--accent);
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #222;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: var(--accent);
            color: #fff;
        }

        .main {
            margin-left: 260px;
            padding: 20px;
        }

        h1 {
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #0b63d4;
            color: #fff;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .btn-add {
            background: var(--accent);
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            padding: 8px 14px;
        }

        .btn-add:hover {
            background: #084a9a;
            color: #fff;
        }

        .btn-warning {
            background: #f39c12;
            border: none;
        }

        .btn-danger {
            background: #e74c3c;
            border: none;
        }

        .btn-warning:hover {
            background: #d68910;
        }

        .btn-danger:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>เมนูหลัก</h2>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="employee.php">👥 จัดการพนักงาน</a>
        <a href="attendance.php">⏰ เวลาเข้างาน</a>
        <a href="overtime.php">💼 โอที</a>
        <a href="bonus.php">🎁 โบนัส</a>
        <a href="insurance.php">🩺 ประกัน</a>
        <a href="reports.php">📊 รายงาน</a>
        <a href="settings.php">⚙️ ตั้งค่า</a>
        <a href="logout.php">🚪 ออกจากระบบ</a>
    </div>

    <div class="main">
        <div class="d-flex justify-content-between align-items-center">
            <h1>จัดการข้อมูลพนักงาน</h1>
            <a href="insertEmp.php" class="btn btn-add">+ เพิ่มพนักงานใหม่</a>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>แผนก</th>
                    <th>เงินเดือน</th>
                    <th>วันที่เริ่มงาน</th>
                    <th>เวลาเริ่มงาน</th>
                    <th>เวลาเลิกงาน</th>
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
                            <td><?= htmlspecialchars($r['FirstName'] . ' ' . $r['Lastname']) ?></td>
                            <td><?= htmlspecialchars($r['Position']) ?></td>
                            <td><?= htmlspecialchars($r['DepartmentID']) ?></td>
                            <td><?= number_format($r['BaseSalary'], 2) ?> ฿</td>
                            <td><?= htmlspecialchars($r['Startdate']) ?></td>
                            <td><?= htmlspecialchars($r['Workstart']) ?></td>
                            <td><?= htmlspecialchars($r['WorkEnd']) ?></td>
                            <td>
                                <a href="form_update_Emp.php?EmployeeID=<?= urlencode($r['EmployeeID']) ?>" class="btn btn-sm btn-warning text-white">แก้ไข</a>
                                <a href="employee_delete.php?EmployeeID=<?= urlencode($r['EmployeeID']) ?>"
                                   class="btn btn-sm btn-danger text-white"
                                   onclick="return confirm('ยืนยันการลบพนักงาน <?= addslashes(htmlspecialchars($r['FirstName'] . ' ' . $r['Lastname'])) ?> ?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
