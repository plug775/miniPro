<?php
include("connect_db.php");

// รับค่า ID หนังสือที่ต้องการลบ
$OTID = @$_GET['OTID'];

// ดึงข้อมูลไฟล์จากฐานข้อมูล
$sql_old = "SELECT OTID , EmployeeID , Dates, OTMin, OtrateID , OTAmount
        FROM ot WHERE OTID = '$OTID'";
$rs_old = $conn->query($sql_old);
$r_old = $rs_old->fetch_object();

// // ลบไฟล์รูปภาพ
// if (!empty($r_old->b_img) && file_exists("img_book/" . $r_old->b_img)) {
//     unlink("img_book/" . $r_old->b_img);
// }

// // ลบไฟล์หนังสือ
// if (!empty($r_old->b_file) && file_exists("file_book/" . $r_old->b_file)) {
//     unlink("file_book/" . $r_old->b_file);
// }

// ลบข้อมูลจากฐานข้อมูล
$sql = "DELETE FROM ot WHERE OTID = '$OTID'";
$rs = $conn->query($sql);

if ($rs) {
    ?>
    <script>
        alert("ลบข้อมูล OT สำเร็จ");
        window.location = "overtime.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("ไม่สามารถลบข้อมูล OT ได้");
        window.location = "overtime.php";
    </script>
    <?php
}
?>