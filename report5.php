
<?php

include('db/connectpdo.php');


require_once 'pdf/vendor/autoload.php';


$ACK_NUM_ID = $_GET['id'];

$sql_1 ="SELECT * FROM j3_ack WHERE ACK_NUM_ID = :ACK_NUM_ID";
$stmt_1=$db->prepare($sql_1);
$stmt_1->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
$stmt_1->execute();
$row_1=$stmt_1->fetch(PDO::FETCH_ASSOC);
$ACK_NUM_ID = $row_1['ACK_NUM_ID'];
$ACK_ID = $row_1['ACK_ID'];
$ACK_MISSION = $row_1['ACK_MISSION'];
$ACK_DISTRIBUTION = $row_1['ACK_DISTRIBUTION'];
$ACK_ESSENCE = $row_1['ACK_ESSENCE'];
$ACK_SCOPE = $row_1['ACK_SCOPE'];
$ACK_DIVISION = $row_1['ACK_DIVISION'];
$ACK_EXPLANATION = $row_1['ACK_EXPLANATION'];
$ACK_SUMMARY = $row_1['ACK_SUMMARY'];
$ACK_USER = $row_1['ACK_USER'];
$ACK_NAME = $row_1['ACK_NAME'];
$UNIT_CODE1 = $row_1['UNIT_CODE'];
$UNIT_NAME = $row_1['UNIT_NAME'];
$UNIT_NAME_ACK = $row_1['UNIT_NAME_ACK'];
$UNIT_CODE_PARENT = $row_1['UNIT_CODE_PARENT'];
$ACK_TIMESTAMP = $row_1['ACK_TIMESTAMP'];
$ACK_STS = $row_1['ACK_STS'];
$ACK_VERSION = $row_1['ACK_VERSION'];

$sql_unit ="SELECT * FROM j3_nrpt_transaction WHERE UNIT_CODE = :UNIT_CODE1 AND ACK_NUM_ID = '$ACK_NUM_ID'";
$stmt_unit=$db->prepare($sql_unit);
$stmt_unit->bindparam(':UNIT_CODE1',$UNIT_CODE1);
$stmt_unit->execute();
$row_unit=$stmt_unit->fetch(PDO::FETCH_ASSOC);
$UNIT_CODE2 = $row_unit['UNIT_CODE'];
$NRPT_NAME = $row_unit['NRPT_NAME'];
$NRPT_ACM = $row_unit['NRPT_ACM'];
$NRPT_NUNIT = $row_unit['NRPT_NUNIT'];
$NRPT_NPAGE = $row_unit['NRPT_NPAGE'];
$NRPT_DMYUPD = $row_unit['NRPT_DMYUPD'];
$NRPT_UNIT_PARENT = $row_unit['NRPT_UNIT_PARENT'];
$NRPT_USER = $row_unit['NRPT_USER'];

$sql_pr ="SELECT NRPT_NAME FROM j3_nrpt WHERE UNIT_CODE = :NRPT_UNIT_PARENT";
$stmt_pr=$db->prepare($sql_pr);
$stmt_pr->bindparam(':NRPT_UNIT_PARENT',$NRPT_UNIT_PARENT);
$stmt_pr->execute();
$row_pr=$stmt_pr->fetch(PDO::FETCH_ASSOC);
$NRPT_NAME2 = $row_pr['NRPT_NAME'];

$NRPT_NAME2 = explode(' ', $row_pr['NRPT_NAME']); 
$NRPT_NAME2 = $NRPT_NAME2[0];	


$NRPT_NAME = explode(' ', $row_unit['NRPT_NAME']); 
$NRPT_NAME = $NRPT_NAME[0];	


$sql5 ="SELECT * FROM j3_rateitem WHERE ACK_ID = :ACK_ID";
$stmt5=$db->prepare($sql5);
$stmt5->bindparam(':ACK_ID',$ACK_ID);
$stmt5->execute();
$row5=$stmt5->fetch(PDO::FETCH_ASSOC);
$RATE_I_NUM = $row5['RATE_I_NUM'];
$ACK_ID_1 = $row5['ACK_ID'];
$RATE_I_NUM_POS = $row5['RATE_I_NUM_POS'];
$NSN_ID = $row5['NSN_ID'];
$NSN_NAME = $row5['NSN_NAME'];
$RATE_I_TOTAL = $row5['RATE_I_TOTAL'];
$RATE_I_REMARK = $row5['RATE_I_REMARK'];
$P_ID = $row5['P_ID'];
$RATE_I_UPD_DATE = $row5['RATE_I_UPD_DATE'];
$RATE_I_DEPARTMENT = $row5['RATE_I_DEPARTMENT'];

/*while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
	$COUNT = $row2['COUNT(ROST_ID)'];
	$ROST_UNIT = $row2['ROST_UNIT'];
	$ROST_CPOS = $row2['ROST_CPOS'];
	$ROST_POSNAME = $row2['ROST_POSNAME'];
	$ROST_POSNAME_ACM = $row2['ROST_POSNAME_ACM'];
	$ROST_RANK = $row2['ROST_RANK'];
	$ROST_RANKNAME = $row2['ROST_RANKNAME'];
	$ROST_LAO_MAJ = $row2['ROST_LAO_MAJ'];
	$ROST_NCPOS12 = $row2['ROST_NCPOS12'];
	$ROST_ID = $row2['ROST_ID'];
	$ROST_PARENT = $row2['ROST_PARENT'];
	$ROST_NUNIT = $row2['ROST_NUNIT'];
	$ROST_NPARENT = $row2['ROST_NPARENT'];
}*/

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 16,
	'margin_bottom' => 25,
	'default_font' => 'sarabun',
	'setAutoTopMargin' => 'stretch',
]);	

