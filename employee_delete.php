<?php
include("connect_db.php");

// รับค่า ID หนังสือที่ต้องการลบ
$EmployeeID = @$_GET['EmployeeID'];

// ดึงข้อมูลไฟล์จากฐานข้อมูล
$sql_old = "SELECT EmployeeID, FirstName, Lastname, Position, DepartmentID, BaseSalary, Startdate, Workstart, WorkEnd 
        FROM employee WHERE EmployeeID = '$EmployeeID'";
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
$sql = "DELETE FROM employee WHERE EmployeeID = '$EmployeeID'";
$rs = $conn->query($sql);

if ($rs) {
    ?>
    <script>
        alert("ลบข้อมูลพนักงานสำเร็จ");
        window.location = "employee.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("ไม่สามารถลบข้อมูลพนักงานได้");
        window.location = "employee.php";
    </script>
    <?php
}
?>