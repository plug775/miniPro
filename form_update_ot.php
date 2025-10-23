<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

include("connect_db.php");

$adminid = $_SESSION['adminid'];
$errors = [];

// ตรวจสอบว่าได้รับ OTID
if (!isset($_GET['OTID']) && !isset($_POST['OTID'])) {
    header("Location: overtime.php");
    exit();
}

// POST: บันทึก OT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $OTID = $_POST['OTID'];
    $Dates = $_POST['Dates'] ?? '';
    $OTMin = $_POST['OTMin'] ?? '';
    $OTAmount = $_POST['OTAmount'] ?? '';

    if ($Dates === '') $errors[] = 'กรุณากรอกวันที่';
    if (!is_numeric($OTMin)) $errors[] = 'OT นาทีต้องเป็นตัวเลข';
    if (!is_numeric($OTAmount)) $errors[] = 'จำนวนเงิน OT ต้องเป็นตัวเลข';

    if (empty($errors)) {
        $sql = "UPDATE ot SET Dates=?, OTMin=?, OTAmount=? WHERE OTID=?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sddi", $Dates, $OTMin, $OTAmount, $OTID);
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: overtime.php?msg=updated");
                exit();
            } else {
                $errors[] = "ไม่สามารถอัพเดต OT: " . htmlspecialchars($stmt->error);
                $stmt->close();
            }
        } else {
            $errors[] = "Prepare failed: " . htmlspecialchars($conn->error);
        }
    }
}

// GET OTID: ดึงข้อมูล OT + Employee
$OTID = $_GET['OTID'] ?? ($_POST['OTID'] ?? '');
$ot = null;
if ($OTID !== '') {
    $sql = "SELECT ot.OTID, ot.Dates, ot.OTMin, ot.OTAmount, employee.EmployeeID, employee.FirstName
            FROM ot
            JOIN employee ON ot.EmployeeID = employee.EmployeeID
            WHERE ot.OTID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $OTID);
        $stmt->execute();
        $res = $stmt->get_result();
        $ot = $res->fetch_assoc();
        $stmt->close();
    } else {
        $errors[] = "เกิดข้อผิดพลาด: " . htmlspecialchars($conn->error);
    }
}

if (!$ot && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: overtime.php?msg=notfound");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>แก้ไขข้อมูล OT</title>
<link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
<style>
:root {
    --bg: #f4f7fb;
    --card: #ffffff;
    --accent: #0b63d4;
    --muted: #65738a;
}
* { box-sizing: border-box; font-family: 'Kanit', sans-serif; }
body { margin: 0; background: var(--bg); color: #12222b; }
.sidebar {
    width: 220px; background: #fff; border-radius: 12px; padding: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05); position: fixed; left: 20px; top: 20px; bottom: 20px;
}
.sidebar h2 { font-size: 18px; margin-top:0; margin-bottom:16px; color: var(--accent); }
.sidebar a { display:block; text-decoration:none; color:#222; padding:8px 10px; border-radius:8px; margin-bottom:6px; transition:0.2s; }
.sidebar a:hover { background: var(--accent); color:#fff; }
.main { margin-left: 260px; padding: 20px; max-width:1000px; }
h1 { font-size:20px; margin-top:0; }
.card-form { background:#fff; padding:18px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.04); }
label { font-weight:600; margin-bottom:6px; display:block; }
input[type="text"], input[type="number"], input[type="date"] {
    width:100%; padding:8px 10px; border:1px solid #e6e9ee; border-radius:6px; margin-bottom:12px;
}
.btn { display:inline-block; padding:8px 12px; background: var(--accent); color:#fff; border-radius:6px; text-decoration:none; border:none; cursor:pointer; }
.btn:hover { background:#084a9a; }
.btn-cancel { background:#6c757d; margin-left:8px; text-decoration:none; color:#fff; padding:8px 12px; display:inline-block; border-radius:6px; }
.errors { background:#ffe6e6; color:#a33; padding:10px; border-radius:6px; margin-bottom:12px; }
</style>
</head>
<body>
<div class="sidebar">
    <h2>เมนูหลัก</h2>
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="overtime.php">💼 โอที</a>
    <a href="attendance.php">⏰ เวลาเข้างาน</a>
</div>
<div class="main">
<h1>แก้ไขข้อมูล OT</h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card-form">
<form method="post" action="">
    <input type="hidden" name="OTID" value="<?= htmlspecialchars($ot['OTID'] ?? $OTID) ?>">

    <div>
        <label>รหัสพนักงาน</label>
        <input type="text" name="EmployeeID" readonly value="<?= htmlspecialchars($ot['EmployeeID'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div>
        <label>ชื่อพนักงาน</label>
        <input type="text" name="FirstName" readonly value="<?= htmlspecialchars($ot['FirstName'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div>
        <label>วันที่ OT</label>
        <input type="date" name="Dates" value="<?= htmlspecialchars($ot['Dates'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div>
        <label>จำนวน OT (นาที)</label>
        <input type="number" name="OTMin" value="<?= htmlspecialchars($ot['OTMin'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div>
        <label>จำนวนเงิน OT (บาท)</label>
        <input type="number" step="0.01" name="OTAmount" value="<?= htmlspecialchars($ot['OTAmount'] ?? '', ENT_QUOTES) ?>">
    </div>

    <div style="margin-top:10px;">
        <button type="submit" class="btn">บันทึก</button>
        <a href="overtime.php" class="btn-cancel">ยกเลิก</a>
    </div>
</form>
</div>
</div>
</body>
</html>
