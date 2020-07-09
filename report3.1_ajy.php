<?php

include('db/connectpdo.php');


require_once 'pdf/vendor/autoload.php';

$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];

$AJY_NUM_ID = $_GET['id5'];

// $sql_personal = "SELECT * FROM j3_ratepersonal WHERE ROST_ID =:";
// $stmt_personal=$db->prepare($sql_personal);
// $stmt_personal->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
// $stmt_personal->execute();
// $row_personal=$stmt_personal->fetch(PDO::FETCH_ASSOC);
// $PERSONAL_ROST_ID = $row_personal['ROST_ID'];

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

$AJY_TIMESTAMP = explode(' ', $row_1['AJY_TIMESTAMP']); 
$AJY_TIMESTAMP = $AJY_TIMESTAMP[0];

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


$NRPT_NAME_SUB = explode(' ', $row_unit['NRPT_NAME']); 
$NRPT_NAME_SUB = $NRPT_NAME_SUB[0];

$mpdf = new \Mpdf\Mpdf([ 'orientation' => 'L',
	'default_font_size' => 16,
    'default_font' => 'sarabun',
    'margin_bottom' => 25,
    'setAutoTopMargin' => 'stretch',

]);

$html = '<htmlpageheader name="myHeader1">
    <table width="100%" style="border-style: none;">
        <tr>
            <td width="33%" style="border-style: none;"></td>
            <td width="33%" align="center" style="font-size:50px; border-style: none;"><font color=#E80000><b>ลับมาก</b></font></td>
            <td width="33%" style="text-align: right; border-style: none;">'.$NRPT_NAME_SUB.'<br>
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

