<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include ('db/connectpdo.php');
include ('db/connect.php');
$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];
$AJY = $_GET['ajy'];

$sql ="SELECT *,MAX(UNIT_CODE) as max FROM j3_nrpt WHERE UNIT_CODE = :UNIT_CODE";
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
	$MAX = $row['max'];
	

	$NRPT_NAME = explode(' ', $row['NRPT_NAME']); 
	$NRPT_NAME = $NRPT_NAME[0];

	// $NRPT_ACM = explode('.', $row['NRPT_ACM']); 
	// $NRPT_ACM = $NRPT_ACM[0];

}	
?>

<!DOCTYPE html>
<html>
<head>
	<?php
	include ('path/head.php');
	?>
	 <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper"><?php include ('path/navbar.php'); ?>
		<?php
		include ('path/sidebar.php');
		?>
		<div class="content-wrapper">
			<div class="card"><br>
				<section class="content">
					<div class="container-fluid">
						<form action="save_create_ajy.php" method="POST"> 
							<div class="card card-default">
								<div class="card-header">
									<div class="row">
											<button type="button" class="form-control btn btn-danger" style="width: 150px;" onclick="window.location.href='unit_structure.php?id=<?=$UNIT_CODE?>'"><i class="fas fa-backward"></i> ย้อนกลับ</button>
										<div class="col-12 col-sm-2">
											<select class="form-control select2-single" name="PART_LIST" id="PART_LIST">
												<option selected>กรุณาเลือกส่วนงาน...</option>
												<?php
												$sql = "SELECT * FROM j3_part WHERE 1";
												$res = mysqli_query($conn, $sql);
												while($row= mysqli_fetch_assoc($res)) {
													echo '<option value="'.$row['PART_ID'].'"  >'.$row['PART_NAME'].'</option>';
												}
												?>

											</select>
										</div>
										<div class="col-12 col-sm-2">
											<select class="form-control select2-single" id="UNIT_ACM" name="UNIT_ACM">
												<option id="UNIT_ACM_LIST" selected>กรุณาเลือกส่วนงาน...</option>

											</select>
										</div>
										<div class="col-12 col-sm-2">
											<select class="form-control select2-single" id="UNIT_ACM_CREATE" name="UNIT_ACM_CREATE">
												<option selected>กรุณาเลือกสร้าง...</option>
												<!-- <option value="ศูนย์">ศูนย์</option> -->
												<option value="กองพัน">กองพัน</option>
												<option value="กอง">กองร้อย</option>
												<option value="แผนก">หมวด</option>
												<option value="ตอน">ตอน</option>

											</select>
										</div>
										<div class="card-tool">
											<!-- <button class="btn btn-secondary" type="button"  data-toggle="modal" data-target=".modalMoveStructure" data-unit_code="<?=$UNIT_CODE;?>" data-nrpt_unit_parent="<?=$NRPT_UNIT_PARENT;?>"><i class="fas fa-spinner"></i> สร้างโครงสร้างแบบไม่ใช้ต้นแบบ</button> -->
											<button type="submit" class="btn btn-primary"><i class="fas fa-save"> บันทึกข้อมูล</i></button></button>
										</div>
									</div>	
								</div>     
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-sm-2">
											<div class="form-group">
												<label>หมายเลขอัตราการจัดยุทโธปกรณ์</label>
												<input type="text" class="form-control" name="AJY_ID">
											</div>
										</div>
										<div class="col-12 col-sm-3">
											<div class="form-group">
												<label>ชื่อหมายเลขอัตราการจัดยุทโธปกรณ์</label>
												<input type="text" class="form-control" name="AJY_NAME" >
											</div>
										</div>
										<div class="col-12 col-sm-2">
											<div class="form-group">
												<label>หมายเลขหน่วย(ใหม่)</label>
												<input type="text" class="form-control" name="UNIT_NAME2" value="<?=$MAX?>">
											</div>
										</div>
										<div class="col-12 col-sm-3">
											<div class="form-group">
												<label>นามหน่วย</label>
												<input type="text" class="form-control" old-name="<?=$NRPT_NAME?>" name="UNIT_NAME" value="<?=$NRPT_NAME?>">
												<input type="hidden" class="form-control" name="UNIT_NAME_OLD" value="<?=$NRPT_NAME?>">
											</div>
										</div>
										<div class="col-12 col-sm-2">
											<div class="form-group">
												<label>นามหน่วยย่อ</label>
												<input type="text" class="form-control" old-name="<?=$NRPT_ACM?>" name="UNIT_NAME_AJY" value="<?=$NRPT_ACM?>">
												<input type="hidden" class="form-control" name="UNIT_NAME_AJY_OLD" value="<?=$NRPT_ACM?>">
											</div>
										</div>
										<div class="col-12 col-sm-2">
											<div class="form-group">
												<label>หมายเลขหน่วยหลัก</label>
												<input type="text" class="form-control" name="UNIT_CODE_PARENT" id="UNIT_CODE_PARENT" value="<?=$UNIT_CODE?>" readonly>
											</div>
										</div>
										<input type="hidden" name="UNIT_ACM_ID" value="<?=$UNIT_ACM_ID?>">
										<div class="col-12 col-sm-6">
											<div class="form-group">
												<label>เหตุผลความจำเป็น</label>
												<input type="text" class="form-control" name="AJY_ESSENCE" >
											</div>
										</div>
										<div class="col-12 col-sm-3">
											<div class="form-group">
												<label>ผู้ทำรายการ</label>
												<input type="text" class="form-control" name="AJY_USER" >
											</div>
										</div>
										<div class="col-12 col-sm-1">
											<div class="form-group">
												<label>เวอร์ชัน</label>
												<input type="text" class="form-control" name="AJY_VERSION" value="1" readonly>
											</div>
										</div>

									</div>
									<div class="card-body">
										<button class="tablink" onmouseover="openPage('Home', this, 'white')" >กล่าวทั่วไป</button>
										<button class="tablink" onmouseover="openPage('News', this, 'white')">อัตรากำลังพล</button>
										<!-- <button class="tablink" onmouseover="openPage('Contact', this, 'white')">คำชี้แจง</button> -->
										<button class="tablink" onmouseover="openPage('About', this, 'white')">อัตรายุทโธปกรณ์</button>
										<!-- <button class="tablink" onmouseover="openPage('1About', this, 'white')">สรุปปะหน้า</button> -->

										<div id="Home" class="tabcontent">
											<div class="form-group">
												<label for="exampleTextarea1"><h6>ภารกิจ :</h6></label>
												<textarea class="form-control" id="editor" rows="10" name="AJY_MISSION" style="border-width:1px; border-color: gray;"></textarea>
											</div>
											<div class="form-group">
												<label for="exampleTextarea1"><h6>การแบ่งมอบ :</h6></label>
												<textarea class="form-control" id="editor1" rows="6" name="AJY_DISTRIBUTION" style="border-width:1px; border-color: gray;"></textarea>
											</div>
											<div class="form-group">
												<label for="exampleTextarea1"><h6>ขีดความสามารถ :</h6></label>
												<textarea class="form-control" id="editor2" rows="6" name="AJY_SCOPE" style="border-width:1px; border-color: gray;"></textarea>
											</div>
											<!-- <div class="form-group">
												<label for="exampleTextarea1"><h6>การแบ่งส่วนราชการและหน้าที่ :</h6></label>
												<textarea class="form-control" id="editor3" rows="6" name="AJY_DIVISION" style="border-width:1px; border-color: gray;"></textarea>
											</div> -->
										</div>

										<div id="News" class="tabcontent"> 
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead class="bg-blue">                                                        
                                                    <tr>
                                                        <th style="text-align: center;">ลำดับ</th>
                                                        <th>ชื่อตำแหน่ง</th>
                                                        <th>ตำแหน่งย่อ</th>
                                                        <th style="text-align: center;">อัตราชั้นยศ</th>
                                                        <th style="text-align: center;">รหัสเลขที่ตำแหน่ง</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        include ('db/connectpdo.php');
                                                        $i = 0;
                                                        $sql3 = "SELECT * FROM j3_rost WHERE ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE OR ROST_NPARENT = :UNIT_CODE
                                                            ORDER BY ROST_ID ASC, ROST_RANK ASC ";
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

                                                            // $ROST_POSNAME = explode(' ', $row3['ROST_POSNAME']);
                                                            // $ROST_POSNAME = $ROST_POSNAME[0];

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
                                                                        echo $ROST_RANKNAME;
                                                                    }
                                                                    ?>
                                                                    
                                                                </td>
                                                                <td style="width: 150px; text-align: center;"><?=$ROST_NCPOS12?></td>
                                                            </tr>
                                                        <?php } ?>                                                             
                                                </tbody>
                                            </table> 
										</div>

										<div id="Contact" class="tabcontent">
											<label for="exampleTextarea1"><h6>คำชี้แจง :</h6></label>
											<textarea class="form-control html-editor" id="editor4" rows="10" style="border-width:1px; border-color: gray;" name="AJY_EXPLANATION"></textarea>
										</div>

										<div id="About" class="tabcontent">
                                            <table id="example3" class="table table-bordered table-striped">
                                                <thead class="bg-primary">                                                        
                                                    <tr class="table">
                                                        <th>เลขประจำยุทโธปกรณ์</th>
                                                        <th>ชื่อยุทโธปกรณ์</th>
                                                        <th>รหัส สป.</th>
                                                        <th>อัตรา</th>
                                                        <th>หน่วยงาน</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $sql2 = "SELECT * FROM j3_rateitem";
                                                $stmt2=$db->prepare($sql2);
                                                $stmt2->execute();
                                                while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                                                    $RATE_I_NUM = $row2['RATE_I_NUM'];
                                                    $ACK_ID = $row2['ACK_ID'];
                                                    $RATE_I_NUM_POS = $row2['RATE_I_NUM_POS'];
                                                    $NSN_ID = $row2['NSN_ID'];
                                                    $NSN_NAME = $row2['NSN_NAME'];
                                                    $RATE_I_TOTAL = $row2['RATE_I_TOTAL'];
                                                    $RATE_I_REMARK = $row2['RATE_I_REMARK'];
                                                    $P_ID = $row2['P_ID'];
                                                    $RATE_I_UPD_DATE = $row2['RATE_I_UPD_DATE'];
                                                    $RATE_I_DEPARTMENT = $row2['RATE_I_DEPARTMENT'];


                                                ?>
                                                    <tr>
                                                        <td style="width: 180px; text-align: center;"><?=$RATE_I_NUM_POS?></td>
                                                        <td><?=$NSN_NAME?></td>
                                                        <td><?=$NSN_ID?></td>
                                                        <td style="width: 40px; text-align: center;"><?=$RATE_I_TOTAL?></td>
                                                        <td><?=$RATE_I_DEPARTMENT?></td>
                                                        <td style="width: 100px; text-align: center;" valign="middle">
                                                            <div class="table-actions">
                                                            <button type="button" id="link_modal" data-toggle="modal" data-target="#EditModal" data-id="<?=$ROST_ID;?>" class="btn btn-success btn-sm editbtn"><i class="fas fa-pencil-alt"></i></button></a>
                                                            <a href='delete_data.php?id=<?=$RATE_I_NUM;?>'><button type="button" class="btn btn-danger btn-sm btntrash"><i class="fas fa-trash-alt"></i></button></a>
                                                            </div>
                                                        </td>
                                                    </tr>                                                           
                                                </tbody>
                                                <?php } ?>  
                                            </table>
										</div>

										<div id="1About" class="tabcontent">
											<label for="exampleTextarea1"><h6>สรุปปะหน้า :</h6></label>
											<textarea class="form-control html-editor" id="editor5" rows="10" style="border-width:1px; border-color: gray;" name="AJY_SUMMARY"></textarea>
											<br>                                            
										</div>
									</div>
								</div>
							</div>
						</form>  
					</div>
				</div>
			</section>
		</div>
	</div>

	<div class="modal fade modalMoveStructure" tabindex="-1" role="dialog" aria-labelledby="modalMoveStructureModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">

				</div>
			</div>
		</div>
	</div>


    <?php require_once __DIR__.'/path/footer.php'; ?>


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

