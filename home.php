<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {
    header("Location:index.php");
    exit();
}

$adminid = $_SESSION['adminid'];

include("connect_db.php");
$sql = "SELECT * FROM admin WHERE adminid = '$adminid'";
$rs = $conn->query($sql);
$r = $rs->fetch_object();
?>

<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard - Payroll System</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #007bff;
            --bg: #f7f9fc;
            --white: #ffffff;
            --text-dark: #222;
            --text-muted: #666;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text-dark);
        }

        .sidebar {
            width: 240px;
            background: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 24px 16px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sidebar h2 {
            color: var(--primary);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            padding: 10px 12px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: var(--primary);
            color: #fff;
        }

        .main {
            margin-left: 260px;
            padding: 30px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
        }

        .user-info a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .welcome {
            background: var(--white);
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .card {
            background: var(--white);
            padding: 18px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card h3 {
            color: var(--text-muted);
            font-size: 14px;
        }

        .card p {
            font-size: 20px;
            font-weight: 700;
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .main {
                margin-left: 0;
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>เมนูหลัก</h2>
        <?php include("nav.php"); ?>
    </div>

    <div class="main">
        <div class="header">
            <h1>Admin Dashboard - Payroll System</h1>
            <div class="user-info">
                ผู้ใช้งาน:
                <a href="profile.php?adminid=<?= $r->adminid ?>"><?= htmlspecialchars($r->name) ?></a>
            </div>
        </div>

        <div class="welcome">
            <p>สวัสดี <b>Admin 👋</b>
                คุณสามารถเลือกเมนูด้านซ้ายเพื่อจัดการข้อมูลต่าง ๆ ได้ เช่น
                จัดการพนักงาน, ตรวจสอบเวลา, คำนวณโอที และดูรายงานสรุป</p>
        </div>

        <div class="cards">
            <div class="card">
                <h3>จำนวนพนักงานทั้งหมด</h3>
                <p>50</p>
            </div>
            <div class="card">
                <h3>เงินเดือนรวมต่อเดือน</h3>
                <p>750,000 ฿</p>
            </div>
            <div class="card">
                <h3>ยอดโอทีรวม</h3>
                <p>25,000 ฿</p>
            </div>
            <div class="card">
                <h3>ยอดเงินหักมาสายรวม</h3>
                <p>2,300 ฿</p>
            </div>
            <div class="card">
                <h3>ยอดโบนัสรวม</h3>
                <p>80,000 ฿</p>
            </div>
        </div>
    </div>
</body>

</html>