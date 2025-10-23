<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

include("connect_db.php"); // เชื่อมต่อฐานข้อมูล

$adminid = $_SESSION['adminid'];

$errors = [];

// เมื่อกด submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $EmployeeID = trim($_POST['EmployeeID'] ?? '');
    $FirstName = trim($_POST['FirstName'] ?? '');
    $Lastname = trim($_POST['Lastname'] ?? '');
    $Position = trim($_POST['Position'] ?? '');
    $DepartmentID = trim($_POST['DepartmentID'] ?? '');
    $BaseSalary = trim($_POST['BaseSalary'] ?? '0');
    $Startdate = trim($_POST['Startdate'] ?? null);
    $Workstart = trim($_POST['Workstart'] ?? null);
    $WorkEnd = trim($_POST['WorkEnd'] ?? null);

    // ตรวจสอบข้อมูล
    if ($EmployeeID === '') $errors[] = 'กรุณากรอกรหัสพนักงาน';
    if ($FirstName === '') $errors[] = 'กรุณากรอกชื่อ';
    if ($Lastname === '') $errors[] = 'กรุณากรอกนามสกุล';
    if (!is_numeric($BaseSalary)) $errors[] = 'เงินเดือนต้องเป็นตัวเลข';

    if (empty($errors)) {
        $sql = "INSERT INTO employee (EmployeeID, FirstName, Lastname, Position, DepartmentID, BaseSalary, Startdate, Workstart, WorkEnd)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $baseSalaryFloat = (float)$BaseSalary;
            $stmt->bind_param("sssssdsss", $EmployeeID, $FirstName, $Lastname, $Position, $DepartmentID, $baseSalaryFloat, $Startdate, $Workstart, $WorkEnd);

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: employee.php?msg=inserted");
                exit();
            } else {
                $errors[] = "ไม่สามารถบันทึกข้อมูล: " . htmlspecialchars($stmt->error);
            }
        } else {
            $errors[] = "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . htmlspecialchars($conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลพนักงานใหม่</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #0b63d4;
            --muted: #65738a;
        }

        * {
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif
        }

        body {
            margin: 0;
            background: var(--bg);
            color: #12222b
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
            bottom: 20px
        }

        .sidebar h2 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 16px;
            color: var(--accent)
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #222;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: 0.2s
        }

        .sidebar a:hover {
            background: var(--accent);
            color: #fff
        }

        .main {
            margin-left: 260px;
            padding: 20px;
            max-width: 1000px;
        }

        h1 {
            font-size: 20px;
            margin-top: 0
        }

        .card-form {
            background: #fff;
            padding: 18px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display:block;
        }

        input[type="text"], input[type="number"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #e6e9ee;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: var(--accent);
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #084a9a
        }

        .btn-cancel {
            background: #6c757d;
            margin-left: 8px;
        }

        .errors {
            background: #ffe6e6;
            color: #a33;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 12px;
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
        <h1>เพิ่มข้อมูลพนักงานใหม่</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul style="margin:0; padding-left:18px;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card-form">
            <form method="post" action="">
                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>รหัสพนักงาน</label>
                        <input type="text" name="EmployeeID" value="<?= htmlspecialchars($_POST['EmployeeID'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>ตำแหน่ง</label>
                        <input type="text" name="Position" value="<?= htmlspecialchars($_POST['Position'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>ชื่อ</label>
                        <input type="text" name="FirstName" value="<?= htmlspecialchars($_POST['FirstName'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>นามสกุล</label>
                        <input type="text" name="Lastname" value="<?= htmlspecialchars($_POST['Lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>แผนก (DepartmentID)</label>
                        <input type="text" name="DepartmentID" value="<?= htmlspecialchars($_POST['DepartmentID'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เงินเดือน (บาท)</label>
                        <input type="number" step="0.01" name="BaseSalary" value="<?= htmlspecialchars($_POST['BaseSalary'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>วันที่เริ่มงาน</label>
                        <input type="date" name="Startdate" value="<?= htmlspecialchars($_POST['Startdate'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เวลาเริ่มงาน</label>
                        <input type="time" name="Workstart" value="<?= htmlspecialchars($_POST['Workstart'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เวลาเลิกงาน</label>
                        <input type="time" name="WorkEnd" value="<?= htmlspecialchars($_POST['WorkEnd'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" class="btn">บันทึกข้อมูล</button>
                    <a href="employee.php" class="btn btn-cancel" style="text-decoration:none; color:#fff;">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
