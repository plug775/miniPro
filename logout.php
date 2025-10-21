<?php
// logout.php - ตัวอย่าง logout แบบง่าย
// ถ้าใช้ session:
session_start();
session_unset();
session_destroy();
// เปลี่ยนเป็นหน้า Login
header('Location: login.php');
exit;
    