$html = '<htmlpageheader name="myHeader1">
    <table width="100%" style="border-style: none;">
        <tr>
            <td width="33%" style="border-style: none;"></td>
            <td width="33%" align="center" style="font-size:50px; border-style: none;"><font color=#E80000><b>ลับมาก</b></font></td>
            <td width="33%" style="text-align: right; border-style: none;">'.$NRPT_NAME.'<br>
            ชุดที่...........ของ..........ชุด<br>
            หน้าที่ {PAGENO} ของ {nbpg} หน้า</td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myFooter1">
    <table width="100%" style="border-style: none;">
        <tr>
            
            <td width="33%" align="center" style="font-size:50px; border-style: none;"><font color=#E80000><b>ลับมาก</b></font></td>
            
        </tr>
    </table>
</htmlpagefooter>';

$html .='<div style="text-align: left;">อัตราเฉพาะกิจ<br>หมายเลข '.$ACK_ID.'</div>';
$html .= '<div style="text-align: center"><u>'.$NRPT_NAME.'<br>'.$NRPT_NAME2.'<br>กองบัญชาการกองทัพไทย</u><br>ตอนที่ 5 อัตรายุทโธปกรณ์</div><br>';

//$html .='<div style="text-align: left">อัตราเฉพาะกิจ</div><div style="text-align:left">หมายเลข '.$ACK_ID.'</div><div style="text-align: center"><u>'.$UNIT_NAME.'</u><div style="text-align: center"> <u>กองบัญชาการกองทัพไทย</u></div><div style="text-align: center">ตอนที่ 5 อัตรายุทโธปกรณ์</div></div><br><br>';
$html .= '<div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>                                                        
                    <tr>
						<th>วรรค</th>
						<th>ลำดับ</th>
						<th style="text-align: center;">รายการยุทโธปกรณ์</th>
						<th style="text-align: center;">อัตรายุทโธปกรณ์</th>
						<th style="text-align: center;">หมายเหตุ</th>
					</tr>
                </thead>
				<tbody>';
				$i = 0;
				$sql ="SELECT * FROM j3_ack WHERE ACK_NUM_ID = :ACK_NUM_ID";
				$stmt=$db->prepare($sql);
				$stmt->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
				$stmt->execute();
				while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
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
				$UNIT_CODE = $row['UNIT_CODE'];
				$UNIT_NAME = $row['UNIT_NAME'];
				$UNIT_NAME_ACK = $row['UNIT_NAME_ACK'];
				$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
				$ACK_TIMESTAMP = $row['ACK_TIMESTAMP'];
				$ACK_STS = $row['ACK_STS'];
				$ACK_VERSION = $row['ACK_VERSION'];

				$UNIT_NAME = explode(' ', $row['UNIT_NAME']); 
				$UNIT_NAME = $UNIT_NAME[0];


				$sql2 ="SELECT * FROM j3_rateitem WHERE ACK_ID = :ACK_ID";
				$stmt2=$db->prepare($sql2);
				$stmt2->bindparam(':ACK_ID',$ACK_ID);
				$stmt2->execute();
				$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
				$RATE_I_NUM = $row2['RATE_I_NUM'];

				$i++;

														$ACK_ID = $row2['ACK_ID'];
														$RATE_I_NUM_POS = $row2['RATE_I_NUM_POS'];
														$NSN_ID = $row2['NSN_ID'];
														$NSN_NAME = $row2['NSN_NAME'];
														$RATE_I_TOTAL = $row2['RATE_I_TOTAL'];
														$RATE_I_REMARK = $row2['RATE_I_REMARK'];
														$P_ID = $row2['P_ID'];
														$RATE_I_UPD_DATE = $row2['RATE_I_UPD_DATE'];
														$RATE_I_DEPARTMENT = $row2['RATE_I_DEPARTMENT'];
		
$html .= '<tr>
			<td style="width: 20px; text-align: center;">'.$i.'</td>
			<td style="width: 20px;"> '.$i.'</td>
			<td style="width: 350px; text-align: center;">'.$NSN_NAME.'</td>
            <td style="width: 20px; text-align: center;">'.$RATE_I_TOTAL.'</td>
            <td style="width: 200px; text-align: center;">'.$RATE_I_REMARK.'</td>';
			}
	$html .='</tbody>
    </table>
</div>';
$html .= "<style>
table, td, th {  
  border: 1px solid #0000;
  text-align: center;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 2px;
}
</style>";

$html .="<style>
@page {
    size: auto;
    odd-header-name: html_myHeader1;
    even-header-name: html_myHeader2;
    odd-footer-name: html_myFooter1;
    even-footer-name: html_myFooter2;
}
@page chapter2 {
    odd-header-name: html_Chapter2HeaderOdd;
    even-header-name: html_Chapter2HeaderEven;
    odd-footer-name: html_Chapter2FooterOdd;
    even-footer-name: html_Chapter2FooterEven;
}
@page noheader {
    odd-header-name: _blank;
    even-header-name: _blank;
    odd-footer-name: _blank;
    even-footer-name: _blank;
}       
</style>";

$mpdf->WriteHTML($html);
$mpdf->Output();



?>