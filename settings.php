<?php
// settings.php
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ตั้งค่าระบบ - Payroll System</title>
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
            padding: 20px
        }

        .card {
            background: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 700px
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: 600
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 6px
        }

        button {
            margin-top: 16px;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer
        }

        button:hover {
            background: #094b9f
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>เมนูหลัก</h2>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="employees.php">👥 พนักงาน</a>
        <a href="attendance.php">⏰ เวลาเข้างาน</a>
        <a href="overtime.php">💼 โอที</a>
        <a href="bonus.php">🎁 โบนัส</a>
        <a href="insurance.php">🩺 ประกัน</a>
        <a href="reports.php">📊 รายงาน</a>
        <a href="settings.php">⚙️ ตั้งค่า</a>
        <a href="logout.php">🚪 ออกจากระบบ</a>
    </div>

    <div class="main">
        <h1>ตั้งค่าระบบ</h1>
        <div class="card">
            <form action="#" method="post">
                <label>เวลาเริ่มงานปกติ</label>
                <input type="time" name="work_start" value="08:00">

                <label>เกณฑ์มาสาย (นาที)</label>
                <input type="number" name="late_limit" value="15">

                <label>อัตราหักมาสาย (฿/นาที)</label>
                <input type="number" name="late_deduct" value="5">

                <label>อัตราโอที (฿/ชั่วโมง)</label>
                <input type="number" name="ot_rate" value="150">

                <label>เป้าหมายบริษัท (รายปี)</label>
                <input type="number" name="target" value="1000000">

                <button type="submit">บันทึกการตั้งค่า</button>
            </form>
        </div>
    </div>
</body>

</html>