$html .='<div style="text-align: left;">ตอนที่ 3 อัตรากำลังพล กองบัญชาการกองทัพไทย อจย.'.$AJY_ID.' ('.$AJY_TIMESTAMP.') '.$NRPT_NAME.'</div><br>';
$html .= '<div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>                          
                    <tr>
						<th rowspan="2" style="text-align: center;"><span class="textAlignVer">วรรค</span></th>
						<th rowspan="2" style="text-align: center;">ลำดับ</th>
						<th rowspan="2" style="text-align: center;">ตำแหน่ง</th>
						<th rowspan="2" style="text-align: center;">เงินเดือนอัตรา</th>
                        <th colspan="3" style="text-align: center;">อัตราระดับความพร้อมรบ</th>
                        <th rowspan="2" style="text-align: center;">เหล่า</th>
						<th rowspan="2" style="text-align: center;">ชกท.</th>
						<th rowspan="2" style="text-align: center;">อาวุธ</th>
                        <th rowspan="2" style="text-align: center;">หมายเหตุ</th>
                        <tr>
						    <th style="text-align: center;">เต็ม</th>
						    <th style="text-align: center;">ลด</th>
						    <th style="text-align: center;">โครง</th>
					    </tr>
                    </tr>
                </thead>
                <tbody>';
                $i = "00";
                $j = "00";
                $SUM = "0";
                $SUM_1 = "0";
                $SUM_2 = "0";
                $SUM_3 = "0";
                $SUM_4 = "0";
                $SUM_5 = "0";
                $SUM_6 = "0";
                $SUM_7 = "0";
                $SUM_8 = "0";
                $SUM_9 = "0";
                $SUM_10 = "0";
                $SUM_11 = "0";
                $SUM_AJY = "0";
                                $html .= '<tr>
                                <td style="width: 20px; text-align: center;"></td>
                                <td style="width: 20px; text-align: center;"></td>
                                <td style="width: 250px; text-align: left; vertical-align: top;"><u>สรุปยอดกำลังพล'.$NRPT_NAME.'<br>(อจย.'.$AJY_ID.')('.$AJY_TIMESTAMP.')</u><br>';
                                    $sql2 ="SELECT * FROM j3_nrpt_transaction
                                    WHERE NRPT_UNIT_PARENT = :UNIT_CODE1 AND AJY_NUM_ID = '$AJY_NUM_ID'";
                                    $stmt2=$db->prepare($sql2);
                                    $stmt2->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                    $stmt2->execute();
                                    
                                    while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                                        $NRPT_NAME3 = $row2['NRPT_NAME'];
                                        $UNIT_CODE_AJY = $row2['UNIT_CODE'];
            
                                        $NRPT_NAME3 = explode(' ', $row2['NRPT_NAME']); 
                                        $NRPT_NAME3 = $NRPT_NAME3[0];

                                        $SUB_AJY_ID_L = substr($AJY_ID, 3, 5);
                                        $SUB_AJY_ID_A = substr($AJY_ID, 0, 3);
                                        
                                        $SUB_AJY = substr($UNIT_CODE_AJY,8,10);
                                        if($SUB_AJY == 00){
                                            $i++;
                                            $SUM_AJY = $SUB_AJY_ID_L+$i;
                                            $html .='- '.$NRPT_NAME3.'<br>(อจย.'.$SUB_AJY_ID_A.''.$SUM_AJY.')('.$AJY_TIMESTAMP.')<br>';
                                        }
                                    }
                                $html.='<td style="width: 330px; text-align: left; vertical-align: top;">';
                                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                            WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                            GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                            $stmt3=$db->prepare($sql3);
                                            $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                            $stmt3->execute();
                                            while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                                $COUNT_1 = $row3['COUNT(ROST_ID)'];
                                                $ROST_RANK1 = $row3['ROST_RANK'];
                                                //$html .=''.$COUNT_1.'<br>';
                                                //$SUM = $SUM+$COUNT_1;
                                                if($ROST_RANK1 == "06"){
                                                    $html.='พันเอก นาวาเอก นาวาอากาศเอก<br>';
                                                }elseif($ROST_RANK1 == "07"){
                                                    $html.='พันโท นาวาโท นาวาอากาศโท<br>';
                                                }elseif($ROST_RANK1 == "08"){
                                                    $html.='พันตรี นาวาตรี นาวาอากาศตรี<br>';
                                                }elseif($ROST_RANK1 == "09"){
                                                    $html.='ร้อยเอก เรือเอก เรืออากาศเอก<br>';
                                                }elseif($ROST_RANK1 == "10"){
                                                    $html.='ร้อยโท เรือโท เรืออากาศโท<br>';
                                                }elseif($ROST_RANK1 == "21"){
                                                    $html.='จ่าสิบเอกพิเศษ พันจ่าเอกพิเศษ พันจ่าอากาศเอกพิเศษ<br>';
                                                }elseif($ROST_RANK1 == "22"){
                                                    $html.='จ่าสิบเอก พันจ่าเอก พันจ่าอากาศเอก<br>';
                                                }elseif($ROST_RANK1 == "25"){
                                                    $html.='สิบเอก จ่าเอก จ่าอากาศเอก<br>';
                                                }elseif($ROST_RANK1 == "27"){
                                                    $html.='สิบตรี จ่าตรี จ่าอากาศตรี<br>';
                                                }elseif($ROST_RANK1 == "32"){
                                                    $html.='พลทหาร';
                                                }
                                            }
                                    $html .= '</td>
                                    <td style="width: 55px; text-align: center; vertical-align: top;">';
                                                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                                $stmt3=$db->prepare($sql3);
                                                $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                                $stmt3->execute();
                                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                                    $COUNT_1 = $row3['COUNT(ROST_ID)'];
                                                    $ROST_RANK1 = $row3['ROST_RANK'];
                                                    if($ROST_RANK1 == "06"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "07"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "08"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "09"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "10"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "21"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "22"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "25"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "27"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }elseif($ROST_RANK1 == "32"){
                                                        $html .=''.$COUNT_1.'<br>';
                                                    }
                                                    // $html .=''.$COUNT_1.'<br>';
                                                    $SUM = $SUM+$COUNT_1;
                                                }
                                    $html .='</td>
                                        <td style="width: 55px; text-align: center; vertical-align: top;">';

                                            $sql_N ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                            WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                            GROUP BY ROST_RANK,ROST_POSNAME_ACM ORDER BY ROST_RANK";
                                            $stmt_N=$db->prepare($sql_N);
                                            $stmt_N->execute();

                                            while($row_N=$stmt_N->fetch(PDO::FETCH_ASSOC)){
                                                $COUNT_N = $row_N['COUNT(ROST_ID)'];
                                                $RANK_N = $row_N['ROST_RANK'];
                                                $AJY_CUT_N = $row_N['AJY_CUT'];

                                                if($RANK_N == "06"){
                                                    $SUM_6 = $SUM_6+$AJY_CUT_N;
                                                }elseif($RANK_N == "07"){
                                                    $SUM_7 = $SUM_7+$AJY_CUT_N;
                                                }elseif($RANK_N == "08"){
                                                    $SUM_8 = $SUM_8+$AJY_CUT_N;
                                                }elseif($RANK_N == "09"){
                                                    $SUM_9 = $SUM_9+$AJY_CUT_N;
                                                }elseif($RANK_N == "10"){
                                                    $SUM_10 = $SUM_10+$AJY_CUT_N;
                                                }elseif($RANK_N == "21"){
                                                    $SUM_11 = $SUM_11+$AJY_CUT_N;
                                                }elseif($RANK_N == "22"){
                                                    $SUM_12 = $SUM_12+$AJY_CUT_N;
                                                }elseif($RANK_N == "25"){
                                                    $SUM_13 = $SUM_13+$AJY_CUT_N;
                                                }elseif($RANK_N == "27"){
                                                    $SUM_14 = $SUM_14+$AJY_CUT_N;
                                                }elseif($RANK_N == "32"){
                                                    $SUM_15 = $SUM_15+$AJY_CUT_N;
                                                }

                                            }

                                                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                                $stmt3=$db->prepare($sql3);
                                                $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                                $stmt3->execute();
                                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                                    $COUNT_1 = $row3['COUNT(ROST_ID)'];
                                                    $AJY_CUT = $row3['AJY_CUT'];
                                                    $ROST_RANK1 = $row3['ROST_RANK'];
                                                    
                                                    if($ROST_RANK1 == "06"){
                                                        $html .=''.$SUM_6.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_6;
                                                    }elseif($ROST_RANK1 == "07"){
                                                        $html .=''.$SUM_7.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_7;
                                                    }elseif($ROST_RANK1 == "08"){
                                                        $html .=''.$SUM_8.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_8;
                                                    }elseif($ROST_RANK1 == "09"){
                                                        $html .=''.$SUM_9.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_9;
                                                    }elseif($ROST_RANK1 == "10"){
                                                        $html .=''.$SUM_10.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_10;
                                                    }elseif($ROST_RANK1 == "21"){
                                                        $html .=''.$SUM_11.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_11;
                                                    }elseif($ROST_RANK1 == "22"){
                                                        $html .=''.$SUM_12.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_12;
                                                    }elseif($ROST_RANK1 == "25"){
                                                        $html .=''.$SUM_13.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_13;
                                                    }elseif($ROST_RANK1 == "27"){
                                                        $html .=''.$SUM_14.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_14;
                                                    }elseif($ROST_RANK1 == "32"){
                                                        $html .=''.$SUM_15.'<br>';
                                                        $SUM_1 = $SUM_1+$SUM_15;
                                                    }
                                                    
                                                }
                                    $html .='</td>
                                        <td style="width: 55px; text-align: center; vertical-align: top;">';
                                            $sql_N2 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                            WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                            GROUP BY ROST_RANK,ROST_POSNAME_ACM ORDER BY ROST_RANK";
                                            $stmt_N2=$db->prepare($sql_N2);
                                            $stmt_N2->execute();

                                            while($row_N2=$stmt_N2->fetch(PDO::FETCH_ASSOC)){
                                                $COUNT_N2 = $row_N2['COUNT(ROST_ID)'];
                                                $RANK_N2 = $row_N2['ROST_RANK'];
                                                $AJY_KORG = $row_N2['AJY_KORG'];

                                                if($RANK_N2 == "06"){
                                                    $SUM_6_2 = $SUM_6_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "07"){
                                                    $SUM_7_2 = $SUM_7_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "08"){
                                                    $SUM_8_2 = $SUM_8_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "09"){
                                                    $SUM_9_2 = $SUM_9_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "10"){
                                                    $SUM_10_2 = $SUM_10_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "21"){
                                                    $SUM_11_2 = $SUM_11_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "22"){
                                                    $SUM_12_2 = $SUM_12_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "25"){
                                                    $SUM_13_2 = $SUM_13_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "27"){
                                                    $SUM_14_2 = $SUM_14_2+$AJY_KORG;
                                                }elseif($RANK_N2 == "32"){
                                                    $SUM_15_2 = $SUM_15_2+$AJY_KORG;
                                                }

                                            }

                                                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                                $stmt3=$db->prepare($sql3);
                                                $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                                $stmt3->execute();
                                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                                    $COUNT_1 = $row3['COUNT(ROST_ID)'];
                                                    //$AJY_CUT = $row3['AJY_CUT'];
                                                    $ROST_RANK1 = $row3['ROST_RANK'];
                                                    
                                                    if($ROST_RANK1 == "06"){
                                                        $html .=''.$SUM_6_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_6_2;
                                                    }elseif($ROST_RANK1 == "07"){
                                                        $html .=''.$SUM_7_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_7_2;
                                                    }elseif($ROST_RANK1 == "08"){
                                                        $html .=''.$SUM_8_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_8_2;
                                                    }elseif($ROST_RANK1 == "09"){
                                                        $html .=''.$SUM_9_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_9_2;
                                                    }elseif($ROST_RANK1 == "10"){
                                                        $html .=''.$SUM_10_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_10_2;
                                                    }elseif($ROST_RANK1 == "21"){
                                                        $html .=''.$SUM_11_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_11_2;
                                                    }elseif($ROST_RANK1 == "22"){
                                                        $html .=''.$SUM_12_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_12_2;
                                                    }elseif($ROST_RANK1 == "25"){
                                                        $html .=''.$SUM_13_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_13_2;
                                                    }elseif($ROST_RANK1 == "27"){
                                                        $html .=''.$SUM_14_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_14_2;
                                                    }elseif($ROST_RANK1 == "32"){
                                                        $html .=''.$SUM_15_2.'<br>';
                                                        $SUM_3 = $SUM_3+$SUM_15_2;
                                                    }
                                                    
                                                }
                                    $html .='</td>
                                        <td style="width: 20px; text-align: center; vertical-align: top;"></td>
                                        <td style="width: 20px; text-align: center; vertical-align: top;"></td>
                                        <td style="width: 20px; text-align: center; vertical-align: top;"></td>
                                        <td style="width: 50px; text-align: center; vertical-align: top;">';
                                                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_RANK ORDER BY ROST_RANK";
                                                $stmt3=$db->prepare($sql3);
                                                $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                                $stmt3->execute();
                                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                                    $COUNT_1 = $row3['COUNT(ROST_ID)'];
                                                    $ROST_RANK1 = $row3['ROST_RANK'];
                                                    if($ROST_RANK1 == 10){
                                                        $html .='(1)<br>';
                                                    }elseif($ROST_RANK1 == 21){
                                                        $html .='(2)<br>';
                                                    }else{
                                                        $html .='<br>';
                                                    }
                                                }
                                        $html.='</td>
                                    </tr>';
                $html.='<tr>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 300px; text-align: center;"></td>
                    <td style="width: 300px; text-align: center;">รวมทั้งสิ้น</td>
                    <td style="width: 20px; text-align: center;">'.$SUM.'</td>
                    <td style="width: 20px; text-align: center;">'.$SUM_1.'</td>
                    <td style="width: 20px; text-align: center;">'.$SUM_3.'</td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';

	$html .='</tbody>
    </table>
