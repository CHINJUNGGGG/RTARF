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
						<th rowspan="2" style="text-align: center;">ตำแหน่ง</th>
                        <th colspan="3" style="text-align: center;">อัตรา</th>
                        <th colspan="5" style="text-align: center;">นายทหาร</th>
						<th colspan="5" style="text-align: center;">นายสิบ/พลทหาร</th>
                        <th rowspan="2" style="text-align: center;">หมายเหตุ</th>
                        <tr>
						    <th style="text-align: center;">เต็ม</th>
						    <th style="text-align: center;">ลด</th>
						    <th style="text-align: center;">โครง</th>
						    <th style="text-align: center; vertical-align: top;">พ.อ.<br>น.อ.</th>
						    <th style="text-align: center; vertical-align: top;">พ.ท.<br>น.ท.</th>
						    <th style="text-align: center; vertical-align: top;">พ.ต.<br>น.ต.</th>
						    <th style="text-align: center; vertical-align: top;">ร.อ.</th>
						    <th style="text-align: center; vertical-align: top;">ร.ท.</th>
						    <th style="text-align: center; vertical-align: top;">จ.ส.อ.(พ)<br>พ.จ.อ.(พ)<br>พ.อ.อ.(พ)</th>
						    <th style="text-align: center; vertical-align: top;">จ.ส.อ.<br>พ.จ.อ.<br>พ.อ.อ.</th>
						    <th style="text-align: center; vertical-align: top;">ส.อ.<br>จ.อ.</th>
						    <th style="text-align: center; vertical-align: top;">ส.ต.<br>จ.ต.</th>
						    <th style="text-align: center; vertical-align: top;">พลทหาร</th>
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
                $SUM_10 = "0";
                $SUM_11 = "0";

                $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                GROUP BY ROST_RANK ORDER BY ROST_RANK";
                $stmt3=$db->prepare($sql3);
                $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                $stmt3->execute();
                $RANK = array();
                $COUNT_AR = array();
                // $COUNT_CUT = array();
                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                    $COUNT_1 = $row3['COUNT(ROST_ID)'];
                    $ROST_RANK1 = $row3['ROST_RANK'];
                    $ROST_CPOS = $row3['ROST_CPOS'];
                    $ROST_POSNAME = $row3['ROST_POSNAME'];
                    $AJY_CUT = $row3['AJY_CUT'];
                    
                    //echo $ROST_RANK1;
                    $SUB_CPOS = substr($ROST_CPOS,0,5);

                    $ROST_POSNAME_SUB = explode(' ',$row3['ROST_POSNAME']);
                    $ROST_POSNAME_SUB = $ROST_POSNAME_SUB[0];

                    
                    $SUM = $SUM+$COUNT_1;
                    // $SUM_6 = $SUM_6+$AJY_CUT;
                    //60003
                    if($ROST_RANK1 == "06" || $ROST_RANK1 == "07" || $ROST_RANK1 == "08" || $ROST_RANK1 == "09" || $ROST_RANK1 == "10"){
                        $SUM_1 = $SUM_1+$COUNT_1;
                        // $SUM_7 = $SUM_7+$AJY_CUT;
                    }elseif($ROST_RANK1 == "21" || $ROST_RANK1 == "22" || $ROST_RANK1 == "25"){
                        $SUM_2 = $SUM_2+$COUNT_1;
                        // $SUM_8 = $SUM_8+$AJY_CUT;
                    }elseif($ROST_RANK1 == "27" || $ROST_RANK1 == "32"){
                        //$SUM_3 = $SUM_3+$COUNT_1;
                        if($ROST_RANK1 == "32"){
                            $sql4 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                            WHERE ROST_POSNAME LIKE '%ทหารประจำตัว%' AND AJY_NUM_ID = '$AJY_NUM_ID'
                            GROUP BY ROST_RANK ORDER BY ROST_RANK";
                            $stmt4=$db->prepare($sql4);
                            $stmt4->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                            $stmt4->execute();
                            $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
                            $COUNT_2 = $row4['COUNT(ROST_ID)'];
                            $AJY_CUT_2 = $row4['AJY_CUT'];
                            $SUM_4 = $SUM_4+$COUNT_2;
                        }
                        $SUM_3 = $SUM_3+$COUNT_1;
                    }
                    $COUNT_AR[] = $COUNT_1;
                    $RANK[] = $ROST_RANK1;
                }
                                
                $html.='<tr>
                    <td style="width: 200px; text-align: left;"><u>อัตราเต็ม</u></td>
                    <td style="width: 50px; text-align: center;">'.$SUM.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">นายทหารสัญญาบัตร</td>
                    <td style="width: 50px; text-align: center;">'.$SUM_1.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("06", $RANK)){
                            $html .=$COUNT_AR[array_search("06", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("07", $RANK)){
                            $html .=$COUNT_AR[array_search("07", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("08", $RANK)){
                            $html .=$COUNT_AR[array_search("08", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("09", $RANK)){
                            $html .=$COUNT_AR[array_search("09", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("10", $RANK)){
                            $html .=$COUNT_AR[array_search("10", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">นายทหารประทวน</td>
                    <td style="width: 50px; text-align: center;">'.$SUM_2.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("21", $RANK)){
                            $html .=$COUNT_AR[array_search("21", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("22", $RANK)){
                            $html .=$COUNT_AR[array_search("22", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("25", $RANK)){
                            $html .=$COUNT_AR[array_search("25", $RANK)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">พลทหาร</td>
                    <td style="width: 50px; text-align: center;">';
                    $html .= $SUM_3-$SUM_4;
                    $html .= '</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">';
                    if(in_array("27", $RANK)){
                        $html .=$COUNT_AR[array_search("27", $RANK)];
                        //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                    }else{
                        $html .= '-';
                    }
                $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                    if(in_array("32", $RANK)){
                        $SUM_10 = $COUNT_AR[array_search("32", $RANK)];
                        $html .= $SUM_10 - $SUM_4;
                    }else{
                        $html .= '-';
                    }
                $html .='</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">ทหารประจำตัว</td>
                    <td style="width: 50px; text-align: center;">'.$SUM_4.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">'.$SUM_4.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';

                    $sql_N ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                    WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                    GROUP BY ROST_RANK,ROST_POSNAME_ACM ORDER BY ROST_RANK";
                    $stmt_N=$db->prepare($sql_N);
                    $stmt_N->execute();

                    // $SUM_5 = 0;
                    $SUM_6 = 0;
                    $SUM_7 = 0;
                    $SUM_8 = 0;
                    $SUM_9 = 0;
                    while($row_N=$stmt_N->fetch(PDO::FETCH_ASSOC)){
                        $COUNT_N = $row_N['COUNT(ROST_ID)'];
                        $RANK_N = $row_N['ROST_RANK'];
                        $AJY_CUT_N = $row_N['AJY_CUT'];

                        $SUM_6 = $SUM_6+$AJY_CUT_N;

                        if($RANK_N == "06" || $RANK_N == "07" || $RANK_N == "08" || $RANK_N == "09" || $RANK_N == "10"){
                            $SUM_7 = $SUM_7+$AJY_CUT_N;
                        }elseif($RANK_N == "21" || $RANK_N == "22" || $RANK_N == "25"){
                            $SUM_8 = $SUM_8+$AJY_CUT_N;
                        }elseif($RANK_N == "27" || $RANK_N == "32"){
                            if($RANK_N == "32"){
                                $sql_4 ="SELECT * FROM j3_rost_transaction
                                WHERE ROST_POSNAME LIKE '%ทหารประจำตัว%' AND AJY_NUM_ID = '$AJY_NUM_ID'
                                GROUP BY ROST_RANK,ROST_POSNAME_ACM ORDER BY ROST_RANK";
                                $stmt_4=$db->prepare($sql_4);
                                //$stmt4->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                                $stmt_4->execute();
                                $SUM_5 = 0;
                                // $SUM_9 = 0;
                                while($row_4=$stmt_4->fetch(PDO::FETCH_ASSOC)){
                                    $AJY_CUT_4 = $row_4['AJY_CUT'];
                                    $RANK_4 = $row_4['ROST_RANK'];
                                    $SUM_5 = $SUM_5+$AJY_CUT_4;
                                }
                                // $SUM_9 = 0;
                                // $SUM_9 = $SUM_9+$AJY_CUT_N;
                            }
                            // $SUM_9 = ($SUM_9-$SUM_5)+$AJY_CUT_N;
                            $SUM_9 = $SUM_9+$AJY_CUT_N;
                        }
                        
                        //print_r($RANK_CUT);
                    }
                $html.='<tr>
                    <td style="width: 200px; text-align: left;"><u>อัตราลด</u></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">'.$SUM_6.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">นายทหารสัญญาบัตร</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">'.$SUM_7.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">';
                        $sql_N ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                        WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                        GROUP BY ROST_RANK,ROST_POSNAME_ACM ORDER BY ROST_RANK";
                        $stmt_N=$db->prepare($sql_N);
                        $stmt_N->execute();

                        $COUNT_CUT = array();
                        $RANK_SUM = array();
                        
                        while($row_N=$stmt_N->fetch(PDO::FETCH_ASSOC)){
                            $COUNT_N = $row_N['COUNT(ROST_ID)'];
                            $RANK_N = $row_N['ROST_RANK'];
                            $AJY_CUT_N = $row_N['AJY_CUT'];

                            if($RANK_N == "06"){
                                $SUM_20 = $SUM_20+$AJY_CUT_N;
                            }elseif($RANK_N == "07"){
                                $SUM_21 = $SUM_21+$AJY_CUT_N;
                            }elseif($RANK_N == "08"){
                                $SUM_22 = $SUM_22+$AJY_CUT_N;
                            }elseif($RANK_N == "09"){
                                $SUM_23 = $SUM_23+$AJY_CUT_N;
                            }elseif($RANK_N == "10"){
                                $SUM_24 = $SUM_24+$AJY_CUT_N;
                            }elseif($RANK_N == "21"){
                                $SUM_25 = $SUM_25+$AJY_CUT_N;
                            }elseif($RANK_N == "22"){
                                $SUM_26 = $SUM_26+$AJY_CUT_N;
                            }elseif($RANK_N == "25"){
                                $SUM_27 = $SUM_27+$AJY_CUT_N;
                            }elseif($RANK_N == "27"){
                                $SUM_28 = $SUM_28+$AJY_CUT_N;
                            }elseif($RANK_N == "32"){
                                $SUM_29 = $SUM_29+$AJY_CUT_N;
                            }

                        }
                        $SUM_CUT = array($SUM_20, $SUM_21, $SUM_22, $SUM_23, $SUM_24, $SUM_25, $SUM_26, $SUM_27, $SUM_28, $SUM_29);

                        // $sql3 ="SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                        // WHERE AJY_NUM_ID = '$AJY_NUM_ID'
                        // GROUP BY ROST_RANK ORDER BY ROST_RANK";
                        // $stmt3=$db->prepare($sql3);
                        // $stmt3->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                        // $stmt3->execute();
                        // while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
                        //     $ROST_RANK1 = $row3['ROST_RANK'];

                        //     $RANK_CUT[] = $ROST_RANK1;
                        // }
                        $RANK_CUT = array("06", "07", "08", "09", "10", "21", "22", "25", "27", "32");
                        if(in_array("06", $RANK_CUT)){
                            if($SUM_CUT[array_search("06", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("06", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("06", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                            // $html .=$SUM_CUT[array_search("06", $RANK_CUT)];
                            //$SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("07", $RANK_CUT)){
                            // $html .=$SUM_CUT[array_search("07", $RANK_CUT)];
                            if($SUM_CUT[array_search("07", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("07", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("07", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("08", $RANK_CUT)){
                            if($SUM_CUT[array_search("08", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("08", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("08", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("09", $RANK_CUT)){
                            if($SUM_CUT[array_search("09", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("09", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("09", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("10", $RANK_CUT)){
                            if($SUM_CUT[array_search("10", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("10", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("10", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">นายทหารประทวน</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">'.$SUM_8.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("21", $RANK_CUT)){
                            if($SUM_CUT[array_search("21", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("21", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("21", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("22", $RANK_CUT)){
                            if($SUM_CUT[array_search("22", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("22", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("22", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                        if(in_array("25", $RANK_CUT)){
                            if($SUM_CUT[array_search("25", $RANK_CUT)] != ''){
                                if($SUM_CUT[array_search("25", $RANK_CUT)] == '0'){
                                    $html .= '-';
                                }else{
                                    $html .=$SUM_CUT[array_search("25", $RANK_CUT)];
                                }
                            }else{
                                $html .= '-';
                            }
                        }else{
                            $html .= '-';
                        }
                    $html .='</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">พลทหาร</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">';
                    $html .= $SUM_9-$SUM_5;
                    $html .= '</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">';
                    if(in_array("27", $RANK_CUT)){
                        if($SUM_CUT[array_search("27", $RANK_CUT)] != ''){
                            if($SUM_CUT[array_search("27", $RANK_CUT)] == '0'){
                                $html .= '-';
                            }else{
                                $html .=$SUM_CUT[array_search("27", $RANK_CUT)];
                            }
                        }else{
                            $html .= '-';
                        }
                    }else{
                        $html .= '-';
                    }
                $html .='</td>
                    <td style="width: 50px; text-align: center;">';
                    if(in_array("32", $RANK_CUT)){
                        // $SUM_11 = $SUM_CUT[array_search("32", $RANK_CUT)];
                        // $html .= $SUM_11 - $SUM_5;
                        if($SUM_CUT[array_search("32", $RANK_CUT)] != ''){
                            if($SUM_CUT[array_search("32", $RANK_CUT)] == '0'){
                                $html .= '-';
                            }else{
                                $SUM_11 = $SUM_CUT[array_search("32", $RANK_CUT)];
                                $html .= $SUM_11 - $SUM_5;
                            }
                        }else{
                            $html .= '-';
                        }
                    }else{
                        $html .= '-';
                    }
                $html .='</td>
                    <td style="width: 50px; text-align: center;"></td>
                </tr>';
                $html.='<tr>
                    <td style="width: 200px; text-align: left;">ทหารประจำตัว</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">'.$SUM_5.'</td>
                    <td style="width: 50px; text-align: center;"></td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">-</td>
                    <td style="width: 50px; text-align: center;">'.$SUM_5.'</td>
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