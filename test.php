                                                    <table id="example1" class="table table-bordered table-striped">
                                                                <thead class="bg-blue">                                                        
																	<tr>
																		<th style="text-align: center;">ลำดับ</th>
																		<th>ชื่อตำแหน่ง</th>
																		<th>ตำแหน่งย่อ</th>
																		<th style="text-align: center;">อัตราชั้นยศ</th>
																		<th style="text-align: center;">รหัสเลขที่ตำแหน่ง</th>
																		<th style="text-align: center;">Manage</th>
																	</tr>
																</thead>
														<tbody>
															<?php
															include ('connectpdo.php');
															$i = 0;
															$sql3 = "SELECT * FROM j3_rost WHERE ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE OR ROST_NPARENT = :UNIT_CODE
																ORDER BY `j3_rost`.`ROST_ID` ASC";
															$stmt3=$db->prepare($sql3);
															$stmt3->bindparam(':UNIT_CODE',$UNIT_CODE);
															$stmt3->execute();
															while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
																$ROST_UNIT = $row3['ROST_UNIT'];
																$ROST_CPOS = $row3['ROST_CPOS'];
																$ROST_POSNAME = $row3['ROST_POSNAME'];
																$ROST_POSNAME_ACM = $row3['ROST_POSNAME_ACM'];
																$ROST_RANK = $row3['ROST_RANK'];
																$ROST_RANKNAME = $row3['ROST_RANKNAME'];
																$ROST_LAO_MAJ = $row3['ROST_LAO_MAJ'];
																$ROST_NCPOS12 = $row3['ROST_NCPOS12'];
																$ROST_ID = $row3['ROST_ID'];
																$ROST_PARENT = $row3['ROST_PARENT'];	
																$ROST_NUNIT = $row3['ROST_NUNIT'];	
																$ROST_NPARENT = $row3['ROST_NPARENT'];

																$i++;

																$ROST_POSNAME = explode(' ', $row3['ROST_POSNAME']);
																$ROST_POSNAME = $ROST_POSNAME[0];

															$sql4 = "SELECT ROST_RANKNAME FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
															$stmt4=$db->prepare($sql4);
															$stmt4->bindparam(':ROST_RANK',$ROST_RANK);
															$stmt4->execute();
															$row4=$stmt4->fetch(PDO::FETCH_ASSOC);
															$RANK_N = $row4['ROST_RANKNAME'];
															

																?>
																<tr>
																	<td style="width: 20px; text-align: center;"><?=$i?></td>
																	<td style="width: 600px;"><?=$ROST_POSNAME?></td>
																	<td style="width: 350px;"><?=$ROST_POSNAME_ACM?></td>
																	<td style="width: 100px; text-align: center;">
																		<?php
																		if($ROST_RANK == "19" || $ROST_RANK == "29"){
																			echo '-';
																		}elseif($ROST_RANK != "19" || $ROST_RANK != "29"){
																			echo $RANK_N;
																		}
																		?>
																		
																	</td>
																	<td style="width: 150px; text-align: center;"><?=$ROST_NCPOS12?></td>
																	<td style="text-align: center;">        
																		<div class="table-actions">
																			<button type="button" id="link_modal" data-toggle="modal" data-target="#EditModal" data-id="<?=$ROST_ID;?>" class="btn btn-success btn-sm editbtn"><i class="fas fa-pencil-alt"></i></button></a>
																			<a href='delete_rate_p.php?id3=<?=$ROST_ID?>&id4=<?=$ACK_NUM_ID?>' onclick="return confirm('คุณต้องการลบรายการนี้ ใช่หรือไม่ ?')"><button type="button" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-ban"></i></button></a>
																		</div>
																	</td>
																</tr>
															<?php } ?>                                                             
														</tbody>

		</table>