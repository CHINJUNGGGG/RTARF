<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DIRECTORATE OF JOINT OPERATIONS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
    <link rel="icon" type="image/png" href="admin/picture/logo.png"/>
    <link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">	
    <link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="login/css/util.css">
    <link rel="stylesheet" type="text/css" href="login/css/main.css">
    <style>
        body{
            /* background-image: url(login/images/07.png); */
            background-repeat: no-repeat;
            background-size: cover;
            width: 100%;
            height: auto;
        }
</style>
</head>
<body>

<?php

        require_once 'db/connect.php';

        if(isset($_POST['button'])){
            $email = $conn->real_escape_string($_POST['email']);
            $password = $conn->real_escape_string($_POST['password']);

            $sql = "SELECT * FROM `tbl_login` WHERE `email` = '".$email."' AND `password` = '".$password."'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            // echo($result);
            // die();


            if(!$row){
                    echo "<script>";
                    echo "alert('ชื่อผู้ใช้งานหรือรหัสผ่านผิด กรุณาลงชื่อเข้าใช้สู่ระบบใหม่');";
                    echo "window.location.href='login.php';";
                    echo "</script>";
              }else{
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["sts"] = $row["sts"];
              }

             if($row > 0){
                if($row["sts"] == "ADMIN"){
                    echo "<script>";
                    echo "window.location.href='index.php';";
                    echo "</script>";
                }
            } 
        }
    ?>

    <div class="limiter">
	<div class="container-login100">
            <div class="wrap-login100">
		<div class="login100-pic js-tilt" data-tilt>
        <img src="login/images/rtarf.png" alt="IMG">
                </div>
                <form action="login.php" method="POST" class="login100-form validate-form">
                    <span class="login100-form-title">DIRECTORATE OF JOINT OPERATIONS</span>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-user" aria-hidden="true"></i></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    </div>					
                    <div class="container-login100-form-btn">
                        <input type="submit" class="login100-form-btn" name="button" value="เข้าสู่ระบบ">
                    </div>
                    <div class="text-center p-t-136"></div>
		</form>
            </div>
	</div>
    </div>

	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="login/vendor/select2/select2.min.js"></script>
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="js/main.js"></script>
</body>
</html> 