<?php require_once __DIR__.'/path/script.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
	ClassicEditor
	.create( document.querySelector( '#editor' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
<script>
	ClassicEditor
	.create( document.querySelector( '#editor1' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
<script>
	ClassicEditor
	.create( document.querySelector( '#editor2' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
<script>
	ClassicEditor
	.create( document.querySelector( '#editor3' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
<script>
	ClassicEditor
	.create( document.querySelector( '#editor4' ) )
	.catch( error => {
		console.error( error );
	} );
</script>
<script>
	$(function () {
		    // Summernote
		    $('.textarea').summernote()
		})
	</script>
	<script>

		$('select[name="PART_ID"]').on('change', function () {
			$.ajax({
				type: "POST",
				url: "get_data.php",
				data: {PART_ID : $(this).val() , do:'get_j3_unit_acm'},
				dataType: "json",
				success: function (response) {
					$('#UNIT_ACM_ID').html($("<option>กรุณาเลือก...</option>"));
					$.each(response, function (indexInArray, valueOfElement) { 
						console.log(valueOfElement)
						$('#UNIT_ACM_ID').append($("<option></option>")
							.attr("value",valueOfElement["UNIT_ACM_ID"])
							.text(valueOfElement["UNIT_ACM_NAME"])); 

					});
				}
			});
		});
	</script>

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
	                // Get the element with id="defaultOpen" and click on it
	                document.getElementById("defaultOpen").click();
	            </script>

	            <script>
	            	$(function () {
	            		$("#example1").DataTable();
	            		// $('#example2').DataTable({
	            		// 	"paging": true,
	            		// 	"lengthChange": false,
	            		// 	"searching": false,
	            		// 	"ordering": true,
	            		// 	"info": true,
	            		// 	"autoWidth": false,
	            		// });
	            		$('button.tablink').on('click', function (event) {
	            			return false;
	            		});
	            	});
	            	$('.modalMoveStructure').on('show.bs.modal', function (event) {
						var button = $(event.relatedTarget) // Button that triggered the modal
						var nrpt_unit_parent = button.data('nrpt_unit_parent') 
						var unit_code = button.data('unit_code') 
						var modal = $(this)
						$.ajax({
							type: "POST",
							url: "modalMoveStructure.php",
							data: {unit_code , nrpt_unit_parent },
						// dataType: "",
						success: function (response) {
							// console.log(response)
							modal.find('.modal-body').html(response)
							// $.ajax({
							// 	type: "POST",
							// 	url: "ct_create_ack.php",
							// 	data: $('form[action="ct_create_ack.php"]').serialize() ,
							// 	// dataType: "dataType",
							// 	success: function (response) {
							// 		console.log(response)
							// 		alert('ย้ายโครงสร้างเรียบร้อยแล้ว')
							// 		location.reload();
							// 	}
							// });
						}
					});
						
					})
	            	$('.modalMoveStructure').on('hidden.bs.modal', function (event) {
	            		$(this).find('.modal-body').removeClass('text-center')
	            	})

					$('select#PART_LIST').on('change', function () {
						$.ajax({
							type: "POST",
							url: "get_data.php",
							data: {do:'get_j3_unit_acm' , PART_ID:$(this).val()},
							dataType: "json",
							success: function (response) {
								console.log(response)
								$('select#UNIT_ACM').html($("<option>กรุณาเลือก...</option>"));
								$.each(response, function (indexInArray, valueOfElement) { 
									console.log(valueOfElement)
									$('select#UNIT_ACM').append($("<option></option>")
										.attr("value",valueOfElement["UNIT_ACM_ID"])
										.text(valueOfElement["UNIT_ACM_NAME"])); 

								});

							}
						});
					});


					$('select#UNIT_ACM_CREATE').on('change', function () {
						var UNIT_ACM_CREATE = $(this).val()
						if ( $('select#UNIT_ACM').val() != "" ) {
							$.ajax({
								type: "POST",
								url: "get_data.php",
								data: {do: 'get_max' , UNIT_ACM_CREATE : UNIT_ACM_CREATE, UNIT_CODE: $('select#UNIT_ACM').val() , UNIT_CODE_PARENT:$('input[name="UNIT_CODE_PARENT"]').val() },
								// dataType: "",
								success: function (response) {
									// console.log(response)
									$('input[name="UNIT_NAME2"]').val(response)
									$('input[name="UNIT_NAME2"]').attr('value' , response)
								}
							});
						}
					});


					$('form[action="save_create_ajy.php"]').submit(function (e) { 
						var modalBody  = $(this).parent()
						var spinner = `
						<div class="spinner-border text-secondary" role="status">
						<span class="sr-only">Loading...</span>
						</div>
						`
						modalBody.empty()
						modalBody.html(spinner).addClass('text-center')
						$.ajax({
							type: $(this).attr('method'),
							url: $(this).attr('action'),
							data: $(this).serialize(),
							// dataType: "dataType",
							success: function (response) {
								console.log(response)
								alert('สร้างข้อมูลเรียบร้อยแล้ว')
								location.reload();
							}
						});



						e.preventDefault();
					});


	            </script>
	        </body>
	        </html>