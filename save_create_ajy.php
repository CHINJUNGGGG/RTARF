<?php

date_default_timezone_set("Asia/Bangkok");

include ('db/connect.php');

$AJY_ID = $_POST['AJY_ID'];
$AJY_NAME = $_POST['AJY_NAME'];
$UNIT_CODE = $_POST['UNIT_CODE'];
if ($UNIT_CODE == ''){
    $UNIT_CODE = $_POST['UNIT_CODE2'];
}
$UNIT_NAME = $_POST['UNIT_NAME'];
if ($UNIT_NAME == ''){
    $UNIT_NAME = $_POST['UNIT_NAME2'];
}
$UNIT_NAME2 = $_POST['UNIT_NAME2'];
$UNIT_NAME_AJY = $_POST['UNIT_NAME_AJY'];
$UNIT_CODE_PARENT = $_POST['UNIT_CODE_PARENT'];
$AJY_TIMESTAMP = $_POST['AJY_TIMESTAMP'];
$AJY_ESSENCE = $_POST['AJY_ESSENCE'];
$AJY_USER = $_POST['AJY_USER'];
$AJY_MISSION = $_POST['AJY_MISSION'];
$AJY_DISTRIBUTION = $_POST['AJY_DISTRIBUTION'];
$AJY_SCOPE = $_POST['AJY_SCOPE'];
$AJY_DIVISION = $_POST['AJY_DIVISION'];
$AJY_EXPLANATION = $_POST['AJY_EXPLANATION'];
$AJY_SUMMARY = $_POST['AJY_SUMMARY'];
$AJY_VERSION = $_POST['AJY_VERSION'];
$UNIT_ACM_ID = $_POST['UNIT_ACM_ID'];
$UNIT_ACM_CREATE = $_POST['UNIT_ACM_CREATE'];
$UNIT_ACM = $_POST['UNIT_ACM'];

$check = "SELECT UNIT_CODE FROM j3_nrpt WHERE UNIT_CODE = '".$UNIT_NAME2."'";
$result = mysqli_query($conn, $check) or die(mysqli_error());
$num=mysqli_num_rows($result);

