<?php
  // $main_html = "<h1>Hey I'm Nate</h1>";
  header('Content-Description: File Transfer');
  header("Content-Type:application/msword; charset=utf-8");
  header("Content-Disposition: attachment; filename=ตอนที่ 4 คำชี้แจง ".date('d/m/y').".doc");


// echo $main_html;
  include ('db/connectpdo.php');

  $ACK_NUM_ID = $_GET['id'];




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" http://www.w3.org/...ml1-transitional.dtd />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ตอนที่ 4 คำชี้แจง</title>
</head>
<body>
<?php
									$sql2 = "SELECT * FROM j3_ack WHERE ACK_NUM_ID = :ACK_NUM_ID";
									$stmt2=$db->prepare($sql2);
									$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID); 
									$stmt2->execute();
									$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
									$ACK_M = $row2['ACK_MISSION'];
									$ACK_D = $row2['ACK_DISTRIBUTION'];
									$ACK_S = $row2['ACK_SCOPE'];
									$ACK_DV = $row2['ACK_DIVISION'];
									$ACK_E = $row2['ACK_EXPLANATION'];
									$ACK_ID = $row2['ACK_ID'];
									$UNIT_CODE = $row2['UNIT_CODE'];

									$sql = "SELECT * FROM j3_nrpt_approve WHERE UNIT_CODE = :UNIT_CODE";
									$stmt=$db->prepare($sql);
									$stmt->bindparam(':UNIT_CODE',$UNIT_CODE);
									$stmt->execute();
									$row=$stmt->fetch(PDO::FETCH_ASSOC);
									$NRPT_NAME = $row['NRPT_NAME'];
									$NRPT_ACM = $row['NRPT_ACM'];
									$UNIT_ACM_ID = $row['UNIT_ACM_ID'];

									$sql1 = "SELECT * FROM j3_unit_acm WHERE UNIT_ACM_ID = :UNIT_ACM_ID";
									$stmt1=$db->prepare($sql1);
									$stmt1->bindparam(':UNIT_ACM_ID',$UNIT_ACM_ID);
									$stmt1->execute();
									$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
									$UNIT_NAME = $row1['UNIT_NAME'];

									$NRPT_NAME = explode(' ', $row['NRPT_NAME']);
									$NRPT_NAME = $NRPT_NAME[0];


  ?>
    <center>

<p><h1><font style="color: red;">ลับมาก</font></h1></p>		
</center>

<br>

<p align="left">อัตราเฉพาะกิจ</p>
<p align="left">หมายเลข <?=$ACK_ID?></p>		

<br>
<center>
<u><?=$NRPT_NAME?></u><br>
<u><?=$UNIT_NAME?></u><br>
<u>กองบัญชาการกองทัพไทย</u>		
</center>

<br>
<br>
<left>
<u>คำชี้แจง</u>
<p><?=$ACK_E?></p>


</left>
</body>
</html>