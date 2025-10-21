<?php
// employees.php
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>จัดการข้อมูลพนักงาน - Payroll System</title>
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

        h1 {
            font-size: 20px;
            margin-top: 0
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left
        }

        th {
            background: #0b63d4;
            color: #fff
        }

        tr:hover {
            background: #f9f9f9
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: var(--accent);
            color: #fff;
            border-radius: 6px;
            text-decoration: none
        }

        .btn:hover {
            background: #084a9a
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>เมนูหลัก</h2>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="employees.php">👥 จัดการพนักงาน</a>
        <a href="attendance.php">⏰ เวลาเข้างาน</a>
        <a href="overtime.php">💼 โอที</a>
        <a href="bonus.php">🎁 โบนัส</a>
        <a href="insurance.php">🩺 ประกัน</a>
        <a href="reports.php">📊 รายงาน</a>
        <a href="settings.php">⚙️ ตั้งค่า</a>
        <a href="logout.php">🚪 ออกจากระบบ</a>
    </div>

    <div class="main">
        <h1>จัดการข้อมูลพนักงาน</h1>
        <a href="#" class="btn">+ เพิ่มพนักงานใหม่</a>
        <table>
            <thead>
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>แผนก</th>
                    <th>เงินเดือน</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>EMP001</td>
                    <td>สมชาย ใจดี</td>
                    <td>เจ้าหน้าที่</td>
                    <td>ไอที</td>
                    <td>25,000 ฿</td>
                    <td>
                        <a href="#" class="btn" style="background:#f39c12;">แก้ไข</a>
                        <a href="#" class="btn" style="background:#e74c3c;">ลบ</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>