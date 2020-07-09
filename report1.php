

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

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 16,
	'default_font' => 'sarabun',
	'setAutoTopMargin' => 'stretch'
]);	

$html = '<htmlpageheader name="myHeader1">
    <table width="100%">
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center" style="font-size:50px"><font color=#E80000><b>ลับมาก</b></font></td>
            <td width="33%" style="text-align: right; ">'.$NRPT_NAME.'<br>
            ชุดที่...........ของ..........ชุด<br>
            หน้าที่ {PAGENO} ของ {nbpg} หน้า</td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myFooter1">
    <table width="100%">
        <tr>
            
            <td width="33%" align="center" style="font-size:50px"><font color=#E80000><b>ลับมาก</b></font></td>
            
        </tr>
    </table>
</htmlpagefooter>';

$html .='<div style="text-align: left;">อัตราเฉพาะกิจ<br>หมายเลข '.$ACK_ID.'</div>';

$html .= '<div style="text-align: center"><u>'.$NRPT_NAME.'<br>'.$NRPT_NAME2.'<br>กองบัญชาการกองทัพไทย</u><br>ตอนที่ 1 กล่าวทั่วไป</div><br>';

$html .= '<div style="text-align:left">1. <u>ภารกิจ</u></div><div>'.$ACK_MISSION.'</div>';
$html .= '<div style="text-align:left">2. <u>การแบ่งมอบ</u> '.$ACK_DISTRIBUTION.' </div>';
$html .= '<div style="text-align:left">3. <u>ขอบเขตความรับผิดชอบและหน้าที่ที่สำคัญ</u> '.$ACK_SCOPE.' </div>';
$html .= '<div style="text-align:left">4. <u>การแบ่งส่วนราชการและหน้าที่</u> '.$ACK_DIVISION.' </div>';
$html .= '<div style="text-align:left">5. <u>ตอนเพิ่มเติม</u><div>ตอนที่ 2 ผังการจัด</div><div>ตอนที่ 3 อัตรากำลังพล</div><div>ตอนที่ 4 คำชี้แจง</div><div>ตอนที่ 5 อัตรายุทโธปกรณ์</div></div>';

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
