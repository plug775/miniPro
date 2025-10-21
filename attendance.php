<?php
// attendance.php - จัดการเวลาเข้า-ออกงาน (ตัวอย่างแบบพื้นฐาน)
$attendances = [
    ['id' => 'E001', 'name' => 'สมชาย ใจดี', 'date' => '2025-10-01', 'in' => '08:05', 'out' => '17:00'],
    ['id' => 'E002', 'name' => 'สมหญิง แสนงาม', 'date' => '2025-10-01', 'in' => '08:30', 'out' => '17:10'],
    ['id' => 'E003', 'name' => 'อนุชา แก้วมณี', 'date' => '2025-10-01', 'in' => '07:55', 'out' => '16:50'],
];
// ตั้งค่ามาตรฐาน
$work_start = '08:00';
$late_threshold_min = 15; // ถ้ามาสายเกิน 15 นาทีถือมาสาย
$late_penalty_per_min = 5; // บาท/นาที
// ฟังก์ชันช่วยคำนวณมาสาย (นาที)
function diff_minutes($a, $b)
{
    $ta = strtotime($a);
    $tb = strtotime($b);
    return max(0, intval(round(($ta - $tb) / 60)));
}
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>จัดการเวลาเข้างาน</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>
        /* ใช้สไตล์เดียวกับไฟล์อื่น ๆ (ย่อ/กระชับ) */
        body {
            font-family: 'Kanit', sans-serif;
            background: #f4f7fb;
            margin: 0
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
            padding: 24px
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden
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

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 13px
        }

        .badge.late {
            background: #ffecec;
            color: #a00000
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
        <a href="employees.php">👥 จัดการพนักงาน</a><br>
        <a href="attendance.php">⏰ เวลาเข้างาน</a><br>
        <a href="overtime.php">💼 โอที</a><br>
        <a href="bonus.php">🎁 โบนัส</a><br>
        <a href="insurance.php">🩺 ประกัน</a><br>
        <a href="reports.php">📊 รายงาน</a><br>
        <a href="settings.php">⚙️ ตั้งค่า</a><br>
    </div>

    <div class="main">
        <h1>จัดการเวลาเข้างาน</h1>
        <p>ตั้งค่า: เวลาทำงานปกติ <?php echo $work_start; ?> | เกณฑ์มาสาย <?php echo $late_threshold_min; ?> นาที | หัก
            <?php echo $late_penalty_per_min; ?> ฿/นาที
        </p>

        <a class="btn" href="#">+ เพิ่มบันทึกเวลา</a>

        <table class="table" style="margin-top:16px">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>วันที่</th>
                    <th>เข้า</th>
                    <th>ออก</th>
                    <th>มาสาย (นาที)</th>
                    <th>ค่าหัก (฿)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendances as $r):
                    $late = diff_minutes($r['in'], $work_start);
                    $penalty = ($late > $late_threshold_min) ? ($late * $late_penalty_per_min) : 0;
                    ?>
                    <tr>
                        <td><?php echo $r['id']; ?></td>
                        <td><?php echo $r['name']; ?></td>
                        <td><?php echo $r['date']; ?></td>
                        <td><?php echo $r['in']; ?></td>
                        <td><?php echo $r['out']; ?></td>
                        <td><?php echo $late; ?>
                            <?php if ($late > $late_threshold_min)
                                echo '<span class="badge late">มาสาย</span>'; ?>
                        </td>
                        <td><?php echo number_format($penalty, 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>