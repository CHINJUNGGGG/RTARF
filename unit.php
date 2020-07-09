<?php
session_start();
include ('db/connectpdo.php');

$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];

$SUB_UNIT = substr($UNIT_CODE, 0, 4);

$sql ="SELECT * FROM j3_nrpt WHERE UNIT_CODE = :UNIT_CODE";
$stmt=$db->prepare($sql);
$stmt->bindparam(':UNIT_CODE',$UNIT_CODE);
$stmt->execute();
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    $UNIT_CODE = $row['UNIT_CODE'];
    $NRPT_NAME = $row['NRPT_NAME'];
    $NRPT_ACM = $row['NRPT_ACM'];
    $NRPT_NUNIT = $row['NRPT_NUNIT'];
    $NRPT_NPAGE = $row['NRPT_NPAGE'];
    $NRPT_DMYUPD = $row['NRPT_DMYUPD'];
    $NRPT_UNIT_PARENT = $row['NRPT_UNIT_PARENT'];
    $NRPT_USER = $row['NRPT_USER'];
}

$sql2 = "SELECT * FROM j3_unit WHERE UNIT_CODE LIKE '%$SUB_UNIT%'";
$stmt2=$db->prepare($sql2);
$stmt2->bindparam(':SUB_UNIT',$SUB_UNIT);
$stmt2->execute();
$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
$UNIT_NAME = $row2['UNIT_NAME'];
$UNIT_ACM =$row2['UNIT_ACM'];
$UNIT_PROV =$row2['UNIT_PROV'];
$UNIT_DMY =$row2['UNIT_DMY'];
$UNIT_AJY_ACK = $row2['UNIT_AJY_ACK'];
$UNIT_NAJY_NACK = $row2['UNIT_NAJY_NACK'];
$UNIT_DIRECT_PAY = $row2['UNIT_DIRECT_PAY'];

