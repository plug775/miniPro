<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

include("connect_db.php"); // เชื่อมต่อฐานข้อมูล

$adminid = $_SESSION['adminid'];

// ดึงข้อมูลแอดมินจากฐานข้อมูล
$sql = "SELECT * FROM admin WHERE adminid = '$adminid'";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();
?>

<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ข้อมูลโปรไฟล์ - Payroll System</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #fff;
            --accent: #0b63d4;
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

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: var(--card);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(10, 30, 60, .06);
        }

        h2 {
            margin-bottom: 16px;
            color: var(--accent);
        }

        .info {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px 16px;
        }

        .info label {
            font-weight: 600;
            color: #334;
        }

        .info div {
            padding: 6px 0;
            border-bottom: 1px solid #e0e4e8;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            background: var(--accent);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn.secondary {
            background: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>ข้อมูลโปรไฟล์ผู้ดูแลระบบ</h2>

            <div class="info">
                <label>ชื่อ-นามสกุล:</label>
                <div><?= htmlspecialchars($admin['name'] ?? '-') ?></div>


                <label>เบอร์โทรศัพท์:</label>
                <div><?= htmlspecialchars($admin['tel'] ?? '-') ?></div>

                <label>ชื่อผู้ใช้:</label>
                <div><?= htmlspecialchars($admin['adminid'] ?? '-') ?></div>

                
            </div>

            <div class="actions">
                <a href="home.php" class="btn secondary">กลับหน้าแรก</a>
                <a href="profile_edit.php" class="btn">แก้ไขข้อมูล</a>
            </div>
        </div>
    </div>
</body>

</html>