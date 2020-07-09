<?php
session_start();
include ('db/connectpdo.php');


$sql_c = "SELECT count(AJY_ID) as count FROM j3_ajy";
$stmt_c=$db->prepare($sql_c);
$stmt_c->execute();
$row_c=$stmt_c->fetch(PDO::FETCH_ASSOC);
$count_1 = $row_c['count'];

$sql_c1 = "SELECT count(AJY_ID) as count FROM j3_ajy WHERE AJY_STS = 'อนุมัติ'";
$stmt_c1=$db->prepare($sql_c1);
$stmt_c1->execute();
$row_c1=$stmt_c1->fetch(PDO::FETCH_ASSOC);
$count_2 = $row_c1['count'];

$sql_c2 = "SELECT count(AJY_ID) as count FROM j3_ajy WHERE AJY_STS = 'รอการอนุมัติ'";
$stmt_c2=$db->prepare($sql_c2);
$stmt_c2->execute();
$row_c2=$stmt_c2->fetch(PDO::FETCH_ASSOC);
$count_3 = $row_c2['count'];

$sql_c3 = "SELECT count(AJY_ID) as count FROM j3_ajy WHERE AJY_STS = 'ไม่อนุมัติ'";
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
									<span class="info-box-text">หมายเลขอจย. ทั้งหมด</span>
									<span class="info-box-number"><?=$count_1?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอจย. ที่อนุมัติ</span>
									<span class="info-box-number"><?=$count_2?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-warning"><i class="fas fa-exclamation-circle"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอจย. ที่รอการอนุมัติ</span>
									<span class="info-box-number"><?=$count_3?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<div class="info-box">
								<span class="info-box-icon bg-danger"><i class="fas fa-ban"></i></span>

								<div class="info-box-content">
									<span class="info-box-text">หมายเลขอจย. ที่ไม่ผ่านการอนุมัติ</span>
									<span class="info-box-number"><?=$count_4?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead class="bg-success">
							<tr>
								<th style="text-align: center;">หมายเลข อจย.</th>
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

							$sql = "SELECT * FROM j3_ajy ORDER BY AJY_VERSION DESC";
							$stmt=$db->prepare($sql);
							$stmt->execute();
							while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
								$AJY_NUM_ID = $row['AJY_NUM_ID'];
								$AJY_ID = $row['AJY_ID'];
								$AJY_MISSION = $row['AJY_MISSION'];
								$AJY_DISTRIBUTION = $row['AJY_DISTRIBUTION'];
								$AJY_ESSENCE = $row['AJY_ESSENCE'];
								$AJY_SCOPE = $row['AJY_SCOPE'];
								$AJY_DIVISION = $row['AJY_DIVISION'];
								$AJY_SUMMARY = $row['AJY_SUMMARY'];
								$AJY_USER = $row['AJY_USER'];
								$AJY_NAME = $row['AJY_NAME'];
								$UNIT_CODE = $row['UNIT_CODE'];
								$UNIT_NAME = $row['UNIT_NAME'];
								$UNIT_NAME_AJY = $row['UNIT_NAME_AJY'];
								$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
								$AJY_TIMESTAMP = $row['AJY_TIMESTAMP'];
								$AJY_STS = $row['AJY_STS'];
								$AJY_VERSION = $row['AJY_VERSION'];
								$CHK = $row['CHK'];

								$chk = $db->query("SELECT COUNT(AJY_NUM_ID) AS COUNT FROM j3_ajy WHERE AJY_STS LIKE 'อนุมัติ' AND AJY_ID = '$AJY_ID'  ")->fetch()[0];
								$view = 1;
								if($chk > 0 AND $AJY_STS != 'อนุมัติ' ) {
									$view = 0;
								}


								if ($view):

								?>
								<tr>
									<td style="width: 80px; text-align: center;"><?=$AJY_ID?></td>									
									<td style="width: 120px; text-align: center;"><?=$UNIT_CODE?></td>
									<td style="width: 350px;"><?=$UNIT_NAME?></td>
									<td style="width: 200px;"><?=$UNIT_NAME_AJY?></td>
									<td style="width: 20px; text-align: center;"><?=$AJY_VERSION?></td>
									<td style="width: 100px; text-align: center;">
										<?php

										if($AJY_STS=="อนุมัติ"){
											echo "<font color='green'><b>$AJY_STS</b></font>";
										}else if($AJY_STS=="รอการอนุมัติ"){
											echo "<font color='orange'><b>$AJY_STS</b></font>";
										}else{
											echo "<font color='red'><b>$AJY_STS</b></font>";
										}

										?>
									</td>
									<td style="width: 150px; text-align: center;">
										<a class="btn btn-info btn-sm" href="des_ajy.php?id=<?=$AJY_NUM_ID?>&detail_ajy=รายละเอียดข้อมูลหมายเลขอัตราการจัดยุโธปกรณ์">
											<i class="fas fa-pencil-alt">
											</i>
											DETAIL
										</a>
										<a class="btn btn-danger btn-sm" href="delete_data.php?AJY_NUM_ID=<?=$AJY_NUM_ID?>">
											<i class="fas fa-trash">
											</i>
											DELETE
										</a>
										<a class="btn btn-warning btn-sm" href="clone_data.php?AJY_NUM_ID=<?=$AJY_NUM_ID?>" onclick="return confirm('คุณต้องการเพิ่มเวอร์ชั่น ใช่หรือไม่ ?')">
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