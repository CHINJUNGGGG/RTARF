<!DOCTYPE html>
<html>
<head>
	<?php include ('path/head.php'); ?>
</head>
<body>
	<div class="wrapper" id="printable">
		<!-- Main content -->
		<section class="rotateit" style="margin-top: 650px;" scrollmouse="no">
			<?php

			include ('db/connectpdo.php');

			$UNIT_CODE = $_GET['id'];
			$ACK_NUM_ID = $_GET['id2'];
			$sql ="SELECT * FROM j3_ack WHERE ACK_NUM_ID = :ACK_NUM_ID";
			$stmt=$db->prepare($sql);
			$stmt->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
			$stmt->execute();
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$ACK_NUM_ID = $row['ACK_NUM_ID'];
			$ACK_ID = $row['ACK_ID'];
			$ACK_MISSION = $row['ACK_MISSION'];
			$ACK_DISTRIBUTION = $row['ACK_DISTRIBUTION'];
			$ACK_ESSENCE = $row['ACK_ESSENCE'];
			$ACK_SCOPE = $row['ACK_SCOPE'];
			$ACK_DIVISION = $row['ACK_DIVISION'];
			$ACK_EXPLANATION = $row['ACK_EXPLANATION'];
			$ACK_SUMMARY = $row['ACK_SUMMARY'];
			$ACK_USER = $row['ACK_USER'];
			$ACK_NAME = $row['ACK_NAME'];
			$UNIT_CODE_2 = $row['UNIT_CODE'];
			$UNIT_NAME = $row['UNIT_NAME'];
			$UNIT_NAME_ACK = $row['UNIT_NAME_ACK'];
			$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
			$ACK_TIMESTAMP = $row['ACK_TIMESTAMP'];
			$ACK_STS = $row['ACK_STS'];
			$ACK_VERSION = $row['ACK_VERSION'];


			$sql6 = "SELECT * FROM j3_nrpt_approve WHERE UNIT_CODE = :UNIT_CODE_2" ;
			$stmt6=$db->prepare($sql6);
			$stmt6->bindparam(':UNIT_CODE_2',$UNIT_CODE_2);
			$stmt6->execute();
			$row6=$stmt6->fetch(PDO::FETCH_ASSOC);
			$data = $row6['UNIT_CODE'];


			echo '<div class="tf-tree tf-gap-sm">
			<ul>
			<li>
			<span class="tf-node-content">
			'. $row6['NRPT_ACM'] .'
			</span>';

			if($data == $UNIT_CODE_2){

				$sql8 = "SELECT * FROM j3_nrpt_approve WHERE NRPT_UNIT_PARENT = :data" ;
				$stmt8=$db->prepare($sql8);
				$stmt8->bindparam(':data',$data);
				$stmt8->execute();
				$row8=$stmt8->fetch(PDO::FETCH_ASSOC);

				if($row8['NRPT_UNIT_PARENT'] == $data){
					echo '<ul>';
					$stmt8->execute();
					while($row8=$stmt8->fetch(PDO::FETCH_ASSOC)){
						$SUB = substr($row8['UNIT_CODE'],6);
																		//echo $SUB;
						if($SUB != "0001" && $SUB != "0002" && $SUB != "0003" && $SUB != "9999" && $SUB != "9998"  && $SUB != "0900"){
							if($row8['NRPT_UNIT_PARENT'] == $data){
								$send = $row8['UNIT_CODE'];
																				//echo $row8['UNIT_CODE'];
								echo '<li>
								<span class="tf-node-content">
								'. $row8['NRPT_ACM'] .'
								</span>';

																				//$row8['UNIT_CODE'] != "6150000001" && $row8['UNIT_CODE'] != "6150000002" && $row8['UNIT_CODE'] != "6150000003" && 

																				/*$sql7 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :send";
																				$stmt7=$db->prepare($sql7);
																				$stmt7->bindparam(':send',$send);
																				$stmt7->execute();
																				$row7=$stmt7->fetch(PDO::FETCH_ASSOC);
																				
																				if($row7['NRPT_UNIT_PARENT'] == $send){
																					echo '<ul>';
																					$stmt7->execute();
																					while($row7=$stmt7->fetch(PDO::FETCH_ASSOC)){
																						$parent1 = $row7['NRPT_UNIT_PARENT'];
																						if($row7['NRPT_UNIT_PARENT'] == $send){
																							
																							echo '<li>
																									<span class="tf-nc">
																										'. $row7['NRPT_ACM'] .'
																									</span>
																								</li>';
																							
																						}
																					}
																					echo '</ul>';
																				}*/
																			}
																			echo '
																			</li>';
																		}
																	}
																}
																echo '</ul>';
															}          
															echo '
															</li>
															</ul>
															</div>';					
															?>
														</section>
														<!-- /.content -->
													</div>
													<!-- ./wrapper -->
													<style>

														.tf-tree{
															font-size:16px;
															overflow:auto
														}
														.tf-tree *{
															box-sizing:border-box;
															margin:0;
															padding:0
														}
														.tf-tree ul{
															display:inline-flex
														}
														.tf-tree li{
															align-items:center;
															display:flex;
															flex-direction:column;
															flex-wrap:wrap;
															padding:0 1em;
															position:relative
														}
														.tf-tree li ul{
															margin:2em 0
														}
														.tf-tree li li:before{
															border-top:.0625em solid #000;
															content:"";
															display:block;
															height:.0625em;
															left:-.03125em;
															position:absolute;
															top:-1.03125em;
															width:100%
														}
														.tf-tree li li:first-child:before{
															left:calc(50% - .03125em);
															max-width:calc(50% + .0625em)
														}
														.tf-tree li li:last-child:before{
															left:auto;
															max-width:calc(50% + .0625em);
															right:calc(50% - .03125em)
														}
														.tf-tree li li:only-child:before{
															display:none
														}
														.tf-tree li li:only-child>
														.tf-nc:before,
														.tf-tree li li:only-child>
														.tf-node-content:before{
															height:1.0625em;
															top:-1.0625em
														}
														.tf-tree .tf-nc,.tf-tree .tf-node-content{
															border:.0625em solid #000;
															display:inline-block;
															padding:.5em 1em;
															position:relative
														}
														.tf-tree .tf-nc:before,.tf-tree .tf-node-content:before{
															top:-1.03125em
														}
														.tf-tree .tf-nc:after,
														.tf-tree .tf-nc:before,
														.tf-tree .tf-node-content:after,
														.tf-tree .tf-node-content:before{
															border-left:.0625em solid #000;
															content:"";
															display:block;
															height:1em;
															left:calc(50% - .03125em);
															position:absolute;
															width:.0625em
														}
														.tf-tree .tf-nc:after,
														.tf-tree .tf-node-content:after{
															top:calc(100% + .03125em)
														}
														.tf-tree .tf-nc:only-child:after,
														.tf-tree .tf-node-content:only-child:after,
														.tf-tree>ul>li>.tf-nc:before,
														.tf-tree>ul>li>.tf-node-content:before{
															display:none
														}
														.tf-tree.tf-gap-sm li{
															padding:0 .6em
														}
														.tf-tree.tf-gap-sm li>.tf-nc:before,
														.tf-tree.tf-gap-sm li>.tf-node-content:before{
															height:.6em;
															top:-.6em
														}
														.tf-tree.tf-gap-sm li>.tf-nc:after,
														.tf-tree.tf-gap-sm li>.tf-node-content:after{
															height:.6em
														}
														.tf-tree.tf-gap-sm li ul{
															margin:1.2em 0
														}
														.tf-tree.tf-gap-sm li li:before{
															top:-.63125em
														}
														.tf-tree.tf-gap-sm li li:only-child>.tf-nc:before,
														.tf-tree.tf-gap-sm li li:only-child>.tf-node-content:before{
															height:.6625em;
															top:-.6625em
														}
														.tf-tree.tf-gap-lg li{
															padding:0 1.5em
														}
														.tf-tree.tf-gap-lg li>.tf-nc:before,
														.tf-tree.tf-gap-lg li>.tf-node-content:before{
															height:1.5em;
															top:-1.5em
														}
														.tf-tree.tf-gap-lg li>.tf-nc:after,
														.tf-tree.tf-gap-lg li>.tf-node-content:after{
															height:1.5em
														}
														.tf-tree.tf-gap-lg li ul{
															margin:3em 0
														}
														.tf-tree.tf-gap-lg li li:before{
															top:-1.53125em
														}
														.tf-tree.tf-gap-lg li li:only-child>.tf-nc:before,
														.tf-tree.tf-gap-lg li li:only-child>.tf-node-content:before{
															height:1.5625em;
															top:-1.5625em
														}
														.tf-tree li.tf-dotted-children .tf-nc:after,
														.tf-tree li.tf-dotted-children .tf-nc:before,
														.tf-tree li.tf-dotted-children .tf-node-content:after,
														.tf-tree li.tf-dotted-children .tf-node-content:before{
															border-left-style:dotted
														}
														.tf-tree li.tf-dotted-children li:before{
															border-top-style:dotted
														}
														.tf-tree li.tf-dotted-children>.tf-nc:before,
														.tf-tree li.tf-dotted-children>.tf-node-content:before{
															border-left-style:solid
														}
														.tf-tree li.tf-dashed-children .tf-nc:after,
														.tf-tree li.tf-dashed-children .tf-nc:before,
														.tf-tree li.tf-dashed-children .tf-node-content:after,
														.tf-tree li.tf-dashed-children .tf-node-content:before{
															border-left-style:dashed
														}
														.tf-tree li.tf-dashed-children li:before{
															border-top-style:dashed
														}
														.tf-tree li.tf-dashed-children>.tf-nc:before,
														.tf-tree li.tf-dashed-children>.tf-node-content:before{
															border-left-style:solid
														}

														
													</style>	
													<style>
														.rotateit{
															display:block;
															filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
															-webkit-transform: rotate(-0deg);
															-moz-transform: rotate(-0deg);
														}

													</style>
													<?php include ('script.php'); ?>

													<script type="text/javascript"> 
														window.addEventListener("load", window.print());
													</script>
												</body>
												</html>