$DMY = substr($UNIT_DMY,0,2);
$DMY2 = substr($UNIT_DMY,2,2);
$DMY3 = substr($UNIT_DMY,4,4);

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
                <div class="card-body">
                    <section class="content">
                        <div class="container-fluid">
                            <form action="detail_ack.php" method="POST">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div style="text-vlign: center;">
                                            <div class="row">
                                                <label style="text-vlign: center;">อจย./อฉก. :</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="ACK_ID" value = "<?=$UNIT_AJY_ACK?>" readonly>
                                                </div>
                                                &nbsp;
                                                <label>หมายเลข :</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="ACK_ID" value = "<?=$UNIT_NAJY_NACK?>" readonly>
                                                </div>
                                                &nbsp;
                                                <label>ว/ด/ป อนุมัติ :</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="UNIT_DMY" value="<?=$DMY;?>/<?=$DMY2;?>/<?=$DMY3?>" readonly>
                                                </div>
                                                &nbsp;
                                                <label>อสอ. :</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="ACK_ID" readonly>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label>นามหน่วยเต็ม</label>
                                                    <input type="text" class="form-control" name="UNIT_NAME" value="<?=$UNIT_NAME?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label>นามหน่วยย่อ</label>
                                                    <input type="text" class="form-control" name="UNIT_ACM" value="<?=$UNIT_ACM?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label>จว.ที่ตั้ง</label>
                                                    <input type="text" class="form-control" name="UNIT_PROV" value="<?=$UNIT_PROV?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label>ว/ด/ป อนุมัติ</label>
                                                    <input type="text" class="form-control" name="UNIT_DMY" value="<?=$DMY;?>/<?=$DMY2;?>/<?=$DMY3?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label>รหัสหน่วย</label>
                                                    <input type="text" class="form-control" name="UNIT_CODE_PARENT"
                                                        value="<?=$UNIT_CODE?>" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" name="UNIT_ACM_ID" value="<?=$UNIT_ACM_ID?>">
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label>รหัสหน่วยกรมบัญชีกลาง</label>
                                                    <input type="text" class="form-control" name="ACK_ESSENCE" value="<?=$UNIT_DIRECT_PAY?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label>วัน-เวลา ณ ทำรายการล่าสุด</label>
                                                    <input type="text" class="form-control" name="ACK_TIMESTAMP"
                                                        value="<?=date('d/m/Y H:i:s') ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <label>ผู้ทำรายการ</label>
                                                    <input type="text" class="form-control" name="ACK_USER" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-1">
                                                <div class="form-group">
                                                    <label>เวอร์ชัน</label>
                                                    <input type="text" class="form-control" name="ACK_VERSION" value="1" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </from>
                        </div>
                    </section>
                    <?php
										if($UNIT_CODE == "6110000000"){
											echo'<table id="example1" class="table table-bordered table-striped">
												<thead class="bg-info">                                                        
													<tr>
														<th style="text-align: center;">ประเภท</th>
														<th style="text-align: center;">สัญญาบัตร</th>
														<th style="text-align: center;">ประทวน</th>
														<th style="text-align: center;">พลอาสาสมัคร</th>
														<th style="text-align: center;">พลทหาร</th>
														<th style="text-align: center;">ลูกจ้างประจำ</th>
														<th style="text-align: center;">พนักงานราชการ</th>
													</tr>
												</thead>
												<tbody>';
													
		
															$sql_u = "SELECT * FROM j3_unit WHERE UNIT_CODE LIKE '%$SUB_UNIT%'";
															$stmt_u=$db->prepare($sql_u);
															$stmt_u->bindparam(':SUB_UNIT',$SUB_UNIT);
															$stmt_u->execute();
															$row_u=$stmt_u->fetch(PDO::FETCH_ASSOC);
															//while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																$UNIT_COF_FULL = $row_u['UNIT_COF_FULL'];//สัญญา
																$UNIT_COF_FILL = $row_u['UNIT_COF_FILL'];
																$UNIT_COF_REAL = $row_u['UNIT_COF_REAL'];
																$UNIT_NCO_FULL = $row_u['UNIT_NCO_FULL'];//ประทวน
																$UNIT_NCO_FILL = $row_u['UNIT_NCO_FILL'];
																$UNIT_NCO_REAL = $row_u['UNIT_NCO_REAL'];
																$UNIT_PVT_FULL = $row_u['UNIT_PVT_FULL'];//พลอาสา
																$UNIT_PVT_FILL = $row_u['UNIT_PVT_FILL'];
																$UNIT_PVT_REAL = $row_u['UNIT_PVT_REAL'];
																$UNIT_EMPY_FULL = $row_u['UNIT_EMPY_FULL'];//ลูกจ้างประจำ
																$UNIT_EMPY_FILL = $row_u['UNIT_EMPY_FILL'];
																$UNIT_EMPY_REAL = $row_u['UNIT_EMPY_REAL'];
																$UNIT_TEMP_FULL = $row_u['UNIT_TEMP_FULL'];//ลูกจ้างชั่ว
																$UNIT_TEMP_FILL = $row_u['UNIT_TEMP_FILL'];
																$UNIT_TEMP_REAL = $row_u['UNIT_TEMP_REAL'];
																$UNIT_PVTT_FULL = $row_u['UNIT_PVTT_FULL'];//พลทหาร
																$UNIT_PVTT_FILL = $row_u['UNIT_PVTT_FILL'];
																$UNIT_PVTT_REAL = $row_u['UNIT_PVTT_REAL'];
																$UNIT_CODE_KP = $row_u['UNIT_CODE'];
																//echo $UNIT_CODE_KP;
															//}
															
																echo'<tr>
																	<tr>
																		<th class="bg-info" style="width: 100px; text-align: center;">อัตราเต็ม</th>
																		<td style="width: 100px; text-align: center;">'.$UNIT_COF_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_NCO_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVT_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVTT_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_EMPY_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_TEMP_FULL.'</td>
																	</tr>
																	<tr>
																		<th class="bg-info" style="width: 100px; text-align: center;">อัตราอนุมัติ</th>
																		<td style="width: 100px; text-align: center;">'.$UNIT_COF_FILL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_NCO_FILL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVT_FILL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVTT_FILL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_EMPY_FILL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_TEMP_FILL.'</td>
																	</tr>
																	<tr>
																		<th class="bg-info" style="width: 100px; text-align: center;">บรรจุจริง</th>
																		<td style="width: 100px; text-align: center;">'.$UNIT_COF_REAL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_NCO_REAL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVT_REAL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVTT_REAL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_EMPY_REAL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_TEMP_REAL.'</td>
																	</tr>
																</tr>';
															
																									
												echo'</tbody>
											</table>';
										}else{
											echo'<table id="example1" class="table table-bordered table-striped">
												<thead class="bg-info">                                                        
													<tr>
														<th style="text-align: center;">ประเภท</th>
														<th style="text-align: center;">สัญญาบัตร</th>
														<th style="text-align: center;">ประทวน</th>
														<th style="text-align: center;">พลอาสาสมัคร</th>
														<th style="text-align: center;">พลทหาร</th>
													</tr>
												</thead>
												<tbody>';
													
	
															$sql_u = "SELECT * FROM j3_unit WHERE UNIT_CODE LIKE '%$SUB_UNIT%'";
															$stmt_u=$db->prepare($sql_u);
															$stmt_u->bindparam(':SUB_UNIT',$SUB_UNIT);
															$stmt_u->execute();
															$row_u=$stmt_u->fetch(PDO::FETCH_ASSOC);
															//while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																$UNIT_COF_FULL = $row_u['UNIT_COF_FULL'];//สัญญา
																$UNIT_COF_FILL = $row_u['UNIT_COF_FILL'];
																$UNIT_COF_REAL = $row_u['UNIT_COF_REAL'];
																$UNIT_NCO_FULL = $row_u['UNIT_NCO_FULL'];//ประทวน
																$UNIT_NCO_FILL = $row_u['UNIT_NCO_FILL'];
																$UNIT_NCO_REAL = $row_u['UNIT_NCO_REAL'];
																$UNIT_PVT_FULL = $row_u['UNIT_PVT_FULL'];//พลอาสา
																$UNIT_PVT_FILL = $row_u['UNIT_PVT_FILL'];
																$UNIT_PVT_REAL = $row_u['UNIT_PVT_REAL'];
																$UNIT_EMPY_FULL = $row_u['UNIT_EMPY_FULL'];//ลูกจ้างประจำ
																$UNIT_EMPY_FILL = $row_u['UNIT_EMPY_FILL'];
																$UNIT_EMPY_REAL = $row_u['UNIT_EMPY_REAL'];
																$UNIT_TEMP_FULL = $row_u['UNIT_TEMP_FULL'];//ลูกจ้างชั่ว
																$UNIT_TEMP_FILL = $row_u['UNIT_TEMP_FILL'];
																$UNIT_TEMP_REAL = $row_u['UNIT_TEMP_REAL'];
																$UNIT_PVTT_FULL = $row_u['UNIT_PVTT_FULL'];//พลทหาร
																$UNIT_PVTT_FILL = $row_u['UNIT_PVTT_FILL'];
																$UNIT_PVTT_REAL = $row_u['UNIT_PVTT_REAL'];
																$UNIT_CODE_KP = $row_u['UNIT_CODE'];
																//echo $UNIT_CODE_KP;
															//}
																echo'<tr>
																	<tr>
																		<th class="bg-info" style="width: 100px; text-align: center;">อัตราเต็ม</th>
																		<td style="width: 100px; text-align: center;">'.$UNIT_COF_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_NCO_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVT_FULL.'</td>
																		<td style="width: 100px; text-align: center;">'.$UNIT_PVTT_FULL.'</td>
																	</tr>
																</tr>';
															
																									
												echo'</tbody>
											</table>';
										}
									?>
                </div>
                <div class="card-body">
                    <button class="tablink" onmouseover="openPage('Home1', this, 'white')">
                        <font style="font-weight: bold; font-size: 18px;">นามหน่วยถือทำเนียบ</font>
                    </button>
                    <button class="tablink" onmouseover="openPage('Sturc1', this, 'white')">
                        <font style="font-weight: bold; font-size: 18px;">นามหน่วยพิมพ์</font>
                    </button>
                    <button class="tablink" onmouseover="openPage('News1', this, 'white')">
                        <font style="font-weight: bold; font-size: 18px;">ทำเนียบกำลังพล</font>
                    </button>

                    <div id="Home1" class="tabcontent">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="width: 1500px;">
								<tbody>
									<?php                                                        
										echo'<tr>
											<th class="bg-info" rowspan="2" style="width: 150px; text-align: center; vertical-align: middle">สัญญาบัตร</th>';

																$sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost
																WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE 
																GROUP BY ROST_RANK ORDER BY ROST_RANK";
																$stmt2=$db->prepare($sql2);
																//$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
																$stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
																$stmt2->execute();
																while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																	$COUNT = $row2['COUNT(ROST_ID)'];
																	$ROST_RANK = $row2['ROST_RANK'];
																	$ROST_RANKNAME = $row2['ROST_RANKNAME'];

																$sql14= "SELECT * FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
																$stmt14=$db->prepare($sql14);
																$stmt14->bindparam(':ROST_RANK',$ROST_RANK);
																$stmt14->execute();		
																$row79=$stmt14->fetch(PDO::FETCH_ASSOC);

																$RANK_NAME = $row79['ROST_RANKNAME'];
																				

																	if($ROST_RANK == "02" || $ROST_RANK == "03" || $ROST_RANK == "04" || $ROST_RANK == "05" || $ROST_RANK == "06"
																	|| $ROST_RANK == "07" || $ROST_RANK == "08" || $ROST_RANK == "09" || $ROST_RANK == "10"){




																		echo '<th class="bg-info" style="width: 100px; text-align: center">'.$RANK_NAME.'</th>';
																		
																		
																	}
																}

				

															echo'<th class="bg-info" style="text-align: center;">รวม</th>
															<tr>';

																	$stmt2->execute();
																	$SUM = "0";
																	while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																		$COUNT = $row2['COUNT(ROST_ID)'];
																		$ROST_RANK = $row2['ROST_RANK'];

																		
																		//echo $ROST_RANK;

																		if($ROST_RANK == "02" || $ROST_RANK == "03" || $ROST_RANK == "04" || $ROST_RANK == "05" || $ROST_RANK == "06"
																		|| $ROST_RANK == "07" || $ROST_RANK == "08" || $ROST_RANK == "09" || $ROST_RANK == "10"){
																			echo '<td style="width: 100px; text-align: center">
																				<input type="text" class="form-control" name="CRAK" value="'.$COUNT.'">
																			</td>';
																			
																			$SUM = $SUM+$COUNT;
																		}
																	}
																echo'<td style="width: 100px; text-align: center"><input type="text" class="form-control" name="CRAK" value="'.$SUM.'"></td>
																
															</tr>
														</tr>';
									?>
								</tbody>
								<tbody>
									<?php
										echo'<tr>
											<th class="bg-info" rowspan="2" style="width: 150px; text-align: center; vertical-align: middle">ประทวน</th>';
															
									
																	$sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost
																	WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE 
																	GROUP BY ROST_RANK ORDER BY ROST_RANK";
																	$stmt2=$db->prepare($sql2);
																	//$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
																	$stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
																	$stmt2->execute();
																	$SUM = "0";
																	while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																		$COUNT = $row2['COUNT(ROST_ID)'];
																		$ROST_RANK = $row2['ROST_RANK'];
																		$ROST_RANKNAME = $row2['ROST_RANKNAME'];

																		$sql15= "SELECT * FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
																		$stmt15=$db->prepare($sql15);
																		$stmt15->bindparam(':ROST_RANK',$ROST_RANK);
																		$stmt15->execute();		
																		$row80=$stmt15->fetch(PDO::FETCH_ASSOC);

																		$RANK_NAME = $row80['ROST_RANKNAME'];
																		//echo $ROST_RANK;

																		if($ROST_RANK == "21" || $ROST_RANK == "22" || $ROST_RANK == "25"){
																			
																			echo '<th class="bg-info" style="width: 100px; text-align: center">'.$RANK_NAME.'</th>';
																		}
																	}
															
															echo'<th class="bg-info" style="text-align: center;">รวม</th>
															<tr>';
																
																	$stmt2->execute();
																	$SUM = "0";
																	while($row78=$stmt2->fetch(PDO::FETCH_ASSOC)){
																		$COUNT = $row78['COUNT(ROST_ID)'];
																		$ROST_RANK = $row78['ROST_RANK'];
																		//echo $ROST_RANK;

																		if($ROST_RANK == "21" || $ROST_RANK == "22" || $ROST_RANK == "25"){
																			
																			echo '<td style="width: 100px; text-align: center">
																				<input type="text" class="form-control" name="CRAK" value="'.$COUNT.'">
																			</td>';
																			$SUM = $SUM+$COUNT;
																		}
																	}
																
																echo'<td style="width: 100px; text-align: center">
																	<input type="text" class="form-control" name="CRAK" value="'.$SUM.'">
																</td>
															</tr>
														</tr>';
									?>                                                 
								</tbody>
								<tbody>                                                        
													<tr>
														<th class="bg-info" style="text-align: center; vertical-align: middle">พลอาสาสมัคร</th>
														<?php
															
															$sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost
															WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE 
															GROUP BY ROST_RANK ORDER BY ROST_RANK";
															$stmt2=$db->prepare($sql2);
															//$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
															$stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
															$stmt2->execute();
															$SUM = "0";
															while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																$COUNT = $row2['COUNT(ROST_ID)'];
																$ROST_RANK = $row2['ROST_RANK'];
																//echo $ROST_RANK;

																if($ROST_RANK == "31"){
																	$SUM = $SUM+$COUNT;
																	
																}
															}
														?>
														<td style="width: 100px; text-align: center">
															<input type="text" class="form-control" name="CRAK" value="<?=$SUM?>">
														</td>
													</tr>
												</tbody>
                                                <?php
                                                    if($UNIT_CODE == "6110000000"){
                                                        echo'<tbody>
                                                            <tr>
                                                                <th class="bg-info" style="text-align: center; vertical-align: middle">ลูกจ้างประจำ</th>';
                                                                
                                                                    include ('connectpdo.php');
                                                                    $sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost
                                                                    WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE
                                                                    GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                                                    $stmt2=$db->prepare($sql2);
                                                                    //$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
                                                                    $stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
                                                                    $stmt2->execute();
                                                                    $SUM = "0";
                                                                    while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                                                                        $COUNT = $row2['COUNT(ROST_ID)'];
                                                                        $ROST_RANK = $row2['ROST_RANK'];
                                                                    

                                                                        if($ROST_RANK == "50" || $ROST_RANK =="51"){
                                                                            $SUM = $SUM+$COUNT;
                                                                            
                                                                        }
                                                                    }
                                                                
                                                                echo'<td style="width: 100px; text-align: center">
                                                                    <input type="text" class="form-control" name="CRAK" value="<?=$SUM?>">
                                                                </td>
                                                            </tr>                                                   
                                                        </tbody>';  
                                                    }    
                                                ?>
												<tbody>
													<tr>
														<th class="bg-info" style="text-align: center; vertical-align: middle">พลทหาร</th>
														<?php
														
															$sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost
															WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE
															GROUP BY ROST_RANK ORDER BY ROST_RANK";
															$stmt2=$db->prepare($sql2);
															//$stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
															$stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
															$stmt2->execute();
															$SUM = "0";
															while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
																$COUNT = $row2['COUNT(ROST_ID)'];
																$ROST_RANK = $row2['ROST_RANK'];
																

																if($ROST_RANK == "32"){
																	$SUM = $SUM+$COUNT;
																}
															}
														?>
														<td style="width: 100px; text-align: center">
															<input type="text" class="form-control" name="CRAK" value="<?=$SUM?>">
														</td>
													</tr>                                                   
												</tbody>
											</table>
                    
                        </div>
                        <!--<iframe
                            src="iframe_detail_ii_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE_1;?>&nickname=<?=$UNIT_CODE_2;?>&lastname=<?=$UNIT_CODE_3?>"
                            frameborder="0" width="100%" height="1000" scrolling="yes">
                        </iframe>-->
                    </div>
                    <div id="Sturc1" class="tabcontent">
                    <?php
							
											$sql3 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT_CODE AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900)";
											$stmt3=$db->prepare($sql3);
											//echo($sql3);
											$stmt3->bindparam(':UNIT_CODE',$UNIT_CODE);
											$stmt3->execute();
												$i = "0";
												while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
												
													$SUB1 = substr($row3['UNIT_CODE'],6);
													
													// if($SUB1 != "0001" && $SUB1 != "0002" && $SUB1 != "0003" && $SUB1 != "9999" && $SUB1 != "9998"  && $SUB1 != "0900"){
													// 	if($row3['NRPT_UNIT_PARENT'] == $UNIT_CODE_2){
															$UNIT3 = $row3['UNIT_CODE'];
															$SUB = substr($UNIT_CODE,0,2);
															$i++;
															echo '
																<div class="card card-outline card-success">
																	<div class="card-header">
																		<div class="card-body">
																			<div class="row">
																				<label style="text-align: center;">รหัสหน่วย :</label>
																				<div class="col-sm-2" style="text-align: center;">
																					<input type="text" class="form-control" value="'.$UNIT3.'" disabled>   
																				</div> 
																				<label>รหัสส่วนราชการ :</label>
																				<div class="col-sm-1" style="text-align: center;">
																					<input type="text" class="form-control" value="'.$SUB.'" disabled>
																				</div>
																				<label>ลำดับที่ :</label>
																				<div class="col-sm-1">
																					<input type="text" class="form-control" value="" disabled>
																				</div>
																				<label>รหัสหน่วยใหม่ :</label>
																				<div class="col-sm-2">
																					<input type="text" class="form-control" value="'.$UNIT3.'" disabled>
																				</div>
																				<label>รหัสหน่วยขึ้นหน้าใหม่ :</label>
																				<div class="col-sm-1">
																					<input type="text" class="form-control" value="" disabled>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="card-body">
																		<div class="row">
																			<div class="col-12 col-sm-6">
																				<div class="form-group">
																					<label>นามหน่วยเต็ม</label>
																					<input type="text" class="form-control" name="NRPT_NAME" value="'.$row3['NRPT_NAME'].'" readonly>
																				</div>
																			</div>
																			<div class="col-12 col-sm-6">
																				<div class="form-group">
																					<label>นามหน่วยภาษาอังกฤษ</label>
																					<input type="text" class="form-control" name="UNIT_CODE" readonly>
																				</div>
																			</div>
																			<div class="col-12 col-sm-6">
																				<div class="form-group">
																					<label>นามหน่วยย่อ</label>
																					<input type="text" class="form-control" name="NRPT_ACM" value="'.$row3['NRPT_ACM'].'" readonly>
																				</div>
																			</div>
																			<div class="col-12 col-sm-6">
																				<div class="form-group">
																					<label>นามหน่วยภาษาอังกฤษย่อ</label>
																					<input type="text" class="form-control" name="UNIT_NAME" readonly>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>';
																$sql7 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT3 AND UNIT_CODE != :UNIT_CODE AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900)";
																$stmt7=$db->prepare($sql7);
																$stmt7->bindparam(':UNIT3',$UNIT3);
																$stmt7->bindparam(':UNIT_CODE',$UNIT_CODE);
																$stmt7->execute();
																$row7=$stmt7->fetch(PDO::FETCH_ASSOC);
																							
																if($row7['NRPT_UNIT_PARENT'] == $UNIT3){
																	$stmt7->execute();
																	while($row7=$stmt7->fetch(PDO::FETCH_ASSOC)){
																		$parent1 = $row7['NRPT_UNIT_PARENT'];
																			if($row7['NRPT_UNIT_PARENT'] == $UNIT3){
																				$UNIT4 = $row7['UNIT_CODE'];
																										
																				echo '<div class="card card-outline card-danger">
																				<div class="card-body">
																					<div class="card-header">
																						<div class="card-body">
																							<div class="row">
																								<label style="text-align: center;">รหัสหน่วย :</label>
																								<div class="col-sm-2" style="text-align: center;">
																									<input type="text" class="form-control" value="'.$UNIT4.'" disabled>   
																								</div> 
																								<label>รหัสส่วนราชการ :</label>
																								<div class="col-sm-1" style="text-align: center;">
																									<input type="text" class="form-control" value="'.$SUB.'" disabled>
																								</div>
																								<label>ลำดับที่ :</label>
																								<div class="col-sm-1">
																									<input type="text" class="form-control" value="" disabled>
																								</div>
																								<label>รหัสหน่วยใหม่ :</label>
																								<div class="col-sm-2">
																									<input type="text" class="form-control" value="'.$UNIT4.'" disabled>
																								</div>
																								<label>รหัสหน่วยขึ้นหน้าใหม่ :</label>
																								<div class="col-sm-1">
																									<input type="text" class="form-control" value="" disabled>
																								</div>
																							</div>
																						</div>
																					</div>
																					<br>
																					<div class="row">
																						<div class="col-12 col-sm-6">
																							<div class="form-group">
																								<label>นามหน่วยเต็ม</label>
																								<input type="text" class="form-control" name="NRPT_NAME" value="'.$row7['NRPT_NAME'].'" readonly>
																							</div>
																						</div>
																						<div class="col-12 col-sm-6">
																							<div class="form-group">
																								<label>นามหน่วยภาษาอังกฤษ</label>
																								<input type="text" class="form-control" name="UNIT_CODE" readonly>
																							</div>
																						</div>
																						<div class="col-12 col-sm-6">
																							<div class="form-group">
																								<label>นามหน่วยย่อ</label>
																								<input type="text" class="form-control" name="NRPT_ACM" value="'.$row7['NRPT_ACM'].'" readonly>
																							</div>
																						</div>
																						<div class="col-12 col-sm-6">
																							<div class="form-group">
																								<label>นามหน่วยภาษาอังกฤษย่อ</label>
																								<input type="text" class="form-control" name="UNIT_NAME" readonly>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>';
																										
																		}
																	}
																}
															}
													// 	}	
													// }
												?>
                    </div>
                    <div id="News1" class="tabcontent">
                        <iframe
                            src="iframe_unit_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE_1;?>&nickname=<?=$UNIT_CODE_2;?>&lastname=<?=$UNIT_CODE_3?>"
                            frameborder="0" width="100%" height="1000" scrolling="yes"></iframe>
                    </div>
                </div>          
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
    <style>
    * {
        box-sizing: border-box
    }

    /* Set height of body and the document to 100% */
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial;
    }

    /* Style tab links */
    .tablink {
        background-color: #87cefa;
        color: black;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        font-size: 17px;
        width: 20%;
    }

    .tablink:hover {
        background-color: #79CDCD;
    }

    /* Style the tab content (and add height:100% for full page content) */
    .tabcontent {
        color: #555;
        display: none;
        padding: 100px 20px;
        height: 100%;
    }
    </style>

<style>
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}
</style>
<script>
	function openPage(pageName,elmnt,color) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablink");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].style.backgroundColor = "";
		}
		document.getElementById(pageName).style.display = "block";
		elmnt.style.backgroundColor = color;
	}
    document.getElementById("defaultOpen").click();
    </script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <?php
      include ('path/script.php');
    ?>

</body>

</html>