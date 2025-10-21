<?php
session_start();
ob_start();

if (empty($_SESSION['adminid'])) {

    header("Location:index.php");
    exit();
}

$adminid = @$_SESSION['adminid'];
?>

<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard - Payroll System</title>
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

        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 20px
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
            display: flex;
            align-items: center;
            gap: 8px;
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
            margin-left: 260px
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .header h1 {
            margin: 0;
            font-size: 20px
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-top: 16px
        }

        .card {
            background: var(--card);
            padding: 14px;
            border-radius: 10px;
            box-shadow: 0 4px 18px rgba(10, 30, 60, 0.06)
        }

        .card h3 {
            margin: 0;
            font-size: 13px;
            color: var(--muted)
        }

        .card p {
            margin: 8px 0 0;
            font-size: 18px;
            font-weight: 700
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>เมนูหลัก</h2>
        <?php
        include("nav.php");
        ?>
    </div>
    <?php
    include("connect_db.php");
    $sql = "select * from admin where adminid = '$adminid'";
    $rs = $conn->query($sql);
    $r = $rs->fetch_object();

    ?>
    <div class="main">
        <div class="container">
            <div class="header">
                <h1>Admin Dashboard - Payroll System</h1>
                <div class="small">ผู้ใช้งาน:

                    <a href="profile.php?adminid=<?= $r->adminid ?>"><?= $r->name ?></a>
                </div>
            </div>
            <p>สวัสดี Admin 👋 คุณสามารถเลือกเมนูด้านซ้ายเพื่อจัดการข้อมูลต่าง ๆ ได้ เช่น จัดการพนักงาน, ตรวจสอบเวลา,
                คำนวณโอที และดูรายงานสรุป</p>
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
    </div>
</body>

</html>