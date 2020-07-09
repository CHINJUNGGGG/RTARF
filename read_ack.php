<?php
session_start();
include ('db/connectpdo.php');


$sql_c = "SELECT count(ACK_ID) as count FROM j3_ack";
$stmt_c=$db->prepare($sql_c);
$stmt_c->execute();
$row_c=$stmt_c->fetch(PDO::FETCH_ASSOC);
$count_1 = $row_c['count'];

$sql_c1 = "SELECT count(ACK_ID) as count FROM j3_ack WHERE ACK_STS = 'อนุมัติ'";
$stmt_c1=$db->prepare($sql_c1);
$stmt_c1->execute();
$row_c1=$stmt_c1->fetch(PDO::FETCH_ASSOC);
$count_2 = $row_c1['count'];

$sql_c2 = "SELECT count(ACK_ID) as count FROM j3_ack WHERE ACK_STS = 'รอการอนุมัติ'";
$stmt_c2=$db->prepare($sql_c2);
$stmt_c2->execute();
$row_c2=$stmt_c2->fetch(PDO::FETCH_ASSOC);
$count_3 = $row_c2['count'];

$sql_c3 = "SELECT count(ACK_ID) as count FROM j3_ack WHERE ACK_STS = 'ไม่อนุมัติ'";
$stmt_c3=$db->prepare($sql_c3);
$stmt_c3->execute();
$row_c3=$stmt_c3->fetch(PDO::FETCH_ASSOC);
$count_4 = $row_c3['count'];
?>

<!DOCTYPE html>
<html>
<head>
	<?php
	include ('path/head.php');
	?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper"><?php include ('path/navbar.php'); ?>
		<?php
		include ('path/sidebar.php');
		?>
		<div class="content-wrapper">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-info"><i class="fas fa-home"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอัตราเฉพาะกิจทั้งหมด</span>
									<span class="info-box-number"><?=$count_1?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอัตราเฉพาะกิจที่อนุมัติ</span>
									<span class="info-box-number"><?=$count_2?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-warning"><i class="fas fa-exclamation-circle"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอัตราเฉพาะกิจที่รอการอนุมัติ</span>
									<span class="info-box-number"><?=$count_3?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอัตราเฉพาะกิจที่ไม่ผ่านการอนุมัติ</span>
									<span class="info-box-number"><?=$count_4?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead class="bg-blue">
							<tr>
								<th style="text-align: center;">หมายเลข อฉก.</th>
								<th style="text-align: center;">หมายเลขหน่วย(ใหม่)</th>
								<th>นามหน่วย(ใหม่)</th>
								<th>นามหน่วยย่อ(ใหม่)</th>
								<th style="text-align: center;">Version</th>
								<th style="text-align: center;">สถานะ</th>
								<th style="text-align: center;"><i class="fas fa-cogs nav-icon"></i></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$sql = "SELECT * FROM `j3_ack`  ORDER BY ACK_VERSION DESC";
							$stmt=$db->prepare($sql);
							$stmt->execute();
							while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
								$ACK_NUM_ID = $row['ACK_NUM_ID'];
								$ACK_ID = $row['ACK_ID'];
								$ACK_MISSION = $row['ACK_MISSION'];
								$ACK_DISTRIBUTION = $row['ACK_DISTRIBUTION'];
								$ACK_ESSENCE = $row['ACK_ESSENCE'];
								$ACK_SCOPE = $row['ACK_SCOPE'];
								$ACK_DIVISION = $row['ACK_DIVISION'];
								$ACK_SUMMARY = $row['ACK_SUMMARY'];
								$ACK_USER = $row['ACK_USER'];
								$ACK_NAME = $row['ACK_NAME'];
								$UNIT_CODE = $row['UNIT_CODE'];
								$UNIT_NAME = $row['UNIT_NAME'];
								$UNIT_NAME_ACK = $row['UNIT_NAME_ACK'];
								$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
								$ACK_TIMESTAMP = $row['ACK_TIMESTAMP'];
								$ACK_STS = $row['ACK_STS'];
								$ACK_VERSION = $row['ACK_VERSION'];
								$CHK = $row['CHK'];

								$chk = $db->query("SELECT COUNT(ACK_NUM_ID) AS COUNT FROM j3_ack WHERE ACK_STS LIKE 'อนุมัติ' AND ACK_ID = '$ACK_ID'  ")->fetch()[0];
								$view = 1;
								if($chk > 0 AND $ACK_STS != 'อนุมัติ' ) {
									$view = 0;
								}


								if ($view):
								?>
								<tr>
									<td style="width: 80px; text-align: center;"><?=$ACK_ID?></td>									
									<td style="width: 120px; text-align: center;"><?=$UNIT_CODE?></td>
									<td style="width: 250px;"><?=$UNIT_NAME?></td>
									<td style="width: 200px;"><?=$UNIT_NAME_ACK?></td>
									<td style="width: 20px; text-align: center;"><?=$ACK_VERSION?></td>
									<td style="width: 50px; text-align: center;">
										<?php

										if($ACK_STS=="อนุมัติ"){
											echo "<font color='green'><b>$ACK_STS</b></font>";
										}else if($ACK_STS=="รอการอนุมัติ"){
											echo "<font color='orange'><b>$ACK_STS</b></font>";
										}else{
											echo "<font color='red'><b>$ACK_STS</b></font>";
										}

										?>
									</td>
									<td style="width: 150px; text-align: center;">
										<a class="btn btn-info btn-sm" href="des_ack.php?id=<?=$ACK_NUM_ID?>&id2=<?=$UNIT_CODE?>&detail=รายละเอียดข้อมูลหมายเลขอัตราเฉพาะกิจ">
											<i class="fas fa-pencil-alt">
											</i>
											DETAIL
										</a>
										<a class="btn btn-danger btn-sm" href="delete_data.php?ACK_NUM_ID=<?=$ACK_NUM_ID?>" onclick="return confirm('คุณต้องการลบรายการนี้ ใช่หรือไม่ ?')">
											<i class="fas fa-trash">
											</i>
											DELETE
										</a>
										<a class="btn btn-warning btn-sm" href="clone_data.php?ACK_NUM_ID=<?=$ACK_NUM_ID?>" onclick="return confirm('คุณต้องการเพิ่มเวอร์ชั่น ใช่หรือไม่ ?')">
											<i class="fas fa-copy">
											</i>
											CLONE
										</a>
									</td>
								</tr>
									<?php endif;?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>


		<footer class="main-footer">
			<strong>Copyright &copy; 2019 </strong>
			Multi Innovation Engineering Co.,Ltd
		</footer>


		<aside class="control-sidebar control-sidebar-dark">
		</aside>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<?php
	include ('path/script.php');
	?>
</body>
</html>