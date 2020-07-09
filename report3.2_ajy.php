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

//$html .='<div style="text-align: left;">ตอนที่ 3 อัตรากำลังพล กองบัญชาการกองทัพไทย อจย.'.$ACK_ID.' () '.$NRPT_NAME.' '.$NRPT_NAME2.'</div><br>';

//$html .= '<div style="text-align: center"><u>'.$NRPT_NAME.'<br>'.$NRPT_NAME2.'<br>กองบัญชาการกองทัพไทย</u><br>ตอนที่ 3 อัตรากำลังพล</div><br>';

$html .= '<div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr> 
                        <th colspan="11" style="text-align: left;">ตอนที่ 3 อัตรากำลังพล กองบัญชาการกองทัพไทย อจย.'.$AJY_ID.' ('.$AJY_TIMESTAMP.')</th>                        
                        <tr>
                            <th rowspan="2" style="text-align: center;"><span class="textAlignVer">วรรค</span></th>
                            <th rowspan="2" style="text-align: center;">ลำดับ</th>
                            <th rowspan="2" style="text-align: center;">ตำแหน่ง</th>
                            <th rowspan="2" style="text-align: center;">จำนวน</th>
                            <th rowspan="2" style="text-align: center;">อัตรากำลังพล</th>
                            <th rowspan="2" style="text-align: center;">รหัสเลขที่ตำแหน่ง</th>
                            <th colspan="3" style="text-align: center;">อัตรา</th>
                            <th rowspan="2" style="text-align: center;">เหล่า</th>
                            <th rowspan="2" style="text-align: center;">หมายเหตุ</th>
                            <tr>
                                <th style="text-align: center;">เต็ม</th>
                                <th style="text-align: center;">ลด</th>
                                <th style="text-align: center;">โครง</th>
                            </tr>
                        </tr>
                    </tr>
                </thead>
                <tbody>';
                    $i = "00";
                    $j = "00";
                    if($UNIT_CODE2 == $UNIT_CODE1){
                        $j++;

                        if($j == "01"){

                            $sql = "SELECT * FROM j3_part" ;
                            $stmt=$db->prepare($sql);
                            $stmt->execute();

                            while($row1=$stmt->fetch(PDO::FETCH_ASSOC)){
                                $UNIT =$row1['PART_ID'];
                                if($UNIT ==  "1"){
                                    $stmt_unit->execute();
                                    $row_unit=$stmt_unit->fetch(PDO::FETCH_ASSOC);

                                    $NRPT_NAME = explode(' ', $row_unit['NRPT_NAME']);
                                    $NRPT_NAME = $NRPT_NAME[0];
                                    $html .= '<tr>
                                    <td style="width: 20px; text-align: center;">'.$j.'</td>
                                    <td style="width: 20px; text-align: center;"></td>
                                    <td style="width: 200px; text-align: left;"><b><u>'.$NRPT_NAME.'</u></b></td>
                                    <td style="width: 20px; text-align: center;"></td>
                                    <td style="width: 100px;"></td>
                                    <td style="width: 100px;"></td>
                                    <td style="width: 30px;"></td>
                                    <td style="width: 30px;"></td>
                                    <td style="width: 30px;"></td>
                                    <td style="width: 30px;"></td>
                                    <td style="width: 30px; text-align: center;"></td>
                                    </tr>';

                                }
                            }
                            $sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction 
                            WHERE ROST_UNIT = :UNIT_CODE2 AND AJY_NUM_ID = '$AJY_NUM_ID'
                            GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                            $stmt2=$db->prepare($sql2);
                            $stmt2->bindparam(':UNIT_CODE2',$UNIT_CODE2);
                            $stmt2->execute();

                            while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
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
                                $AJY_CUT = $row2['AJY_CUT'];
                                $AJY_KORG = $row2['AJY_KORG'];

                                $ROST_POSNAME = explode(' ', $row2['ROST_POSNAME']);
                                $ROST_POSNAME = $ROST_POSNAME[0];
                                //$i++;

                                $sql_rank = "SELECT ROST_RANKNAME FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
                                $stmt_rank=$db->prepare($sql_rank);
                                $stmt_rank->bindparam(':ROST_RANK',$ROST_RANK);
                                $stmt_rank->execute();
                                $row_rank=$stmt_rank->fetch(PDO::FETCH_ASSOC);
                                $RANK_NAME = $row_rank['ROST_RANKNAME'];                                               
                                $COUNTcccc = "1";
                                $SUM_i = "0";
                                $SUBCccccc = substr($ROST_CPOS,0,5);
                                if($SUBCccccc != 10910){
                                    $i++;
                                    $SUM_i = $SUM_i + $i;
                                    $html .= '<tr>
                                    <td style="width: 20px; text-align: center;"></td>
                                    <td style="width: 20px; vertical-align: top;">';
                                        if($COUNT > "1"){
                                            $i--;
                                            for($COUNTcccc == 1; $COUNTcccc <= $COUNT; $COUNTcccc++){
                                                $i++;
                                                $html .= ''.$i.'<br>';
                                                if($COUNTcccc == "20"){
                                                    break;
                                                }
                                                
                                            }
                                        }else{
                                                $html.=$i;
                                        }
                                    $html.='</td>
                                    <td style="width: 200px; text-align: left; vertical-align: top;">'.$ROST_POSNAME.'</td>
                                    <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                        if($ROST_RANK == "19" || $ROST_RANK == "29"){
                                            $html .=  '-';
                                        }else{
                                            $html .=  $COUNT;
                                        }
                                    $html .= '</td>';
                                        if($ROST_RANK == "02"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.อ./พล.ร.อ./พล.อ.อ.</td>';
                                        }elseif($ROST_RANK == "03"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ท./พล.ร.ท./พล.อ.ท.</td>';
                                        }elseif($ROST_RANK == "04"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ต./พล.ร.ต./พล.อ.ต.</td>';
                                        }elseif($ROST_RANK == "05"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ.(พ)/น.อ.(พ)</td>';
                                        }elseif($ROST_RANK == "06"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ./น.อ.</td>';
                                        }elseif($ROST_RANK == "07"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ท/น.ท.</td>';
                                        }elseif($ROST_RANK == "08"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ต./น.ต.</td>';
                                        }elseif($ROST_RANK == "09"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.อ.</td>';
                                        }elseif($ROST_RANK == "10"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.ท.</td>';
                                        }elseif($ROST_RANK == "21"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ.(พ)/พ.จ.อ.(พ)/พ.อ.อ.(พ)</td>';
                                        }elseif($ROST_RANK == "22"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ./พ.จ.อ./พ.อ.อ.</td>';
                                        }elseif($ROST_RANK == "25"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.อ./จ.อ.</td>';
                                        }elseif($ROST_RANK == "27"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.ต./จ.ต.</td>';
                                        }elseif($ROST_RANK == "32"){
                                            $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พลทหาร</td>';
                                        }
                                    $html .='<td style="width: 100px; vertical-align: top;">';
                                        if($COUNT > "1"){
                                            $SUBCc = substr($ROST_CPOS,0,5);
                                            $SUBAa = substr($ROST_NCPOS12,0,9);
                                            $sql6 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%$SUBCc%' AND ROST_UNIT = '$ROST_UNIT' AND ROST_RANK = '$ROST_RANK' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                            $stmt6=$db->prepare($sql6);
                                            $stmt6->execute();
                                            while($row6=$stmt6->fetch(PDO::FETCH_ASSOC)){
                                                //if($row6['ROST_RANK'] != "27" || $row6['ROST_RANK'] != "32"){
                                                    if($ROST_RANK == $row6['ROST_RANK']){
                                                        //if(substr($row6['ROST_NCPOS12'],0,9)==$SUBAa){
                                                            if($ROST_UNIT == $row6['ROST_UNIT']){
                                                                $html .= ''.$row6['ROST_NCPOS12'].'<br>';
                                                            }
                                                        //}
                                                    }
                                                //}
                                            }
                                        }else{
                                            $html.=$ROST_NCPOS12;
                                        }
                                    
                                        
                                    $html.='</td>
                                    <td style="width: 30px; vertical-align: top;">';
                                        if($ROST_RANK == "19" || $ROST_RANK == "29"){
                                            $html .=  '-';
                                        }else{
                                            $html .=  $COUNT;
                                        }
                                    $html .= '</td>
                                    <td style="width: 30px; vertical-align: top;">';
                                        if($ROST_RANK == "19" || $ROST_RANK == "29"){
                                            $html .=  '-';
                                        }else{
                                            if($AJY_CUT != ''){
                                                $html .=  $AJY_CUT;
                                            }else{
                                                $html .= '0';
                                            }
                                            
                                        }
                                    $html .= '</td>
                                    <td style="width: 30px; vertical-align: top;">';
                                        if($ROST_RANK == "19" || $ROST_RANK == "29"){
                                            $html .=  '-';
                                        }else{
                                            if($AJY_KORG != ''){
                                                $html .=  $AJY_KORG;
                                            }else{
                                                $html .= '0';
                                            }
                                        }
                                    $html .= '</td>
                                    <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ.'</td>
                                    <td style="width: 30px; text-align: center; vertical-align: top;">';
                                        if($ROST_RANK == "10"){
                                            $html .='(1)';
                                        }elseif($ROST_RANK == "21"){
                                            $html .='(2)';
                                        }
                                    $html .='</td>
                                    </tr>';
                                }else{
                                    $sql5 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                    WHERE ROST_UNIT = :UNIT_CODE2 AND ROST_CPOS LIKE '%10910%' AND AJY_NUM_ID = '$AJY_NUM_ID'
                                    GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                                    $stmt5=$db->prepare($sql5);
                                    $stmt5->bindparam(':UNIT_CODE2',$UNIT_CODE2);
                                    $stmt5->execute();
                                    $row5=$stmt5->fetch(PDO::FETCH_ASSOC);
                                    //while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                        $COUNT_5 = $row5['COUNT(ROST_ID)'];
                                        $ROST_UNIT_5 = $row5['ROST_UNIT'];
                                        $ROST_POSNAME_5 = $row5['ROST_POSNAME'];
                                        $ROST_RANK_5 = $row5['ROST_RANK'];
                                        $ROST_RANKNAME_5 = $row5['ROST_RANKNAME'];
                                        $ROST_NCPOS12_5 = $row5['ROST_NCPOS12'];
                                        $ROST_LAO_MAJ_5 = $row5['ROST_LAO_MAJ'];

                                        $ROST_POSNAME_5 = explode(' ', $row5['ROST_POSNAME']);
                                        $ROST_POSNAME_5 = $ROST_POSNAME_5[0];
                                        $html .= '<tr>
                                        <td style="width: 20px; text-align: center;"></td>
                                        <td style="width: 20px;">';
                                        $html.='</td>
                                        <td style="width: 200px; text-align: left;  vertical-align: top;">'.$ROST_POSNAME_5.'</td>
                                        <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                        $html .= '</td>
                                        <td style="width: 100px; text-align: left;  vertical-align: top;">'.$ROST_RANKNAME_5.'</td>
                                        <td style="width: 100px;">';
                                            if($COUNT_5 > "1"){
                                                //$SUBCccccc = substr($ROST_CPOS_4,0,5);
                                                //$SUBAaaaaa = substr($ROST_NCPOS12_4,0,9);
                                                $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%10910%' AND ROST_UNIT = '$ROST_UNIT_5' AND ROST_RANK = '$ROST_RANK_5' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                $stmt0=$db->prepare($sql0);
                                                $stmt0->execute();
                                                $NCPOS = "0";
                                                while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                    $NCPOS++;
                                                    if($NCPOS >= 20){
                                                        break;
                                                    }else{
                                                        if($ROST_RANK_5 == $row0['ROST_RANK']){
                                                                if($ROST_UNIT_5 == $row0['ROST_UNIT']){
                                                                    $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                }
                                                        }
                                                    }
                                                }
                                            }else{
                                                $html.=$ROST_NCPOS12_5;
                                            }
                                        
                                        $html.='</td>
                                        <td style="width: 30px;"></td>
                                        <td style="width: 30px;"></td>
                                        <td style="width: 30px;"></td>
                                        <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ_5.'</td>
                                        <td style="width: 30px; text-align: center; vertical-align: top;">';
                                            if($ROST_RANK_5 == "10"){
                                                $html .='(1)';
                                            }elseif($ROST_RANK_5 == "21"){
                                                $html .='(2)';
                                            }
                                        $html .='</td>
                                        </tr>';
                                    
                                }
                            }
                        }

                        $sql8 = "SELECT * FROM j3_nrpt_transaction WHERE NRPT_UNIT_PARENT = :UNIT_CODE2 AND AJY_NUM_ID = '$AJY_NUM_ID'" ;
                        $stmt8=$db->prepare($sql8);
                        $stmt8->bindparam(':UNIT_CODE2',$UNIT_CODE2);
                        $stmt8->execute();

                        while($row8=$stmt8->fetch(PDO::FETCH_ASSOC)){
                            $SUB = substr($row8['UNIT_CODE'],6);
                            $NRPT_NAME1 = explode(' ', $row8['NRPT_NAME']);
                            $NRPT_NAME1 = $NRPT_NAME1[0];

                            if($SUB != "0001" && $SUB != "0002" && $SUB != "0003" && $SUB != "9999" && $SUB != "9998"  && $SUB != "0900"){
                                if($row8['NRPT_UNIT_PARENT'] == $UNIT_CODE2){
                                    $SEND1 = $row8['UNIT_CODE'];
                                    $i = "00";
                                    $j++;
                                    if($j > "01"){
                                        $stmt->execute();
                                        while($row1=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $UNIT =$row1['PART_ID'];
                                            if($UNIT ==  "1"){
                                                $html .= '<tr>
                                                <td style="width: 20px; text-align: center;">'.$j.'</td>
                                                <td style="width: 20px; text-align: center;"></td>
                                                <td style="width: 200px; text-align: left"><b><u>'.$NRPT_NAME1.'</u></b></td>
                                                <td style="width: 20px; text-align: center;"></td>
                                                <td style="width: 100px;"></td>
                                                <td style="width: 100px;"></td>
                                                <td style="width: 30px;"></td>
                                                <td style="width: 30px;"></td>
                                                <td style="width: 30px;"></td>
                                                <td style="width: 30px;"></td>
                                                <td style="width: 30px; text-align: center;"></td>
                                                </tr>';

                                            }
                                        }
                                        $sql3 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                        WHERE ROST_UNIT = :SEND1 AND AJY_NUM_ID = '$AJY_NUM_ID'
                                        GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                                        $stmt3=$db->prepare($sql3);
                                        $stmt3->bindparam(':SEND1',$SEND1);
                                        $stmt3->execute();

                                        while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
                                            $COUNT_3 = $row3['COUNT(ROST_ID)'];
                                            $ROST_UNIT_3 = $row3['ROST_UNIT'];
                                            $ROST_CPOS_3 = $row3['ROST_CPOS'];
                                            $ROST_POSNAME_3 = $row3['ROST_POSNAME'];
                                            $ROST_POSNAME_ACM_3 = $row3['ROST_POSNAME_ACM'];
                                            $ROST_RANK_3 = $row3['ROST_RANK'];
                                            $ROST_RANKNAME_3 = $row3['ROST_RANKNAME'];
                                            $ROST_LAO_MAJ_3 = $row3['ROST_LAO_MAJ'];
                                            $ROST_NCPOS12_3 = $row3['ROST_NCPOS12'];
                                            $ROST_ID_3 = $row3['ROST_ID'];
                                            $ROST_PARENT_3 = $row3['ROST_PARENT'];
                                            $ROST_NUNIT_3 = $row3['ROST_NUNIT'];
                                            $ROST_NPARENT_3 = $row3['ROST_NPARENT'];
                                            $AJY_CUT_3 = $row3['AJY_CUT'];
                                            $AJY_KORG_3 = $row3['AJY_KORG'];

                                            $ROST_POSNAME_3 = explode(' ', $row3['ROST_POSNAME']);
                                            $ROST_POSNAME_3 = $ROST_POSNAME_3[0];
                                            //$i++;

                                            $sql_rank = "SELECT ROST_RANKNAME FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
                                            $stmt_rank=$db->prepare($sql_rank);
                                            $stmt_rank->bindparam(':ROST_RANK',$ROST_RANK);
                                            $stmt_rank->execute();
                                            $row_rank=$stmt_rank->fetch(PDO::FETCH_ASSOC);
                                            $RANK_NAME = $row_rank['ROST_RANKNAME'];           
                                            $COUNTcccc = "1";
                                            $SUM_i = "0";
                                            $SUBCccccc = substr($ROST_CPOS_3,0,5);
                                            if($SUBCccccc != 10910){
                                                $i++;
                                                $SUM_i = $SUM_i + $i;
                                                $html .= '<tr>
                                                <td style="width: 20px; text-align: center;"></td>
                                                <td style="width: 20px; vertical-align: top;">';
                                                    if($COUNT_3 > "1"){
                                                        $i--;
                                                        for($COUNTcccc == 1; $COUNTcccc <= $COUNT_3; $COUNTcccc++){
                                                            $i++;
                                                            $html .= ''.$i.'<br>';
                                                            if($COUNTcccc == "20"){
                                                                break;
                                                            }
                                                            
                                                        }
                                                    }else{
                                                            $html.=$i;
                                                    }
                                                $html.='</td>
                                                <td style="width: 200px; text-align: left;  vertical-align: top;">'.$ROST_POSNAME_3.'</td>
                                                <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                    if($ROST_RANK_3 == "19" || $ROST_RANK_3 == "29"){
                                                        $html .= '-';
                                                    }else{
                                                        $html .= $COUNT_3;
                                                    }
                                                $html .= '</td>';
                                                    if($ROST_RANK_3 == "02"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.อ./พล.ร.อ./พล.อ.อ.</td>';
                                                    }elseif($ROST_RANK_3 == "03"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ท./พล.ร.ท./พล.อ.ท.</td>';
                                                    }elseif($ROST_RANK_3 == "04"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ต./พล.ร.ต./พล.อ.ต.</td>';
                                                    }elseif($ROST_RANK_3 == "05"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ.(พ)/น.อ.(พ)</td>';
                                                    }elseif($ROST_RANK_3 == "06"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ./น.อ.</td>';
                                                    }elseif($ROST_RANK_3 == "07"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ท/น.ท.</td>';
                                                    }elseif($ROST_RANK_3 == "08"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ต./น.ต.</td>';
                                                    }elseif($ROST_RANK_3 == "09"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.อ.</td>';
                                                    }elseif($ROST_RANK_3 == "10"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.ท.</td>';
                                                    }elseif($ROST_RANK_3 == "21"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ.(พ)/พ.จ.อ.(พ)/พ.อ.อ.(พ)</td>';
                                                    }elseif($ROST_RANK_3 == "22"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ./พ.จ.อ./พ.อ.อ.</td>';
                                                    }elseif($ROST_RANK_3 == "25"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.อ./จ.อ.</td>';
                                                    }elseif($ROST_RANK_3 == "27"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.ต./จ.ต.</td>';
                                                    }elseif($ROST_RANK_3 == "32"){
                                                        $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พลทหาร</td>';
                                                    }
                                                $html .='<td style="width: 100px; vertical-align: top;">';
                                                        if($COUNT_3 > "1"){
                                                            //if($ROST_RANK_3 != 27 || $ROST_RANK_3 != 32){
                                                                $SUBCccc = substr($ROST_CPOS_3,0,5);
                                                                $SUBAaaa = substr($ROST_NCPOS12_3,0,9);
                                                                $sqlccc = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%$SUBCccc%' AND ROST_UNIT = '$ROST_UNIT_3' AND ROST_RANK = '$ROST_RANK_3' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                                $stmtccc=$db->prepare($sqlccc);
                                                                $stmtccc->execute();
                                                                while($rowccc=$stmtccc->fetch(PDO::FETCH_ASSOC)){
                                                                    //if($ROST_RANK_3 != 27 || $ROST_RANK_3 != 32){
                                                                        if($ROST_RANK_3 == $rowccc['ROST_RANK']){
                                                                            //if(substr($rowccc['ROST_NCPOS12'],0,9)==$SUBAaaa){
                                                                                if($ROST_UNIT_3 == $rowccc['ROST_UNIT']){
                                                                                    $html .= ''.$rowccc['ROST_NCPOS12'].'<br>';
                                                                                }
                                                                            //}
                                                                        }
                                                                    //}
                                                                }
                                                            //}
                                                        }else{
                                                            //if($ROST_RANK_3 != 27 || $ROST_RANK_3 != 32){
                                                                $html.=$ROST_NCPOS12_3;
                                                            //}
                                                            
                                                        }
                                                    
                                                $html.='</td>
                                                <td style="width: 30px; vertical-align: top;">';
                                                    if($ROST_RANK_3 == "19" || $ROST_RANK_3 == "29"){
                                                        $html .=  '-';
                                                    }else{
                                                        $html .=  $COUNT_3;
                                                    }
                                                $html .= '</td>
                                                <td style="width: 30px; vertical-align: top;">';
                                                    if($ROST_RANK_3 == "19" || $ROST_RANK_3 == "29"){
                                                        $html .=  '-';
                                                    }else{
                                                        if($AJY_CUT_3 != ''){
                                                            $html .=  $AJY_CUT_3;
                                                        }else{
                                                            $html .= '0';
                                                        }
                                                    }
                                                $html .= '</td>
                                                <td style="width: 30px; vertical-align: top;">';
                                                    if($ROST_RANK_3 == "19" || $ROST_RANK_3 == "29"){
                                                        $html .=  '-';
                                                    }else{
                                                        if($AJY_KORG_3 != ''){
                                                            $html .=  $AJY_KORG_3;
                                                        }else{
                                                            $html .= '0';
                                                        }
                                                    }
                                                $html .= '</td>
                                                <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ_3.'</td>
                                                <td style="width: 30px; text-align: center; vertical-align: top;">';
                                                    if($ROST_RANK_3 == "10"){
                                                        $html .='(1)';
                                                    }elseif($ROST_RANK_3 == "21"){
                                                        $html .='(2)';
                                                    }
                                                $html .='</td>
                                                </tr>';
                                                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                if($COUNT_3 > 1){
                                                    $NCOUNT = $COUNTcccc;
                                                    for($COUNTcccc == $NCOUNT; $COUNTcccc <= $COUNT_3; $COUNTcccc++){
                                                        $SUM = 0;
                                                        $SUMCOUNT = $COUNTcccc;
                                                        $html .= '<tr>
                                                            <td style="width: 20px; text-align: center;"></td>
                                                            <td style="width: 20px;">';
                                                                if($COUNT_3 > "1"){
                                                                    
                                                                    for($COUNTcccc == $SUM; $COUNTcccc <= $COUNT_3-1; $COUNTcccc++){
                                                                        $i++;
                                                                        $html .= ''.$i.'<br>';
                                                                        $SUM++;
                                                                        if($SUM == "20"){
                                                                            break;
                                                                        }
                                                                    }
                                                                    $SUM = $SUMCOUNT + $SUM;
                                                                }
                                                            $html.='</td>
                                                            <td style="width: 200px; text-align: left;  vertical-align: top;"></td>
                                                            <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                            $html .= '</td>
                                                            <td style="width: 100px; text-align: left;  vertical-align: top;"></td>
                                                            <td style="width: 100px;">';
                                                                if($COUNT_3 > "1"){
                                                                    $SUBAaaaaa = substr($ROST_NCPOS12_3,0,9);
                                                                    $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%$SUBCccccc%' AND ROST_UNIT = '$ROST_UNIT_3' AND ROST_RANK = '$ROST_RANK_3' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                                    $stmt0=$db->prepare($sql0);
                                                                    $stmt0->execute();
                                                                    $NCPOS = "0";
                                                                    while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                                        $NCPOS++;
                                                                        //if($ROST_RANK_3 != "27" || $ROST_RANK_3 != "32"){
                                                                            if($NCPOS <= $SUM && $NCPOS > $SUMCOUNT){
                                                                                if($ROST_RANK_3 == $row0['ROST_RANK']){
                                                                                    if($ROST_UNIT_3 == $row0['ROST_UNIT']){
                                                                                            $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        //}
                                                                    }
                                                                }
                                                            $html.='</td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px; text-align: center;"></td>
                                                            </tr>';
                                                    }
                                                }
                                            }else{
                                                $sql5 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE ROST_UNIT = :SEND1 AND ROST_CPOS LIKE '%10910%' AND AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                                                $stmt5=$db->prepare($sql5);
                                                $stmt5->bindparam(':SEND1',$SEND1);
                                                $stmt5->execute();
                                                $row5=$stmt5->fetch(PDO::FETCH_ASSOC);
                                                //while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                    $COUNT_5 = $row5['COUNT(ROST_ID)'];
                                                    $ROST_UNIT_5 = $row5['ROST_UNIT'];
                                                    $ROST_POSNAME_5 = $row5['ROST_POSNAME'];
                                                    $ROST_RANK_5 = $row5['ROST_RANK'];
                                                    $ROST_RANKNAME_5 = $row5['ROST_RANKNAME'];
                                                    $ROST_NCPOS12_5 = $row5['ROST_NCPOS12'];
                                                    $ROST_LAO_MAJ_5 = $row5['ROST_LAO_MAJ'];

                                                    $ROST_POSNAME_5 = explode(' ', $row5['ROST_POSNAME']);
                                                    $ROST_POSNAME_5 = $ROST_POSNAME_5[0];
                                                    $html .= '<tr>
                                                    <td style="width: 20px; text-align: center;"></td>
                                                    <td style="width: 20px;">';
                                                    $html.='</td>
                                                    <td style="width: 200px; text-align: left;  vertical-align: top;">'.$ROST_POSNAME_5.'</td>
                                                    <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                    $html .= '</td>
                                                    <td style="width: 100px; text-align: left;  vertical-align: top;">'.$ROST_RANKNAME_5.'</td>
                                                    <td style="width: 100px;">';
                                                        if($COUNT_5 > "1"){
                                                            //$SUBCccccc = substr($ROST_CPOS_4,0,5);
                                                            //$SUBAaaaaa = substr($ROST_NCPOS12_4,0,9);
                                                            $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%10910%' AND ROST_UNIT = '$ROST_UNIT_5' AND ROST_RANK = '$ROST_RANK_5' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                            $stmt0=$db->prepare($sql0);
                                                            $stmt0->execute();
                                                            $NCPOS = "0";
                                                            while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                                $NCPOS++;
                                                                if($NCPOS >= 20){
                                                                    break;
                                                                }else{
                                                                    if($ROST_RANK_5 == $row0['ROST_RANK']){
                                                                            if($ROST_UNIT_5 == $row0['ROST_UNIT']){
                                                                                $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                            }
                                                                    }
                                                                }
                                                            }
                                                        }else{
                                                            $html.=$ROST_NCPOS12_5;
                                                        }
                                                    
                                                    $html.='</td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ_5.'</td>
                                                    <td style="width: 30px; text-align: center; vertical-align: top;">';
                                                        if($ROST_RANK_5 == "10"){
                                                            $html .='(1)';
                                                        }elseif($ROST_RANK_5 == "21"){
                                                            $html .='(2)';
                                                        }
                                                    $html .='</td>
                                                    </tr>';
                                                
                                            }
                                        }

                                        $sql9 = "SELECT * FROM j3_nrpt_transaction WHERE NRPT_UNIT_PARENT = :SEND1 AND AJY_NUM_ID = '$AJY_NUM_ID'" ;
                                        $stmt9=$db->prepare($sql9);
                                        $stmt9->bindparam(':SEND1',$SEND1);
                                        $stmt9->execute();
                                        while($row9=$stmt9->fetch(PDO::FETCH_ASSOC)){
                                            $NRPT_NAME2 = explode(' ', $row9['NRPT_NAME']);
                                            $NRPT_NAME2 = $NRPT_NAME2[0];
                                            $SUB1 = substr($row9['UNIT_CODE'],6);
                                            
                                            if($SUB1 != "0001" && $SUB1 != "0002" && $SUB1 != "0003" && $SUB1 != "9999" && $SUB1 != "9998"  && $SUB1 != "0900"){
                                                if($row9['NRPT_UNIT_PARENT'] == $SEND1){
                                                    $SEND2 = $row9['UNIT_CODE'];
                                                    $html .= '<tr>
                                                    <td style="width: 20px; text-align: center;"></td>
                                                    <td style="width: 20px; text-align: center;"></td>
                                                    <td style="width: 200px; text-align: left"><b><u>'.$NRPT_NAME2.'</b></u></td>
                                                    <td style="width: 20px; text-align: center;"></td>
                                                    <td style="width: 100px;"></td>
                                                    <td style="width: 100px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px;"></td>
                                                    <td style="width: 30px; text-align: center;"></td>
                                                    </tr>';
                                                }
                                                $sql4 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                WHERE ROST_UNIT = :SEND2 AND AJY_NUM_ID = '$AJY_NUM_ID'
                                                GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                                                $stmt4=$db->prepare($sql4);
                                                $stmt4->bindparam(':SEND2',$SEND2);
                                                $stmt4->execute();
                                                while($row4=$stmt4->fetch(PDO::FETCH_ASSOC)){
                                                    $COUNT_4 = $row4['COUNT(ROST_ID)'];
                                                    $ROST_UNIT_4 = $row4['ROST_UNIT'];
                                                    $ROST_CPOS_4 = $row4['ROST_CPOS'];
                                                    $ROST_POSNAME_4 = $row4['ROST_POSNAME'];
                                                    $ROST_POSNAME_ACM_4 = $row4['ROST_POSNAME_ACM'];
                                                    $ROST_RANK_4 = $row4['ROST_RANK'];
                                                    $ROST_RANKNAME_4 = $row4['ROST_RANKNAME'];
                                                    $ROST_LAO_MAJ_4 = $row4['ROST_LAO_MAJ'];
                                                    $ROST_NCPOS12_4 = $row4['ROST_NCPOS12'];
                                                    $ROST_ID_4 = $row4['ROST_ID'];
                                                    $ROST_PARENT_4 = $row4['ROST_PARENT'];
                                                    $ROST_NUNIT_4 = $row4['ROST_NUNIT'];
                                                    $ROST_NPARENT_4 = $row4['ROST_NPARENT'];
                                                    $AJY_CUT_4 = $row4['AJY_CUT'];
                                                    $AJY_KORG_4 = $row4['AJY_KORG'];

                                                    $ROST_POSNAME_4 = explode(' ', $row4['ROST_POSNAME']);
                                                    $ROST_POSNAME_4 = $ROST_POSNAME_4[0];
                                                    //$i++;

                                                    $sql_rank = "SELECT ROST_RANKNAME FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
                                                    $stmt_rank=$db->prepare($sql_rank);
                                                    $stmt_rank->bindparam(':ROST_RANK',$ROST_RANK);
                                                    $stmt_rank->execute();
                                                    $row_rank=$stmt_rank->fetch(PDO::FETCH_ASSOC);
                                                    $RANK_NAME = $row_rank['ROST_RANKNAME'];     
                                                    $COUNTcccc = "1";
                                                    $SUM_i = "0";
                                                    $SUBCccccc = substr($ROST_CPOS_4,0,5);
                                                    if($SUBCccccc != 10910){
                                                        $i++;
                                                        $SUM_i = $SUM_i + $i;
                                                        $html .= '<tr>
                                                            <td style="width: 20px; text-align: center;"></td>
                                                            <td style="width: 20px; vertical-align: top;">';
                                                                if($COUNT_4 > "1"){
                                                                    $i--;
                                                                    for($COUNTcccc == 1; $COUNTcccc <= $COUNT_4; $COUNTcccc++){
                                                                        $i++;
                                                                        $html .= ''.$i.'<br>';
                                                                        if($COUNTcccc == "20"){
                                                                            break;
                                                                        }
                                                                    }
                                                                }else{
                                                                        $html.=$i;
                                                                }
                                                            $html.='</td>
                                                            <td style="width: 200px; text-align: left;  vertical-align: top;">'.$ROST_POSNAME_4.'</td>
                                                            <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                                if($ROST_RANK_4 == "19" || $ROST_RANK_4 == "29"){
                                                                    $html .=  '-';
                                                                }else{
                                                                    $html .=  $COUNT_4;
                                                                }
                                                            $html .= '</td>';
                                                                if($ROST_RANK_4 == "02"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.อ./พล.ร.อ./พล.อ.อ.</td>';
                                                                }elseif($ROST_RANK_4 == "03"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ท./พล.ร.ท./พล.อ.ท.</td>';
                                                                }elseif($ROST_RANK_4 == "04"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พล.ต./พล.ร.ต./พล.อ.ต.</td>';
                                                                }elseif($ROST_RANK_4 == "05"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ.(พ)/น.อ.(พ)</td>';
                                                                }elseif($ROST_RANK_4 == "06"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.อ./น.อ.</td>';
                                                                }elseif($ROST_RANK_4 == "07"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ท/น.ท.</td>';
                                                                }elseif($ROST_RANK_4 == "08"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พ.ต./น.ต.</td>';
                                                                }elseif($ROST_RANK_4 == "09"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.อ.</td>';
                                                                }elseif($ROST_RANK_4 == "10"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ร.ท.</td>';
                                                                }elseif($ROST_RANK_4 == "21"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ.(พ)/พ.จ.อ.(พ)/พ.อ.อ.(พ)</td>';
                                                                }elseif($ROST_RANK_4 == "22"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">จ.ส.อ./พ.จ.อ./พ.อ.อ.</td>';
                                                                }elseif($ROST_RANK_4 == "25"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.อ./จ.อ.</td>';
                                                                }elseif($ROST_RANK_4 == "27"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">ส.ต./จ.ต.</td>';
                                                                }elseif($ROST_RANK_4 == "32"){
                                                                    $html.='<td style="width: 100px; text-align: left; vertical-align: top;">พลทหาร</td>';
                                                                }
                                                            $html .='<td style="width: 100px; vertical-align: top;">';
                                                                if($COUNT_4 > "1"){
                                                                    //$SUBCccccc = substr($ROST_CPOS_4,0,5);
                                                                    $SUBAaaaaa = substr($ROST_NCPOS12_4,0,9);
                                                                    $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%$SUBCccccc%' AND ROST_UNIT = '$ROST_UNIT_4' AND ROST_RANK = '$ROST_RANK_4' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                                    $stmt0=$db->prepare($sql0);
                                                                    $stmt0->execute();
                                                                    $NCPOS = "0";
                                                                    while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                                        $NCPOS++;
                                                                        if($NCPOS >= 21){
                                                                            break;
                                                                        }else{
                                                                            //if($ROST_RANK_4 != "27" || $ROST_RANK_4 != "32"){
                                                                                if($ROST_RANK_4 == $row0['ROST_RANK']){
                                                                                    if($ROST_UNIT_4 == $row0['ROST_UNIT']){
                                                                                        $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                                    }
                                                                                }
                                                                            //}
                                                                        }
                                                                    }
                                                                }else{
                                                                    $html.=$ROST_NCPOS12_4;
                                                                }
                                                            
                                                            $html.='</td>
                                                            <td style="width: 30px; vertical-align: top;">';
                                                                if($ROST_RANK_4 == "19" || $ROST_RANK_4 == "29"){
                                                                    $html .=  '-';
                                                                }else{
                                                                    $html .=  $COUNT_4;
                                                                }
                                                            $html .= '</td>
                                                            <td style="width: 30px; vertical-align: top;">';
                                                                if($ROST_RANK_4 == "19" || $ROST_RANK_4 == "29"){
                                                                    $html .=  '-';
                                                                }else{
                                                                    if($AJY_CUT_4 != ''){
                                                                        $html .=  $AJY_CUT_4;
                                                                    }else{
                                                                        $html .= '0';
                                                                    }
                                                                }
                                                            $html .= '</td>
                                                            <td style="width: 30px; vertical-align: top;">';
                                                                if($ROST_RANK_4 == "19" || $ROST_RANK_4 == "29"){
                                                                    $html .=  '-';
                                                                }else{
                                                                    if($AJY_KORG_4 != ''){
                                                                        $html .=  $AJY_KORG_4;
                                                                    }else{
                                                                        $html .= '0';
                                                                    }
                                                                }
                                                            $html .= '</td>
                                                            <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ_4.'</td>
                                                            <td style="width: 30px; text-align: center; vertical-align: top;">';
                                                                if($ROST_RANK_4 == "10"){
                                                                    $html .='(1)';
                                                                }elseif($ROST_RANK_4 == "21"){
                                                                    $html .='(2)';
                                                                }
                                                            $html .='</td>
                                                        </tr>';
                                                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        if($COUNT_4 > 1){
                                                            $NCOUNT = $COUNTcccc;
                                                            for($COUNTcccc == $NCOUNT; $COUNTcccc <= $COUNT_4; $COUNTcccc++){
                                                                $SUM = 0;
                                                                $SUMCOUNT = $COUNTcccc;
                                                                $html .= '<tr>
                                                                    <td style="width: 20px; text-align: center;"></td>
                                                                    <td style="width: 20px;">';
                                                                        if($COUNT_4 > "1"){
                                                                            
                                                                            for($COUNTcccc == $SUM; $COUNTcccc <= $COUNT_4-1; $COUNTcccc++){
                                                                                $i++;
                                                                                $html .= ''.$i.'<br>';
                                                                                $SUM++;
                                                                                if($SUM == "20"){
                                                                                    break;
                                                                                }
                                                                            }
                                                                            $SUM = $SUMCOUNT + $SUM;
                                                                        }
                                                                    $html.='</td>
                                                                    <td style="width: 200px; text-align: left;  vertical-align: top;"></td>
                                                                    <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                                    $html .= '</td>
                                                                    <td style="width: 100px; text-align: left;  vertical-align: top;"></td>
                                                                    <td style="width: 100px;">';
                                                                        if($COUNT_4 > "1"){
                                                                            $SUBAaaaaa = substr($ROST_NCPOS12_4,0,9);
                                                                            $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%$SUBCccccc%' AND ROST_UNIT = '$ROST_UNIT_4' AND ROST_RANK = '$ROST_RANK_4' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                                            $stmt0=$db->prepare($sql0);
                                                                            $stmt0->execute();
                                                                            $NCPOS = "0";
                                                                            while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                                                $NCPOS++;
                                                                                //if($ROST_RANK_4 != "27" || $ROST_RANK_4 != "32"){
                                                                                    if($NCPOS <= $SUM && $NCPOS > $SUMCOUNT){
                                                                                        if($ROST_RANK_4 == $row0['ROST_RANK']){
                                                                                            if($ROST_UNIT_4 == $row0['ROST_UNIT']){
                                                                                                    $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                //}
                                                                            }
                                                                        }
                                                                    
                                                                    $html.='</td>
                                                                    <td style="width: 30px;"></td>
                                                                    <td style="width: 30px;"></td>
                                                                    <td style="width: 30px;"></td>
                                                                    <td style="width: 30px;"></td>
                                                                    <td style="width: 30px; text-align: center;"></td>
                                                                    </tr>';
                                                            }
                                                        }
                                                    }else{
                                                        $sql5 = "SELECT *,COUNT(ROST_ID) FROM j3_rost_transaction
                                                        WHERE ROST_UNIT = :SEND2 AND ROST_CPOS LIKE '%10910%' AND AJY_NUM_ID = '$AJY_NUM_ID'
                                                        GROUP BY ROST_POSNAME_ACM,ROST_RANKNAME ORDER BY ROST_NCPOS12";
                                                        $stmt5=$db->prepare($sql5);
                                                        $stmt5->bindparam(':SEND2',$SEND2);
                                                        $stmt5->execute();
                                                        $row5=$stmt5->fetch(PDO::FETCH_ASSOC);
                                                        //while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                            $COUNT_5 = $row5['COUNT(ROST_ID)'];
                                                            $ROST_UNIT_5 = $row5['ROST_UNIT'];
                                                            $ROST_POSNAME_5 = $row5['ROST_POSNAME'];
                                                            $ROST_RANK_5 = $row5['ROST_RANK'];
                                                            $ROST_RANKNAME_5 = $row5['ROST_RANKNAME'];
                                                            $ROST_NCPOS12_5 = $row5['ROST_NCPOS12'];
                                                            $ROST_LAO_MAJ_5 = $row5['ROST_LAO_MAJ'];

                                                            $ROST_POSNAME_5 = explode(' ', $row5['ROST_POSNAME']);
                                                            $ROST_POSNAME_5 = $ROST_POSNAME_5[0];
                                                            $html .= '<tr>
                                                            <td style="width: 20px; text-align: center;"></td>
                                                            <td style="width: 20px;">';
                                                            $html.='</td>
                                                            <td style="width: 200px; text-align: left;  vertical-align: top;">'.$ROST_POSNAME_5.'</td>
                                                            <td style="width: 20px; text-align: center;  vertical-align: top;">';
                                                            $html .= '</td>
                                                            <td style="width: 100px; text-align: left;  vertical-align: top;">'.$ROST_RANKNAME_5.'</td>
                                                            <td style="width: 100px;">';
                                                                if($COUNT_5 > "1"){
                                                                    //$SUBCccccc = substr($ROST_CPOS_4,0,5);
                                                                    //$SUBAaaaaa = substr($ROST_NCPOS12_4,0,9);
                                                                    $sql0 = "SELECT * FROM j3_rost_transaction WHERE ROST_CPOS LIKE '%10910%' AND ROST_UNIT = '$ROST_UNIT_5' AND ROST_RANK = '$ROST_RANK_5' AND AJY_NUM_ID = '$AJY_NUM_ID' ORDER BY ROST_NCPOS12";
                                                                    $stmt0=$db->prepare($sql0);
                                                                    $stmt0->execute();
                                                                    $NCPOS = "0";
                                                                    while($row0=$stmt0->fetch(PDO::FETCH_ASSOC)){
                                                                        $NCPOS++;
                                                                        if($NCPOS >= 20){
                                                                            break;
                                                                        }else{
                                                                            if($ROST_RANK_5 == $row0['ROST_RANK']){
                                                                                    if($ROST_UNIT_5 == $row0['ROST_UNIT']){
                                                                                        $html .= ''.$row0['ROST_NCPOS12'].'<br>';
                                                                                    }
                                                                            }
                                                                        }
                                                                    }
                                                                }else{
                                                                    $html.=$ROST_NCPOS12_5;
                                                                }
                                                            
                                                            $html.='</td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px;"></td>
                                                            <td style="width: 30px; vertical-align: top;">'.$ROST_LAO_MAJ_5.'</td>
                                                            <td style="width: 30px; text-align: center; vertical-align: top;">';
                                                                if($ROST_RANK_5 == "10"){
                                                                    $html .='(1)';
                                                                }elseif($ROST_RANK_5 == "21"){
                                                                    $html .='(2)';
                                                                }
                                                            $html .='</td>
                                                            </tr>';
                                                        
                                                    }
                                                }
                                            }  
                                        }
                                    }
                                }
                            }
                        }
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