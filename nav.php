<?php
// nav.php
$menu_items = [
    ['title' => 'จัดการข้อมูลพนักงาน', 'link' => './employee.php', 'icon' => '👥'],
    ['title' => 'จัดการเวลาเข้างาน', 'link' => './attendance.php', 'icon' => '⏰'],
    ['title' => 'จัดการโอที', 'link' => './overtime.php', 'icon' => '💼'],
    ['title' => 'คำนวณโบนัส', 'link' => './bonus.php', 'icon' => '🎁'],
    ['title' => 'หักค่าประกัน', 'link' => './insurance.php', 'icon' => '🩺'],
    ['title' => 'ดูรายงานสรุป', 'link' => './reports.php', 'icon' => '📊'],
    ['title' => 'ตั้งค่าระบบ', 'link' => './settings.php', 'icon' => '⚙️'],
    ['title' => 'ออกจากระบบ', 'link' => './logout.php', 'icon' => '🚪']
];
?>

<div class="sidebar">
    <h2>เมนูหลัก</h2>
    <?php foreach ($menu_items as $item): ?>
        <a href="<?= htmlspecialchars($item['link']) ?>">
            <span><?= $item['icon'] ?></span> <?= htmlspecialchars($item['title']) ?>
        </a>
    <?php endforeach; ?>
</div>