if($num > 0){
    echo "<script>";
    echo "alert(' ข้อมูลซ้ำ กรุณาเพิ่มใหม่อีกครั้ง !');";
    echo "window.location = 'create_ajy.php?id=$UNIT_CODE_PARENT&name=$UNIT_CODE_PARENT&nickname=$UNIT_CODE_PARENT&lastname=$UNIT_CODE_PARENT';";
    echo "</script>";
}else{

    $sql1 = "INSERT INTO  j3_ajy(AJY_NUM_ID,AJY_ID,AJY_NAME,UNIT_CODE,UNIT_NAME,UNIT_NAME_AJY,UNIT_CODE_PARENT,AJY_TIMESTAMP,AJY_ESSENCE,AJY_USER,AJY_MISSION,AJY_DISTRIBUTION,AJY_SCOPE,AJY_DIVISION,AJY_EXPLANATION,AJY_SUMMARY,AJY_VERSION,UNIT_ACM_CREATE,UNIT_ACM_ID) 
    VALUES (NULL,'$AJY_ID','$AJY_NAME','$UNIT_NAME2','$UNIT_NAME','$UNIT_NAME_AJY','$UNIT_CODE_PARENT',
    current_timestamp(),'$AJY_ESSENCE','$AJY_USER','$AJY_MISSION','$AJY_DISTRIBUTION','$AJY_SCOPE',
    '$AJY_DIVISION','$AJY_EXPLANATION','$AJY_SUMMARY','$AJY_VERSION', '$UNIT_ACM_CREATE' , ".$_POST["UNIT_ACM"].")";
    $result2 = mysqli_query($conn, $sql1) or die ("Error in query: $sql1 " . mysqli_error()); 

    $AJY_NUM_ID = mysqli_insert_id($conn);
    
    $result = mysqli_query($conn, "TRUNCATE j3_nrpt_approve") or die(mysqli_error());
    $result = mysqli_query($conn, "TRUNCATE j3_rost_approve") or die(mysqli_error());

    $sql_select_max = "SELECT MAX(SUBSTRING(ROST_NCPOS12 , 1, 5)) as MAX FROM `j3_rost` WHERE SUBSTRING(ROST_UNIT , 1, 4) LIKE '".substr($UNIT_ACM , 0, 4)."' AND SUBSTRING(ROST_UNIT, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900)";
    $result_select_max = mysqli_query($conn, $sql_select_max) or die(mysqli_error($conn));
    $result_max = mysqli_fetch_assoc($result_select_max);

    $MAX_ROST_NCPOS12 = $result_max['MAX'];

    $MAX_ROST_NCPOS12 +=1;


    switch ($_POST["UNIT_ACM_CREATE"]) {

        case 'กรม':
        
        $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
        SELECT * FROM `j3_nrpt` WHERE UNIT_ACM_ID LIKE '".$_POST["UNIT_ACM"]."'  ";
        $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());

            $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE ROST_PARENT LIKE '".$_POST["UNIT_ACM"]."' ";
            $res = mysqli_query($conn , $sql_select_j3_rost);
            $c = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $ROST_UNIT =  substr( $_POST["UNIT_NAME2"] , 0 , 5). substr($row["ROST_UNIT"], 5 , 9);
                $ROST_CPOS = $row["ROST_CPOS"];
                $ROST_POSNAME = $row["ROST_POSNAME"];
                $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                $ROST_RANK = $row["ROST_RANK"];
                $ROST_RANKNAME = $row["ROST_RANKNAME"];
                $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                $ROST_ID = $row["ROST_ID"];
                $ROST_PARENT = $row["ROST_PARENT"];
                $ROST_NUNIT = $row["ROST_NUNIT"];
                $ROST_NPARENT = $row["ROST_NPARENT"];
                $STATUS = $row["STATUS"];
                $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS` , `VERSION` , `AJY_NUM_ID`) 
                VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."' , '$AJY_VERSION' , '$AJY_NUM_ID')";
                $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
            }


            $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  UNIT_ACM_ID LIKE '".$_POST["UNIT_ACM"]."' AND UNIT_CODE != '".$_POST["UNIT_ACM"]."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());

        $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)."  ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE   UNIT_CODE LIKE '".$_POST["UNIT_ACM"]."'
            ";
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());


        $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
            ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." ) ,
            ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." )  
            WHERE ROST_PARENT LIKE '".$_POST["UNIT_ACM"]."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());
        echo 'กรม';
        break;

        case 'สำนัก':

        $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
        SELECT * FROM `j3_nrpt` WHERE UNIT_ACM_ID LIKE '".$_POST["UNIT_CODE_PARENT"]."'  ";
        $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());


            $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE ROST_PARENT LIKE '".$_POST["UNIT_CODE_PARENT"]."' ";
            $res = mysqli_query($conn , $sql_select_j3_rost);
            $c = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $ROST_UNIT =  substr( $_POST["UNIT_NAME2"] , 0 , 5). substr($row["ROST_UNIT"], 5 , 9);
                $ROST_CPOS = $row["ROST_CPOS"];
                $ROST_POSNAME = $row["ROST_POSNAME"];
                $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                $ROST_RANK = $row["ROST_RANK"];
                $ROST_RANKNAME = $row["ROST_RANKNAME"];
                $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                $ROST_ID = $row["ROST_ID"];
                $ROST_PARENT = $row["ROST_PARENT"];
                $ROST_NUNIT = $row["ROST_NUNIT"];
                $ROST_NPARENT = $row["ROST_NPARENT"];
                $STATUS = $row["STATUS"];
                $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`, `VERSION`, `AJY_NUM_ID`) 
                VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."' , '$AJY_VERSION', '$AJY_NUM_ID')";
                $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
            }


            $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  UNIT_ACM_ID LIKE '".$_POST["UNIT_CODE_PARENT"]."' AND UNIT_CODE != '".$_POST["UNIT_CODE_PARENT"]."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());

        $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)."  ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE   UNIT_CODE LIKE '".$_POST["UNIT_CODE_PARENT"]."'
            ";
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());


        $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
            ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." ) ,
            ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." )  
            WHERE ROST_PARENT LIKE '".$_POST["UNIT_CODE_PARENT"]."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());
        echo 'สำนัก';
        break;

        case 'ศูนย์':

        $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
        SELECT * FROM `j3_nrpt` WHERE  SUBSTRING(UNIT_CODE, 1, 5) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."'  ";
        $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error($conn));

            $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE SUBSTRING(ROST_NUNIT, 1, 5) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."' ";
            $res = mysqli_query($conn , $sql_select_j3_rost);
            $c = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $ROST_UNIT =  $row["ROST_UNIT"];
                $ROST_CPOS = $row["ROST_CPOS"];
                $ROST_POSNAME = $row["ROST_POSNAME"];
                $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                $ROST_RANK = $row["ROST_RANK"];
                $ROST_RANKNAME = $row["ROST_RANKNAME"];
                $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                $ROST_ID = $row["ROST_ID"];
                $ROST_PARENT = $row["ROST_PARENT"];
                $ROST_NUNIT = $row["ROST_NUNIT"];
                $ROST_NPARENT = $row["ROST_NPARENT"];
                $STATUS = $row["STATUS"];
                $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS` , `VERSION`, `AJY_NUM_ID`) 
                VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."', '$AJY_VERSION', '$AJY_NUM_ID')";
                $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
            }


            $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            UNIT_ACM_ID = '".substr($_POST["UNIT_NAME2"],0,4)."".'000000'."' ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  SUBSTRING(UNIT_CODE, 1, 5) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."' AND NRPT_UNIT_PARENT != '".substr($_POST["UNIT_CODE_PARENT"],0,2)."".'00000000'."'
            ";
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());

        $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            
            NRPT_UNIT_PARENT = '".substr($_POST["UNIT_NAME2"],0,4)."".'000000'."'   ,
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            UNIT_ACM_ID = '".substr($_POST["UNIT_NAME2"],0,4)."".'000000'."' ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  UNIT_CODE LIKE '".substr($_POST["UNIT_NAME2"],0,6)."".'0000'."'
            ";
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());


        $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
            ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." ) ,
            ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." ) 
            WHERE SUBSTRING(ROST_NUNIT, 1, 5) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."'
            ";

        //echo($sql_update_j3_rost_approve);     
        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());
        echo 'ศูนย์';
        break;

        case 'กองพัน':
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
            SELECT * FROM `j3_nrpt` WHERE  SUBSTRING(UNIT_CODE, 1, 6) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 6)."'  ";
            $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
            
                $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE SUBSTRING(ROST_UNIT, 1, 6) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 6)."' ";
                $res = mysqli_query($conn , $sql_select_j3_rost);
                $c = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $ROST_UNIT =  $row["ROST_UNIT"];
                    $ROST_CPOS = $row["ROST_CPOS"];
                    $ROST_POSNAME = $row["ROST_POSNAME"];
                    $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                    $ROST_RANK = $row["ROST_RANK"];
                    $ROST_RANKNAME = $row["ROST_RANKNAME"];
                    $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                    $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                    $ROST_ID = $row["ROST_ID"];
                    $ROST_PARENT = $row["ROST_PARENT"];
                    $ROST_NUNIT = $row["ROST_NUNIT"];
                    $ROST_NPARENT = $row["ROST_NPARENT"];
                    $STATUS = $row["STATUS"];
                    $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                    (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`, `VERSION`, `AJY_NUM_ID`) 
                    VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."' , '$AJY_VERSION', '$AJY_NUM_ID')";
                    $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
                }

                $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
                    UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 3), ".substr( $_POST["UNIT_NAME2"] , 0 , 3)." ) ,
                    NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
                    NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
                    WHERE  SUBSTRING(UNIT_CODE, 1, 6) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 6)."' AND NRPT_UNIT_PARENT NOT LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."".'00000'."'
                    ";
                //    echo $sql_update_j3_nrpt_approve;
                $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());

                $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
                    UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." ) ,
                    NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
                    NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
                    WHERE  UNIT_CODE LIKE '".substr($_POST["UNIT_CODE_PARENT"],0,6)."".'0000'."'";
                $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());



                $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
                    ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
                    ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 6), ".substr( $_POST["UNIT_NAME2"] , 0 , 6)." )  ,
                    ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 6), ".substr($_POST["UNIT_NAME2"], 0, 6).") ,
                    ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
                    ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
                    ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." ) 
                    WHERE SUBSTRING(ROST_UNIT, 1, 6) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 6)."'";
                $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());

            echo 'กองพัน';
        break;

        case 'กอง':
        
        $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
        SELECT * FROM `j3_nrpt` WHERE  SUBSTRING(UNIT_CODE, 1, 8) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 8)."'  ";
        $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        

            $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE SUBSTRING(ROST_UNIT, 1, 8) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 8)."' ";
            $res = mysqli_query($conn , $sql_select_j3_rost);
            $c = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $ROST_UNIT =  $row["ROST_UNIT"];
                $ROST_CPOS = $row["ROST_CPOS"];
                $ROST_POSNAME = $row["ROST_POSNAME"];
                $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                $ROST_RANK = $row["ROST_RANK"];
                $ROST_RANKNAME = $row["ROST_RANKNAME"];
                $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                $ROST_ID = $row["ROST_ID"];
                $ROST_PARENT = $row["ROST_PARENT"];
                $ROST_NUNIT = $row["ROST_NUNIT"];
                $ROST_NPARENT = $row["ROST_NPARENT"];
                $STATUS = $row["STATUS"];
                $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`, `VERSION`, `AJY_NUM_ID`) 
                VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."' , '$AJY_VERSION' , '$AJY_NUM_ID')";
                $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
            }


            $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  ,
            NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 3), ".substr( $_POST["UNIT_NAME2"] , 0 , 3)." ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  SUBSTRING(UNIT_CODE, 1, 8) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 8)."' AND NRPT_UNIT_PARENT NOT LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 5)."".'00000'."'
            ";
        //    echo $sql_update_j3_nrpt_approve;
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());

        $sql_update_j3_rost_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  
            WHERE  UNIT_CODE LIKE '".substr($_POST["UNIT_CODE_PARENT"],0,8)."".'00'."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());



        $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
            ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." )  ,
            ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." ) ,
            ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." ) 
            WHERE SUBSTRING(ROST_UNIT, 1, 8) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 8)."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());
        echo 'กอง';
        break;

        case 'แผนก':
        
        $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt_approve` 
        SELECT * FROM `j3_nrpt` WHERE  SUBSTRING(UNIT_CODE, 1, 10) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 10)."'  ";
        $result = mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        

            $sql_select_j3_rost = "SELECT * FROM `j3_rost` WHERE SUBSTRING(ROST_UNIT, 1, 10) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 10)."' ";
            $res = mysqli_query($conn , $sql_select_j3_rost);
            $c = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $ROST_UNIT =  $row["ROST_UNIT"];
                $ROST_CPOS = $row["ROST_CPOS"];
                $ROST_POSNAME = $row["ROST_POSNAME"];
                $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
                $ROST_RANK = $row["ROST_RANK"];
                $ROST_RANKNAME = $row["ROST_RANKNAME"];
                $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                $ROST_ID = $row["ROST_ID"];
                $ROST_PARENT = $row["ROST_PARENT"];
                $ROST_NUNIT = $row["ROST_NUNIT"];
                $ROST_NPARENT = $row["ROST_NPARENT"];
                $STATUS = $row["STATUS"];
                $sql_insert_j3_rost = "INSERT INTO `j3_rost_approve` 
                (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`, `VERSION`, `AJY_NUM_ID`) 
                VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', $ROST_ID, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."', '$AJY_VERSION' , '$AJY_NUM_ID')";
                $result = mysqli_query($conn, $sql_insert_j3_rost)  or die(mysqli_error());
            }


            $sql_update_j3_nrpt_approve = "UPDATE `j3_nrpt_approve` SET 
            UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 9), ".substr( $_POST["UNIT_NAME2"] , 0 , 9)." )  ,
            NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 9), ".substr( $_POST["UNIT_NAME2"] , 0 , 9)." )  ,
            NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 7), ".substr( $_POST["UNIT_NAME2"] , 0 , 7)." )  ,
            UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 3), ".substr( $_POST["UNIT_NAME2"] , 0 , 3)." ) ,
            NRPT_NAME = REPLACE(NRPT_NAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            NRPT_ACM = REPLACE(NRPT_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') 
            WHERE  SUBSTRING(UNIT_CODE, 1, 10) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 10)."' 
            ";
        //    echo $sql_update_j3_nrpt_approve;
        $result = mysqli_query($conn, $sql_update_j3_nrpt_approve) or die(mysqli_error());


        $sql_update_j3_rost_approve = "UPDATE `j3_rost_approve` SET 
            ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 10), ".substr( $_POST["UNIT_NAME2"] , 0 , 10)." )  ,
            ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), ".substr( $_POST["UNIT_NAME2"] , 0 , 4)." )  ,
            ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 5), ".substr( $_POST["UNIT_NAME2"] , 0 , 5)." )  ,
            ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 8), ".substr( $_POST["UNIT_NAME2"] , 0 , 8)." ) ,
            ROST_POSNAME = REPLACE(ROST_POSNAME, '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."') ,
            ROST_POSNAME_ACM = REPLACE(ROST_POSNAME_ACM, '".$_POST["UNIT_NAME_AJY_OLD"]."', '".$_POST["UNIT_NAME_AJY"]."') ,
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr( $MAX_ROST_NCPOS12 , 0 , 5)." ) 
            WHERE SUBSTRING(ROST_UNIT, 1, 8) LIKE '".substr($_POST["UNIT_CODE_PARENT"] , 0, 8)."'
            ";

        $result = mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());
        echo 'แผนก';
        break;
    }


    $sql_select_j3_nrpt_approve = "SELECT * FROM `j3_nrpt_approve` WHERE 1 ";
    $result = mysqli_query($conn, $sql_select_j3_nrpt_approve) or die(mysqli_error());
    while( $row = mysqli_fetch_assoc($result) ) {
        $sql_insert_into_j3_nrpt_transaction = "INSERT INTO `j3_nrpt_transaction` (`TRANSACTION_ID`, `UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`, `AJY_NUM_ID`) VALUES (NULL, '".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1', '".$AJY_NUM_ID."')";

        $result_transaction = mysqli_query($conn, $sql_insert_into_j3_nrpt_transaction)  or die(mysqli_error());

    }

    $sql_select_j3_rost_approve = "SELECT * FROM `j3_rost_approve` WHERE 1 ";
    $result = mysqli_query($conn, $sql_select_j3_rost_approve) or die(mysqli_error());
    while( $row = mysqli_fetch_assoc($result) ) {
        $sql_insert_into_j3_rost_transaction = "INSERT INTO `j3_rost_transaction` (`TRANSACTION_ID`, `ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `AJY_NUM_ID`, `STATUS`, `VERSION`) VALUES (NULL ,'".$row["ROST_UNIT"]."', '".$row["ROST_CPOS"]."', '".$row["ROST_POSNAME"]."', '".$row["ROST_POSNAME_ACM"]."', '".$row["ROST_RANK"]."', '".$row["ROST_RANKNAME"]."', '".$row["ROST_LAO_MAJ"]."', '".$row["ROST_NCPOS12"]."', '".$row["ROST_ID"]."', '".$row["ROST_PARENT"]."', '".$row["ROST_NUNIT"]."', '".$row["ROST_NPARENT"]."', '".$row["AJY_NUM_ID"]."', '1', '".$row["VERSION"]."')";

        $result_transaction = mysqli_query($conn, $sql_insert_into_j3_rost_transaction)  or die(mysqli_error());
    }

    die();
}

mysqli_close($conn);
if($result2 && $result3){
    echo "<script type='text/javascript'>";
    echo "alert('เพิ่มข้อมูลสำเร็จ');";
    echo "window.location = 'read_ajy.php'; ";
    echo "</script>";
}else{
    echo "<script type='text/javascript'>";
    echo "window.location = 'read_ajy.php'; ";
    echo "</script>";

}

?>