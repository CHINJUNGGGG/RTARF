<?php
    session_start();
    session_destroy();

        echo "<script>";
        echo "alert('คุณได้ทำการออกจากระบบ ระบบจะย้อนกลับหน้าล็อคอินโดยอัติโนมัติ');";
        echo "window.location.href='login.php';";
        echo "</script>";

    mysqli_close($conn);

?>