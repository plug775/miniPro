<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

include("connect_db.php"); // เชื่อมต่อฐานข้อมูล

$adminid = $_SESSION['adminid'];

// ตรวจสอบว่าได้รับ EmployeeID มาจาก GET หรือไม่
if (!isset($_GET['EmployeeID']) && !isset($_POST['EmployeeID'])) {
    // ถ้าไม่มี ให้กลับไปหน้า employee
    header("Location: employee.php");
    exit();
}

// ถ้ามีการกดปุ่ม submit (POST) ให้ประมวลผลการอัพเดต
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม (ควรมีการ validate เพิ่มเติมตามต้องการ)
    $EmployeeID = $_POST['EmployeeID'];
    $FirstName = trim($_POST['FirstName'] ?? '');
    $Lastname = trim($_POST['Lastname'] ?? '');
    $Position = trim($_POST['Position'] ?? '');
    $DepartmentID = trim($_POST['DepartmentID'] ?? '');
    $BaseSalary = trim($_POST['BaseSalary'] ?? '0');
    $Startdate = trim($_POST['Startdate'] ?? null);
    $Workstart = trim($_POST['Workstart'] ?? null);
    $WorkEnd = trim($_POST['WorkEnd'] ?? null);

    // ตัวอย่าง validate เบื้องต้น
    $errors = [];
    if ($FirstName === '') $errors[] = 'กรุณากรอกชื่อ';
    if ($Lastname === '') $errors[] = 'กรุณากรอกนามสกุล';
    if (!is_numeric($BaseSalary)) $errors[] = 'เงินเดือนต้องเป็นตัวเลข';

    if (empty($errors)) {
        // ใช้ prepared statement เพื่อป้องกัน SQL injection
        $sql = "UPDATE employee
                SET FirstName = ?, Lastname = ?, Position = ?, DepartmentID = ?, BaseSalary = ?, Startdate = ?, Workstart = ?, WorkEnd = ?
                WHERE EmployeeID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errors[] = "Prepare failed: " . htmlspecialchars($conn->error);
        } else {
            // ผูกพารามิเตอร์ (s = string, d = double, i = integer) ใช้ s ทั้งหมดยกเว้น BaseSalary เป็น double
            $baseSalaryFloat = (float)$BaseSalary;
            $stmt->bind_param("ssssdssss", $FirstName, $Lastname, $Position, $DepartmentID, $baseSalaryFloat, $Startdate, $Workstart, $WorkEnd, $EmployeeID);
            if ($stmt->execute()) {
                $stmt->close();
                // อัพเดตสำเร็จ -> กลับไปหน้าแสดงรายการ (หรือจะแสดงข้อความสำเร็จที่หน้านี้ก็ได้)
                header("Location: employee.php?msg=updated");
                exit();
            } else {
                $errors[] = "ไม่สามารถอัพเดตข้อมูล: " . htmlspecialchars($stmt->error);
                $stmt->close();
            }
        }
    }
}

// ถ้าเป็นการเข้าหน้าแบบ GET ให้ดึงข้อมูลมาแสดง
$EmployeeID = $_GET['EmployeeID'] ?? ($_POST['EmployeeID'] ?? '');
$employee = null;
if ($EmployeeID !== '') {
    // ใช้ prepared statement สำหรับ SELECT ด้วย
    $sql = "SELECT EmployeeID, FirstName, Lastname, Position, DepartmentID, BaseSalary, Startdate, Workstart, WorkEnd
            FROM employee WHERE EmployeeID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $EmployeeID);
        $stmt->execute();
        $res = $stmt->get_result();
        $employee = $res->fetch_assoc();
        $stmt->close();
    } else {
        $errors[] = "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . htmlspecialchars($conn->error);
    }
}

// หากไม่พบพนักงาน ให้ redirect กลับ
if (!$employee && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: employee.php?msg=notfound");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แก้ไขข้อมูลพนักงาน</title>
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
        <h1>แก้ไขข้อมูลพนักงาน</h1>

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
                <!-- EmployeeID ไม่ให้แก้ (readonly) แต่ส่งใน POST -->
                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>รหัสพนักงาน</label>
                        <input type="text" name="EmployeeID" readonly value="<?= htmlspecialchars($employee['EmployeeID'] ?? $EmployeeID, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>ตำแหน่ง</label>
                        <input type="text" name="Position" value="<?= htmlspecialchars($employee['Position'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>ชื่อ</label>
                        <input type="text" name="FirstName" value="<?= htmlspecialchars($employee['FirstName'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>นามสกุล</label>
                        <input type="text" name="Lastname" value="<?= htmlspecialchars($employee['Lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>แผนก (DepartmentID)</label>
                        <input type="text" name="DepartmentID" value="<?= htmlspecialchars($employee['DepartmentID'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เงินเดือน (บาท)</label>
                        <input type="number" step="0.01" name="BaseSalary" value="<?= htmlspecialchars($employee['BaseSalary'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="display:flex; gap:12px;">
                    <div style="flex:1">
                        <label>วันที่เริ่มงาน</label>
                        <input type="date" name="Startdate" value="<?= htmlspecialchars($employee['Startdate'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เวลาเริ่มงาน</label>
                        <input type="time" name="Workstart" value="<?= htmlspecialchars($employee['Workstart'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div style="flex:1">
                        <label>เวลาเลิกงาน</label>
                        <input type="time" name="WorkEnd" value="<?= htmlspecialchars($employee['WorkEnd'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" class="btn">บันทึกการเปลี่ยนแปลง</button>
                    <a href="employee.php" class="btn btn-cancel" style="text-decoration:none; color:#fff; padding:8px 12px;">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