</div><br>';
$html .= '<div style="text-align: left"><u>หมายเหตุ</u> 1. ตำแหน่ง "นายทหารชำนาญงาน" เงินเดือนอัตรา ร้อยโท เรือโท เรืออากาศโท (ตามหมายเหตุ (1)) เป็นอันตราตำแหน่งในจำนวนที่เท่ากันกับตำแหน่ง<br>
ที่เป็นเงินเดือนอัตรา จ่าสิบเอกพิเศษ พันจ่าเอกพิเศษ พันจ่าอากาศเอกพิเศษ ของหน่วย ที่มีคุณสมบัติครบและได้รับการเลื่อนฐานะเป็นนายทหารสัญญาบัตร<br>
ตามที่กระทรวงกลาโหมกำหนด<br> 
2. เงินเดือนอัตรา จ่าสิบเอกพิเศษ พันจ่าเอกพิเศษ พันจ่าอากาศเอกพิเศษ (ตามหมายเหตุ(2)) เมื่อผู้ดำรงตำแหน่งนี้ มีคุณสมบัติครบและได้รับการเลื่อนฐานะ<br>
เป็นนายทหารสัญญาบัตรตามที่กระทรวงกลาโหมกำหนด ให้ปรับเป็นตำแหน่ง "นายทหารชำนาญงาน" เงินเดือนอัตรา ร้อยโท เรือโท เรืออากาศโท ทั้งนี้ การบริหาร<br>
จัดการกำลังพลในตำแหน่ง นายทหารชำนาญงานทุกตำแหน่งให้เป็นไปตามที่กระทรวงกลาโหมกำหนด</div>';
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