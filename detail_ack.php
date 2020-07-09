<?php
session_start();
include ('db/connectpdo.php');

$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];

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

$SUB_UNIT = substr($UNIT_CODE, 5, 10);
$SUB_S = substr($SUB_UNIT,0,1);

?>

<!DOCTYPE html>
<html>
<head>
    <?php
		include ('path/head.php');
	?>
            <link rel="stylesheet" href="css/tree1.css">
        <link rel="stylesheet" href="css/tree.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper"><?php include ('path/navbar.php'); ?>
		<?php
      		include ('path/sidebar.php');
    	?>
			
			<div class="content-wrapper">
				<div class="main-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<?php
											if($SUB_S > 0){
												?>
												
												<button class="tablink" onmouseover="openPage('Home', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">กล่าวทั่วไป</font></button>
												<button class="tablink" onmouseover="openPage('Sturc', this, 'white')"><font style="font-weight: bold; font-size: 18px;">ผังการจัด</font></button>
												<button class="tablink" onmouseover="openPage('News', this, 'white')"><font style="font-weight: bold; font-size: 18px;">อัตรากำลังพล</font></button>
												<button class="tablink" onmouseover="openPage('About', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">อัตรายุทโธปกรณ์</font></button>
											<?php }else{ ?>
												<button class="tablink" onmouseover="openPage('Home', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">กล่าวทั่วไป</font></button>
												<button class="tablink" onmouseover="openPage('Sturc', this, 'white')"><font style="font-weight: bold; font-size: 18px;">ผังการจัด</font></button>
												<button class="tablink" onmouseover="openPage('News', this, 'white')"><font style="font-weight: bold; font-size: 18px;">อัตรากำลังพล</font></button>
												<button class="tablink" onmouseover="openPage('Contact', this, 'white')"><font style="font-weight: bold; font-size: 18px;">คำชี้แจง</font></button>
												<button class="tablink" onmouseover="openPage('About', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">อัตรายุทโธปกรณ์</font></button>
											<?php }
										?>
										<!-- <button class="tablink" onmouseover="openPage('Home', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">กล่าวทั่วไป</font></button>
										<button class="tablink" onmouseover="openPage('Sturc', this, 'white')"><font style="font-weight: bold; font-size: 18px;">ผังการจัด</font></button>
										<button class="tablink" onmouseover="openPage('News', this, 'white')"><font style="font-weight: bold; font-size: 18px;">อัตรากำลังพล</font></button>
										<button class="tablink" onmouseover="openPage('Contact', this, 'white')"><font style="font-weight: bold; font-size: 18px;">คำชี้แจง</font></button>
										<button class="tablink" onmouseover="openPage('About', this, 'white')" ><font style="font-weight: bold; font-size: 18px;">อัตรายุทโธปกรณ์</font></button> -->
										
										<?php

										$sql2 = "SELECT ACK_MISSION,ACK_DISTRIBUTION,ACK_SCOPE,ACK_DIVISION,ACK_EXPLANATION FROM j3_ack WHERE UNIT_ACM_ID = :NRPT_UNIT_PARENT";
										$stmt2=$db->prepare($sql2);
										$stmt2->bindparam(':NRPT_UNIT_PARENT',$NRPT_UNIT_PARENT); 
										$stmt2->execute();
										$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
										$ACK_M = $row2['ACK_MISSION'];
										$ACK_D = $row2['ACK_DISTRIBUTION'];
										$ACK_S = $row2['ACK_SCOPE'];
										$ACK_DV = $row2['ACK_DIVISION'];
										$ACK_E = $row2['ACK_EXPLANATION'];
										?>

										<div id="Home" class="tabcontent">
											<?php
												if($SUB_S > 0){
													echo '
													<a href="report_ajy_rost.php?id='.$UNIT_CODE.'><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> กล่าวทั่วไป</button></a><br><br>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ภารกิจ :</font></label>
														<textarea class="form-control" id="editor" rows="4" name="ACK_MISSION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_M.'</textarea>
													</div>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">การแบ่งมอบ :</font></label>
														<textarea class="form-control" id="editor1" rows="4" name="ACK_DISTRIBUTION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_D.'</textarea>
													</div>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ขีดความสามรถ :</font></label>
														<textarea class="form-control" id="editor2" rows="4" name="ACK_SCOPE" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_S.'</textarea>
													</div>';
												}else{
													echo '
													<a href="report_ack_rost.php?id='.$UNIT_CODE.'><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> กล่าวทั่วไป</button></a><br><br>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ภารกิจ :</font></label>
														<textarea class="form-control" id="editor" rows="4" name="ACK_MISSION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_M.'</textarea>
													</div>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">การแบ่งมอบ :</font></label>
														<textarea class="form-control" id="editor1" rows="4" name="ACK_DISTRIBUTION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_D.'</textarea>
													</div>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ขอบเขตความรับผิดชอบและหน้าที่ :</font></label>
														<textarea class="form-control" id="editor2" rows="4" name="ACK_SCOPE" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_S.'</textarea>
													</div>
													<div class="form-group">
														<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">การแบ่งส่วนราชการและหน้าที่ :</font></label>
														<textarea class="form-control" id="editor3" rows="4" name="ACK_DIVISION" style="border-width:1px; border-color: gray;font-weight: bold; font-size: 18px;" DISABLED>'.$ACK_DV.'</textarea>
													</div>';
												}
											?>
											<!-- <a href="export_word.php?id=<?=$ACK_NUM_ID?>"><button type="button" class="btn btn-primary"><i class="fas fa-file-word"></i> กล่าวทั่วไป</button></a>
											<a href="report_ack_rost.php?id=<?=$UNIT_CODE?>"><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> กล่าวทั่วไป</button></a><br><br>
											<div class="form-group">
												<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ภารกิจ :</font></label>
												<textarea class="form-control" id="editor" rows="4" name="ACK_MISSION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED><?=$ACK_M?></textarea>
											</div>
											<div class="form-group">
												<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">การแบ่งมอบ :</font></label>
												<textarea class="form-control" id="editor1" rows="4" name="ACK_DISTRIBUTION" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED><?=$ACK_D?></textarea>
											</div>
											<div class="form-group">
												<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ขอบเขตความรับผิดชอบและหน้าที่ :</font></label>
												<textarea class="form-control" id="editor2" rows="4" name="ACK_SCOPE" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED><?=$ACK_S?></textarea>
											</div>
											<div class="form-group">
												<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">การแบ่งส่วนราชการและหน้าที่ :</font></label>
												<textarea class="form-control" id="editor3" rows="4" name="ACK_DIVISION" style="border-width:1px; border-color: gray;font-weight: bold; font-size: 18px;" DISABLED><?=$ACK_DV?></textarea>
											</div> -->
										</div>

										<div id="Sturc" class="tabcontent">
											<a href="report2_tree.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE;?>&nickname=<?=$UNIT_CODE;?>&lastname=<?=$UNIT_CODE?>"><button type="button" class="btn btn-warning"><i class="fas fa-print"></i> ผังการจัด</button></a><br><br>
											<div style="text-align: center;" id="capture">
											<section class="basic-style">
														        <div class="hv-container">
														            <div class="hv-wrapper">
														                <div class="hv-item">



															<?php


																$sql = "SELECT * FROM j3_nrpt WHERE UNIT_CODE LIKE '".$UNIT_CODE."' ";
																$stmt=$db->prepare($sql);
																$stmt->execute();
																while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

																	$UNIT_CODE_TREE = $row['UNIT_CODE'];
																	$NRPT_NAME_TREE = $row['NRPT_NAME'];
																	$NRPT_UNIT_PARENT_TREE = $row['NRPT_UNIT_PARENT'];

																	$NRPT_NAME = explode(' ', $row['NRPT_NAME']);
																	$NRPT_NAME = $NRPT_NAME[0];



															?>		
														                    <div class="hv-item-parent">
														                        <p class="simple-card" style="font-color: black;"><?=$NRPT_NAME?></p>
														                    </div>

														    <?php  }  ?>


														                    <div class="hv-item-children">

														    <?php
														    
														    	$sql1 = "SELECT *  FROM `j3_nrpt` WHERE NRPT_UNIT_PARENT = :UNIT_CODE_TREE  AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) AND UNIT_CODE != :UNIT_CODE ";
																$stmt1=$db->prepare($sql1);
																$stmt1->bindparam(':UNIT_CODE_TREE',$UNIT_CODE_TREE);
																$stmt1->bindparam(':UNIT_CODE',$UNIT_CODE);
																$stmt1->execute();
																while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){

																$NRPT_NAME_1 = $row1['NRPT_NAME'];
																$NRPT_UNIT_PARENT_1 = $row1['NRPT_UNIT_PARENT'];

																$NRPT_NAME_1 = explode(' ', $row1['NRPT_NAME']);
																$NRPT_NAME_1 = $NRPT_NAME_1[0];


														    ?>                	

														                        <div class="hv-item-child">
														                            <p class="simple-card"><?=$NRPT_NAME_1?></p>
														                        </div>
														    <?php } ?>
														                    </div>
														                </div>
														            </div>
														        </div>
															</section>
															
											
											</div>
										</div>

										<div id="News" class="tabcontent"> 
											<?php
					
													$sql = "SELECT COUNT(*) FROM j3_rost 
															WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE_1 OR ROST_UNIT = :UNIT_CODE_2 OR ROST_PARENT = :UNIT_CODE_3";
													$stmt=$db->prepare($sql);
													$stmt->bindparam(':UNIT_CODE',$UNIT_CODE);
													$stmt->bindparam(':UNIT_CODE_1',$UNIT_CODE_1);
													$stmt->bindparam(':UNIT_CODE_2',$UNIT_CODE_2);
													$stmt->bindparam(':UNIT_CODE_3',$UNIT_CODE_3);
													$stmt->execute();
													$row1=$stmt->fetch(PDO::FETCH_ASSOC);
								
													$ROST_SUMC = $row1['COUNT(*)'];
													//echo $SUB_S;
											?>
											<div class="card-body">
                                            	<div class="row">
	                                                <div class="col-md-6">
														<?php
															if($SUB_S > 0){
																echo '
																<a href="report_sum_ajy.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-primary"><i class="fas fa-file-pdf"></i> อัตรากำลังพลตามตำแหน่ง</button></a>
																<a href="report_iframe_ajy.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามตำแหน่ง</button></a>
																<a href="report_sum_p_ajy.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามชั้นยศ</button></a>';
															}else{
																echo '
																<a href="report_sum_ack.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-primary"><i class="fas fa-file-pdf"></i> อัตรากำลังพลตามตำแหน่ง</button></a>
																<a href="report_iframe_ack.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามตำแหน่ง</button></a>
																<a href="report_sum_p_ack.php?id='.$UNIT_CODE.'&name='.$UNIT_CODE.'&nickname='.$UNIT_CODE.'&lastname='.$UNIT_CODE.'"><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามชั้นยศ</button></a>';
															}
														?>
														<!-- <a href="report_sum_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE;?>&nickname=<?=$UNIT_CODE;?>&lastname=<?=$UNIT_CODE?>"><button type="button" class="btn btn-primary"><i class="fas fa-file-pdf"></i> อัตรากำลังพลตามตำแหน่ง</button></a>
													    <a href="report_iframe_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE;?>&nickname=<?=$UNIT_CODE;?>&lastname=<?=$UNIT_CODE?>"><button type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามตำแหน่ง</button></a>
													    <a href="report_sum_p_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE;?>&nickname=<?=$UNIT_CODE;?>&lastname=<?=$UNIT_CODE?>"><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i> สรุปยอดอัตราตามชั้นยศ</button></a> -->
	                                                	</form>
	                                                </div>
                                                <div class="col-12 col-md-6" style="vertical-align: right;"
                                                    align="right">
                                                    <ul class="list-group" style="max-width: 200px;">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            ยอดอัตราเต็ม : <span
                                                                class="badge badge-primary badge-pill"><?=$ROST_SUMC;?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
											<iframe src="iframe_detail_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE_1;?>&nickname=<?=$UNIT_CODE_2;?>&lastname=<?=$UNIT_CODE_3?>" frameborder="0" width="100%" height="1000" scrolling="yes"></iframe>
										</div>

										<div id="Contact" class="tabcontent">
											<div class="col-md-6">
												<a href="report_4_rost.php?id=<?=$UNIT_CODE?>"><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf" aria-hidden="true"> คำชี้แจง</i></button></a>
											</div>
											&nbsp;
											<div class="form-group">
												<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">ภารกิจ :</font></label>
												<textarea class="form-control" id="editor4" rows="4" name="ACK_DIVISION" style="border-width:1px; border-color: gray;font-weight: bold; font-size: 18px;" DISABLED><?=$ACK_E?></textarea>
											</div>	
										</div>

										<div id="About" class="tabcontent">
											<?php

								
												$sql3 = "SELECT COUNT(*) FROM j3_rateitem";
												$stmt3=$db->prepare($sql3);
												$stmt3->execute();
												$row3=$stmt3->fetch(PDO::FETCH_ASSOC);

												$RATE_SUM = $row3['COUNT(*)'];

											?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!--<button type="button" class="btn btn-info"><i
                                                            class="fas fa-file-word" aria-hidden="true">
                                                            พิมพ์</i></button>-->
                                                </div>
                                                <div class="col-12 col-md-6" style="vertical-align: right;"
                                                    align="right">
                                                    <ul class="list-group" style="max-width: 200px;">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            ยอดอัตราเต็ม : <span
                                                                class="badge badge-primary badge-pill"><?=$RATE_SUM;?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
											<iframe src="iframe_detail_i_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE_1;?>&nickname=<?=$UNIT_CODE_2;?>&lastname=<?=$UNIT_CODE_3?>" frameborder="0" width="100%" height="1000" scrolling="yes"></iframe>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="row">			
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="dt-responsive">
											<table id="lang-dt" class="table table-striped table-bordered nowrap">
												<thead>
														
													<?php

														include ('connectpdo.php');

														$sql1 ="SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT_CODE";
														$stmt1=$db->prepare($sql1);
														$stmt1->bindparam(':UNIT_CODE',$UNIT_CODE);
														$stmt1->execute();
														$row1=$stmt1->fetch(PDO::FETCH_ASSOC);

														//$NRPT_NAME1 = $row1["NRPT_NAME"];
														//$NRPT_UNIT_PARENT1 = $row1["NRPT_UNIT_PARENT"];
														//$NRPT_ACM1 = $row1['NRPT_ACM'];
														while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
															$UNIT_CODE1 = $row1['UNIT_CODE'];
															$NRPT_NAME1 = $row1['NRPT_NAME'];
															$NRPT_ACM1 = $row1['NRPT_ACM'];
															$NRPT_NUNIT1 = $row1['NRPT_NUNIT'];
															$NRPT_PAGE1 = $row1['NRPT_NPAGE'];
															$NRPT_DMYUPD1 = $row1['NRPT_DMYUPD'];
															$NRPT_UNIT_PARENT1 = $row1['NRPT_UNIT_PARENT'];
															$NRPT_USER1 = $row1['NRPT_USER'];
															$UNIT_ACM_ID1 = $row1['UNIT_ACM_ID'];
															
															

													?>
												</thead>
												<?php } ?>
												<tbody>
													<tr>
														<th style="width: 260px;" class="table-danger"><font style="font-size: 18px;">หมายเลขอัตราเฉพาะกิจ :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$ACK_ID?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">ชื่อหมายเลขอัตราเฉพาะกิจ :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$ACK_NAME?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">หมายเลขหน่วย(ใหม่) :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$UNIT_CODE1?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">นามหน่วย(ใหม่) :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$NRPT_NAME1?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">นามหน่วยย่อ(ใหม่) :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$NRPT_ACM1?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">หมายเลขหน่วยหลัก :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$UNIT_CODE?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">นามหน่วยหลัก :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;"><?=$NRPT_NAME?></font></td>
													</tr>
													<tr>
														<th class="table-danger"><font style="font-size: 18px;">สถานะข้อมูล :</font></th>
														<td><font style="font-size: 18px; font-weight: bold;">

																<?php
																	if($ACK_STS=="อนุมัติ"){
																		echo "<font color='green'><b>$ACK_STS</b></font>";
																	}else if($ACK_STS=="รอการอนุมัติ"){
																		echo "<font color='orange'><b>$ACK_STS</b></font>";
																	}else{
																		echo "<font color='red'><b>$ACK_STS</b></font>";
																	}            
																?>
																			
																</font>
																	<?php
																	if($ACK_STS=="อนุมัติ"){
																		echo "";
																	}else if($ACK_STS=="รอการอนุมัติ"){
																		echo "<a href='change_sts_apv_ack.php?id=$ACK_ID'><button type='button' class='btn btn-icon btn-success' style='margin-left: 100px;' onClick=\"javascript:return confirm('ต้องการอนุมัติ '-'$ACK_NUM_ID'-');\"><i class='ik ik-check-circle'></i></button></a>

																			<a href='change_sts_del_ack.php?id=$ACK_ID'><button type='button' class='btn btn-icon btn-danger' onClick=\"javascript:return confirm('ต้องการอนุมัติ '-'$ACK_NUM_ID'-');\" ><i class='ik ik-minus-circle' ></i></button></a>";
																	}else{
																		echo "";
																	}            
																	?>
														</td>
													</tr>
															
												</tbody>		      
											</table>
										</div>
									</div>
								</div>
							</div>-->
						<!--	<div class="col-md-6">
								<div class="card">
									<div class="card-body">

										<?php

											$sql5 = "SELECT ACK_SUMMARY as SUMMARY FROM j3_ack WHERE ACK_ID = :ACK_ID";
											$stmt5=$db->prepare($sql5);
											$stmt5->bindparam(':ACK_ID',$ACK_ID); 
											$stmt5->execute();
											$row5=$stmt5->fetch(PDO::FETCH_ASSOC);
												$SUMMARY = $row5['SUMMARY'];
										?>

										<div class="form-group">
											<label for="exampleTextarea1"><font style="font-weight: bold; font-size: 18px;">สรุปปะหน้า :</font></label>
											<textarea class="form-control" id="exampleTextarea1" rows="13" name="ACK_SCOPE" style="border-width:1px; border-color: gray; font-weight: bold; font-size: 18px;" DISABLED><?=$SUMMARY?></textarea>
										</div>	
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<button type="button" class="btn btn-dark" style="height: 40px; width: 150px;" onclick="window.location.href='upd_ack.php?id=<?=$ACK_ID?>'"><i class="ik ik-edit-2"></i>แก้ไขข้อมูล</button>
								<button type="button" class="btn btn-danger" style="height: 40px; width: 150px;" onclick="window.location.href='read_ack.php'"><i class="ik ik-info"></i>ย้อนกลับ</button>
							</div>-->
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

		* {box-sizing: border-box}

		/* Set height of body and the document to 100% */
		body, html {
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

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<?php
      include ('path/script.php');
    ?>
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
    <script>
    	html2canvas(document.querySelector("#capture")).then(canvas => {
    document.body.appendChild(canvas)
});
    </script>

        </body>
        </html>