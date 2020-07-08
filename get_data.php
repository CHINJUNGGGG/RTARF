<?php
if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
		case 'get_j3_unit_acm':
		include ('db/connectpdo.php');
		$PART_ID = $_POST['PART_ID'];
		$sql = "SELECT * FROM j3_unit_acm WHERE PART_ID = :PART_ID";
		$stmt=$db->prepare($sql);
		$stmt->bindparam(':PART_ID',$PART_ID);
		$stmt->execute();
		$row=$stmt->fetchall(PDO::FETCH_ASSOC);
		echo json_encode($row);
		break;
		case 'get_max':
		include ('db/connect.php');
		$UNIT_ACM_CREATE = $_POST["UNIT_ACM_CREATE"];
		$UNIT_CODE = $_POST["UNIT_CODE"];
		$UNIT_CODE_PARENT = $_POST["UNIT_CODE_PARENT"];
		switch ($UNIT_ACM_CREATE) {
			case 'กรม':
			$sql = "SELECT MAX(UNIT_ACM_ID) AS MAX FROM `j3_unit_acm` WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE '".substr($UNIT_CODE , 0 ,2)."' ";
			$res = mysqli_query($conn, $sql);
			$result = mysqli_fetch_assoc($res);
			$max_unit_acm_id = $result["MAX"] + 10000000;
			echo json_encode($max_unit_acm_id);
			break;
			case 'สำนัก':
			$sql = "SELECT MAX(UNIT_ACM_ID) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE '".substr($UNIT_CODE , 0 ,2)."'  ";
			$res = mysqli_query($conn, $sql);
			$result = mysqli_fetch_assoc($res);
			$max_unit_acm_id = $result["MAX"] + 1000000;
			echo json_encode($max_unit_acm_id);
			break;
			case 'ศูนย์':
			$sql = "SELECT MAX(UNIT_CODE) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_CODE, 1, 9) LIKE '".substr($UNIT_CODE_PARENT , 0 ,9)."' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) ";
			$res = mysqli_query($conn, $sql);
			$result = mysqli_fetch_assoc($res);
			$max_unit_acm_id = $result["MAX"] + 100000;
			echo json_encode($max_unit_acm_id);
			break;
			case 'กองพัน':
				$sql = "SELECT MAX(SUBSTRING(UNIT_CODE, 1, 6 )) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_CODE, 1, 5) LIKE '".substr($UNIT_CODE_PARENT , 0 ,5)."'";
				$res = mysqli_query($conn, $sql);
				$result = mysqli_fetch_assoc($res);
				$max_unit_acm_id = $result["MAX"]."0000" +10000;
				echo json_encode($max_unit_acm_id);
			break;
			case 'กอง':
				$sql = "SELECT MAX(SUBSTRING(UNIT_CODE, 1, 8 )) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_CODE, 1, 6) LIKE '".substr($UNIT_CODE_PARENT , 0 ,6)."' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) ";
				$res = mysqli_query($conn, $sql);
				$result = mysqli_fetch_assoc($res);
				$max_unit_acm_id = $result["MAX"]."00" + 100;
				echo json_encode($max_unit_acm_id);
			break;
			case 'แผนก':
				$sql = "SELECT MAX(SUBSTRING(UNIT_CODE, 1, 9)) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_CODE, 1, 6) LIKE '".substr($UNIT_CODE_PARENT , 0 , 6)."' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) ";
				$res = mysqli_query($conn, $sql);
				$result = mysqli_fetch_assoc($res);
				$max_unit_acm_id = $result["MAX"]."0" + 10;
				echo json_encode($max_unit_acm_id);
			break;
			case 'ตอน':
				$sql = "SELECT MAX(SUBSTRING(UNIT_CODE, 1, 9)) AS MAX FROM `j3_nrpt` WHERE SUBSTRING(UNIT_CODE, 1, 6) LIKE '".substr($UNIT_CODE_PARENT , 0 , 6)."' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) ";
				$res = mysqli_query($conn, $sql);
				$result = mysqli_fetch_assoc($res);
				$max_unit_acm_id = $result["MAX"]."0" + 1;
				echo json_encode($max_unit_acm_id);
			break;
		}
		break;
	}
}
?>