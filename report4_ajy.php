<?php

include('db/connectpdo.php');

require_once 'pdf/vendor/autoload.php';

$AJY_NUM_ID = $_GET['id'];

$sql_1 ="SELECT * FROM j3_ajy WHERE AJY_NUM_ID = :AJY_NUM_ID";
$stmt_1=$db->prepare($sql_1);
$stmt_1->bindparam(':AJY_NUM_ID',$AJY_NUM_ID);
$stmt_1->execute();
$row_1=$stmt_1->fetch(PDO::FETCH_ASSOC);
$AJY_NUM_ID = $row_1['AJY_NUM_ID'];
$AJY_ID = $row_1['AJY_ID'];
$AJY_MISSION = $row_1['AJY_MISSION'];
$AJY_DISTRIBUTION = $row_1['AJY_DISTRIBUTION'];
$AJY_ESSENCE = $row_1['AJY_ESSENCE'];
$AJY_SCOPE = $row_1['AJY_SCOPE'];
$AJY_DIVISION = $row_1['AJY_DIVISION'];
$AJY_EXPLANATION = $row_1['AJY_EXPLANATION'];
$AJY_SUMMARY = $row_1['AJY_SUMMARY'];
$AJY_USER = $row_1['AJY_USER'];
$AJY_NAME = $row_1['AJY_NAME'];
$UNIT_CODE1 = $row_1['UNIT_CODE'];
$UNIT_NAME = $row_1['UNIT_NAME'];
$UNIT_NAME_AJY = $row_1['UNIT_NAME_AJY'];
$UNIT_CODE_PARENT = $row_1['UNIT_CODE_PARENT'];
$AJY_TIMESTAMP = $row_1['AJY_TIMESTAMP'];
$AJY_STS = $row_1['AJY_STS'];
$AJY_VERSION = $row_1['AJY_VERSION'];

$sql_unit ="SELECT * FROM j3_nrpt_transaction WHERE UNIT_CODE = :UNIT_CODE1 AND AJY_NUM_ID = '$AJY_NUM_ID'";
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

$html .='<div style="text-align: left;">อัตราเฉพาะกิจ<br>หมายเลข '.$AJY_ID.'</div>';

$html .= '<div style="text-align: center"><u>'.$NRPT_NAME.'<br>'.$NRPT_NAME2.'<br>กองบัญชาการกองทัพไทย</u><br>ตอนที่ 4 คำชี้แจง</div><br>';
$html .= '<div style="text-align:left"><u>คำชี้แจง</u></div><div>'.$AJY_EXPLANATION.'</div>';

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
