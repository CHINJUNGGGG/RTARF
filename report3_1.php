<?php

include('connectpdo.php');


require_once 'pdf/vendor/autoload.php';

$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];

$ACK_NUM_ID = $_GET['id5'];

// $sql_personal = "SELECT * FROM j3_ratepersonal WHERE ROST_ID =:";
// $stmt_personal=$db->prepare($sql_personal);
// $stmt_personal->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
// $stmt_personal->execute();
// $row_personal=$stmt_personal->fetch(PDO::FETCH_ASSOC);
// $PERSONAL_ROST_ID = $row_personal['ROST_ID'];

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

$mpdf = new \Mpdf\Mpdf([ 'orientation' => 'L',
	'default_font_size' => 16,
    'default_font' => 'sarabun',
    'margin_bottom' => 25,
    'setAutoTopMargin' => 'stretch',
    //'setAutoBottomMargin' => 'pad'

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

$html .= '<div style="text-align: center"><u>'.$NRPT_NAME.'<br>'.$NRPT_NAME2.'<br>กองบัญชาการกองทัพไทย</u><br>ตอนที่ 3 อัตรากำลังพล</div><br>';

$html .= '<div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>                                                        
                    <tr>
						<th rowspan="2" style="text-align: center;"><span class="textAlignVer">วรรค</span></th>
						<th rowspan="2" style="text-align: center;">ลำดับ</th>
						<th rowspan="2" style="text-align: center;">ตำแหน่ง</th>
						<th rowspan="2" style="text-align: center;">ยอดกำลังพล</th>
						<th rowspan="2" style="text-align: center;">ชกท.</th>
						<th rowspan="2" style="text-align: center;">เหล่า</th>
                        <th colspan="10" style="text-align: center;">นายทหารสัญญาบัตร</th>
                        <th colspan="6" style="text-align: center;">นายทหารประทวน</th>
                        <th rowspan="2" style="text-align: center;">หมายเหตุ</th>
                        <tr>
                            <th style="text-align: center;"><span style="transform:rotate(-90deg);">พล.อ.พ.<br>พล.ร.อ.พ.<br>พล.อ.อ.พ.</span></th>
                            <th style="text-align: center;"><span style="transform:rotate(-90deg);">พล.อ.<br>พล.ร.อ.<br>พล.อ.อ.</span></th>
                            <th style="text-align: center;"><span style="transform:rotate(-90deg);">พล.ท.<br>พล.ร.ท.<br>พล.อ.ท.</span></th>
						    <th style="text-align: center;">พล.ต.<br>พล.ร.ต.<br>พล.อ.ต.</th>
						    <th style="text-align: center;">พ.อ.(พ)<br>น.อ.(พ)</th>
						    <th style="text-align: center;">พ.อ.<br>น.อ.</th>
						    <th style="text-align: center;">พ.ท.<br>น.ท.</th>
						    <th style="text-align: center;">พ.ต.<br>น.ต.</th>
						    <th style="text-align: center;">ร.อ.</th>
						    <th style="text-align: center;">ร.ท.</th>
						    <th style="text-align: center;">จ.ส.อ.(พ)<br>พ.จ.อ.(พ)<br>พ.อ.อ.(พ)</th>
						    <th style="text-align: center;">จ.ส.อ.<br>พ.จ.อ.<br>พ.อ.อ.</th>
                            <th style="text-align: center;">ส.อ.<br>จ.อ.</th>
                            <th style="text-align: center;">ส.ต.<br>จ.ต.</th>
                            <th style="text-align: center;">พล.อส.</th>
                            <th style="text-align: center;">พลฯ</th>
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
                $SUM_12 = "0";
                $SUM_13 = "0";
                $SUM_14 = "0";
                $SUM_15 = "0";
                $SUM_16 = "0";
                if($UNIT_CODE2 == $UNIT_CODE1){
                    $j++;
                    $i++;  
                    if($j == "01"){
                        $sql_2 ="SELECT *,COUNT(TRANSACTION_ID) FROM j3_rost_transaction
                        WHERE ACK_NUM_ID = '$ACK_NUM_ID'
                        GROUP BY ROST_POSNAME_ACM ORDER BY ROST_ID";
                        $stmt_2=$db->prepare($sql_2);
                        //$stmt_2->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                        $stmt_2->execute();
                        $row_2=$stmt_2->fetch(PDO::FETCH_ASSOC);
                        $COUNT_1 = $row_2['COUNT(TRANSACTION_ID)'];
                        $ROST_RANK_1 = $row_2['ROST_RANK'];
                        $ROST_POSNAME_1 = $row_2['ROST_POSNAME'];
                        $ROST_NCPOS12_1 = $row_2['ROST_NCPOS12'];

                        $SUM = $SUM+$COUNT_1;

                        $ROST_POSNAME_1 = explode(' ', $row_2['ROST_POSNAME']);
                        $ROST_POSNAME_1 = $ROST_POSNAME_1[0];

                        $html .= '<tr>
                            <td style="width: 20px; text-align: center;">'.$j.'</td>
                            <td style="width: 20px; text-align: center;">'.$i.'</td>
                            <td style="width: 300px; text-align: left;">'.$ROST_POSNAME_1.'</td>';
                            $html .= '<td style="width: 30px; text-align: center;">';
                                if($ROST_NCPOS12_1 != ""){
                                    $html .= $COUNT_1;
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;"></td>
                            <td style="width: 20px; text-align: center;"></td>';
                            $html .='<td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "01"){
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .= $COUNT_1;
                                        $SUM_12 = $SUM_12+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "02"){
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .= $COUNT_1;
                                        $SUM_13 = $SUM_13+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "03"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_1 = $SUM_1+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "04"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_2 = $SUM_2+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "05"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_3 = $SUM_3+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "06"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_4 = $SUM_4+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "07"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_5 = $SUM_5+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "08"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_6 = $SUM_6+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "09"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_7 = $SUM_7+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "10"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_8 = $SUM_8+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "21"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_9 = $SUM_9+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "22"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_10 = $SUM_10+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "25"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_11 = $SUM_11+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>
                            <td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "27"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_14 = $SUM_14+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td><td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "31"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_15 = $SUM_15+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td><td style="width: 20px; text-align: center;">';
                                if($ROST_RANK_1 == "32"){
                                    
                                    if($ROST_NCPOS12_1 != ""){
                                        $html .=$COUNT_1;
                                        $SUM_15 = $SUM_15+$COUNT_1;
                                    }else{
                                        $html .= '-';
                                    }
                                }else{
                                    $html .= '-';
                                }
                            $html.='</td>';
                                    
                            $html.='<td style="width: 50px; text-align: center;"></td>
                        </tr>';
                    
                        $sql2 ="SELECT *,COUNT(TRANSACTION_ID) FROM j3_rost_transaction
                        WHERE ACK_NUM_ID = '$ACK_NUM_ID'
                        GROUP BY ROST_POSNAME_ACM ORDER BY ROST_ID";
                        $stmt2=$db->prepare($sql2);
                        //$stmt2->bindparam(':UNIT_CODE1',$UNIT_CODE1);
                        $stmt2->execute();
                        $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
                        
                        while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                            $COUNT = $row2['COUNT(TRANSACTION_ID)'];
                            $ROST_UNIT = $row2['ROST_UNIT'];
                            $ROST_CPOS = $row2['ROST_CPOS'];
                            $ROST_POSNAME = $row2['ROST_POSNAME'];
                            $ROST_POSNAME_ACM = $row2['ROST_POSNAME_ACM'];
                            $ROST_RANK = $row2['ROST_RANK'];
                            $ROST_RANKNAME = $row2['ROST_RANKNAME'];
                            $ROST_LAO_MAJ = $row2['ROST_LAO_MAJ'];
                            $ROST_NCPOS12 = $row2['ROST_NCPOS12'];
                            $ROST_ID = $row2['TRANSACTION_ID'];
                            $ROST_PARENT = $row2['ROST_PARENT'];
                            $ROST_NUNIT = $row2['ROST_NUNIT'];
                            $ROST_NPARENT = $row2['ROST_NPARENT'];
 
                            $ROST_POSNAME = explode(' ', $row2['ROST_POSNAME']);
                            $ROST_POSNAME = $ROST_POSNAME[0];
                            
                            //$i++;
                            if($ROST_RANK <= "32" && $ROST_RANK != 19 && $ROST_RANK != 29 && $ROST_RANK != 26){
                                $i++;
                                $html .= '<tr>
                                <td style="width: 20px; text-align: center;"></td>
                                <td style="width: 20px; text-align: center;">'.$i.'</td>
                                <td style="width: 300px; text-align: left;">'.$ROST_POSNAME.'</td>';
                                $html .= '<td style="width: 30px; text-align: center;">';
                                    if($ROST_NCPOS12 != ""){
                                        $html .= $COUNT;
                                    }else{
                                        $html .= '-';
                                    }
                                $html.='</td>
                                <td style="width: 20px; text-align: center;"></td>
                                <td style="width: 20px; text-align: center;"></td>';
                                $SUM = $SUM+$COUNT;

                                $sql3 ="SELECT *,COUNT(TRANSACTION_ID) FROM j3_rost_transaction
                                WHERE ROST_POSNAME_ACM = :ROST_POSNAME_ACM AND ACK_NUM_ID = '$ACK_NUM_ID'
                                GROUP BY ROST_RANK ORDER BY ROST_NCPOS12";
                                $stmt3=$db->prepare($sql3);
                                $stmt3->bindparam(':ROST_POSNAME_ACM',$ROST_POSNAME_ACM);
                                $stmt3->execute();
                                //$row3=$stmt3->fetch(PDO::FETCH_ASSOC);
                                $RANK = array();
                                $COUNT_AR = array();
                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){ 
                                    $COUNT_1 = $row3['COUNT(TRANSACTION_ID)'];
                                    $ROST_RANK1 = $row3['ROST_RANK'];
                                    //echo $ROST_RANK1;
                                    $COUNT_AR[] = $COUNT_1;
                                    $RANK[] = $ROST_RANK1;
                                }
                                    //print_r($RANK);
                                    $html .='<td style="width: 20px; text-align: center;">';
                                            if(in_array("01", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("01", $RANK)];
                                                    $SUM_12 = $SUM_12+$COUNT_AR[array_search("01", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("02", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("02", $RANK)];
                                                    $SUM_13 = $SUM_13+$COUNT_AR[array_search("02", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("03", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("03", $RANK)];
                                                    $SUM_1 = $SUM_1+$COUNT_AR[array_search("03", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("04", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("04", $RANK)];
                                                    $SUM_2 = $SUM_2+$COUNT_AR[array_search("04", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("05", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("05", $RANK)];
                                                    $SUM_3 = $SUM_3+$COUNT_AR[array_search("05", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("06", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("06", $RANK)];
                                                    $SUM_4 = $SUM_4+$COUNT_AR[array_search("06", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("07", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("07", $RANK)];
                                                    $SUM_5 = $SUM_5+$COUNT_AR[array_search("07", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("08", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("08", $RANK)];
                                                    $SUM_6 = $SUM_6+$COUNT_AR[array_search("08", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("09", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("09", $RANK)];
                                                    $SUM_7 = $SUM_7+$COUNT_AR[array_search("09", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("10", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("10", $RANK)];
                                                    $SUM_8 = $SUM_8+$COUNT_AR[array_search("10", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("21", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("21", $RANK)];
                                                    $SUM_9 = $SUM_9+$COUNT_AR[array_search("21", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("22", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("22", $RANK)];
                                                    $SUM_10 = $SUM_10+$COUNT_AR[array_search("22", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("25", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("25", $RANK)];
                                                    $SUM_11 = $SUM_11+$COUNT_AR[array_search("25", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                            
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("27", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("27", $RANK)];
                                                    $SUM_14 = $SUM_14+$COUNT_AR[array_search("27", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                            
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("31", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("31", $RANK)];
                                                    $SUM_15 = $SUM_15+$COUNT_AR[array_search("31", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                            
                                        $html.='</td>
                                        <td style="width: 20px; text-align: center;">';
                                            if(in_array("32", $RANK)){
                                                
                                                if($ROST_NCPOS12 != ""){
                                                    $html .=$COUNT_AR[array_search("32", $RANK)];
                                                    $SUM_16 = $SUM_16+$COUNT_AR[array_search("32", $RANK)];
                                                }else{
                                                    $html .= '-';
                                                }
                                            }else{
                                                $html .= '-';
                                            }
                                            
                                        $html.='</td>';
                                    $html.='<td style="width: 50px; text-align: center;"></td>
                                </tr>';
                            }
                        }
                    }   
                }
                $html.='<tr>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 300px; text-align: center;">รวมทั้งสิ้น</td>
                    <td style="width: 30px; text-align: center;">'.$SUM.'</td>
                    <td style="width: 20px; text-align: center;"></td>
                    <td style="width: 20px; text-align: center;"></td>';
                    $html .='<td style="width: 20px; text-align: center;">';
                        if($SUM_12 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_12;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_13 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_13;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_1 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_1;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_2 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_2;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_3 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_3;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_4 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_4;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_5 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_5;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_6 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_6;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_7 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_7;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_8 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_8;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_9 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_9;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_10 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_10;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_11 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_11;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_14 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_14;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_15 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_15;
                        }
                    $html.='</td>
                    <td style="width: 20px; text-align: center;">';
                        if($SUM_16 == "0"){
                            $html .= '-';
                        }else{
                            $html.=$SUM_16;
                        }
                    $html.='</td>';
                    $html.='<td style="width: 50px; text-align: center;"></td>
                </tr>';

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