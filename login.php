<?php

session_start();
ob_start();

include("connect_db.php");


$adminid = @$_POST['adminid'];
$password = @$_POST['password'];

$sql = "select * from admin where adminid = '$adminid' AND password = '$password' ";

$rs = $conn->query($sql);

$row = mysqli_num_rows($rs);

$r = $rs->fetch_object();

if ($row > 0) {

    $_SESSION['adminid'] = $r->adminid;


    ?>

    <script>
        alert("ยินดีต้อนรับเข้าสู่ระบบ")
        window.location = "home.php"
    </script>
<?php } else {

    ?>
    <script>
        alert("ไม่สามารถเข้าสู่ระบบ")
        window.location = "index.php"
    </script>

<?php } ?>