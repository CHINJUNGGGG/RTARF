<?php

include('db/connectpdo.php');

require_once 'pdf/vendor/autoload.php';

//$ACK_NUM_ID = $_GET['id'];

$UNIT_CODE = $_GET['id'];

$sql1 ="SELECT * FROM j3_nrpt WHERE UNIT_CODE = :UNIT_CODE";
$stmt1=$db->prepare($sql1);
$stmt1->bindparam(':UNIT_CODE',$UNIT_CODE);
$stmt1->execute();
$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
	$UNIT_CODE1 = $row1['UNIT_CODE'];
	$NRPT_NAME = $row1['NRPT_NAME'];
	$NRPT_ACM = $row1['NRPT_ACM'];
	$NRPT_NUNIT = $row1['NRPT_NUNIT'];
	$NRPT_NPAGE = $row1['NRPT_NPAGE'];
	$NRPT_DMYUPD = $row1['NRPT_DMYUPD'];
	$NRPT_UNIT_PARENT = $row1['NRPT_UNIT_PARENT'];
    $NRPT_USER = $row1['NRPT_USER'];

    $NRPT_NAME = explode(' ', $row1['NRPT_NAME']); 
    $NRPT_NAME = $NRPT_NAME[0];

    $sql2 ="SELECT * FROM j3_nrpt WHERE UNIT_CODE = :NRPT_UNIT_PARENT";
    $stmt2=$db->prepare($sql2);
    $stmt2->bindparam(':NRPT_UNIT_PARENT',$NRPT_UNIT_PARENT);
    $stmt2->execute();
    $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
        $UNIT_CODE2 = $row2['UNIT_CODE'];
        $NRPT_NAME2 = $row2['NRPT_NAME'];
        $NRPT_ACM2 = $row2['NRPT_ACM'];
        $NRPT_NUNIT2 = $row2['NRPT_NUNIT'];
        $NRPT_NPAGE2 = $row2['NRPT_NPAGE'];
        $NRPT_DMYUPD2 = $row2['NRPT_DMYUPD'];
        $NRPT_UNIT_PARENT2 = $row2['NRPT_UNIT_PARENT'];
        $NRPT_USER2 = $row2['NRPT_USER'];

$sql ="SELECT * FROM j3_ack WHERE UNIT_ACM_ID = :NRPT_UNIT_PARENT";
$stmt=$db->prepare($sql);
$stmt->bindparam(':NRPT_UNIT_PARENT',$NRPT_UNIT_PARENT);
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
$UNIT_CODE2 = $row['UNIT_CODE'];
$UNIT_NAME = $row['UNIT_NAME'];
$UNIT_NAME_ACK = $row['UNIT_NAME_ACK'];
$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
$ACK_TIMESTAMP = $row['ACK_TIMESTAMP'];
$ACK_STS = $row['ACK_STS'];
$ACK_VERSION = $row['ACK_VERSION'];

$UNIT_NAME = explode(' ', $row['UNIT_NAME']); 
$UNIT_NAME = $UNIT_NAME[0];

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 16,
	'default_font' => 'sarabun',
	'setAutoTopMargin' => 'stretch'
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
