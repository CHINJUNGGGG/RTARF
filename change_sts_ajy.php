<?php
include ('db/connect.php');
 
$AJY_NUM_ID = $_GET['id'];
$index = $_GET['index'];
$sql = "SELECT * FROM `j3_ajy` WHERE AJY_NUM_ID = '$AJY_NUM_ID'  ";
$res = mysqli_query($conn,$sql) or die(mysql_error());
$row = mysqli_fetch_assoc($res) ;
$AJY_NUM_ID = $row["AJY_NUM_ID"];
$UNIT_ACM_CREATE = $row['UNIT_ACM_CREATE'];
$UNIT_ACM_ID = $row['UNIT_ACM_ID'];
$UNIT_CODE = $row['UNIT_CODE'];
$UNIT_CODE_PARENT = $row['UNIT_CODE_PARENT'];
$UNIT_NAME = $row['UNIT_NAME'];
$UNIT_NAME_AJY = $row['UNIT_NAME_AJY'];
// ACK_NUM_ID  LIKE '$ACK_NUM_ID'



$sql_find_part_id = "SELECT PART_ID FROM `j3_unit_acm` WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE '".substr($UNIT_ACM_ID , 0, 2)."' AND PART_ID != 0 LIMIT 1 ";
$query_find_part_id = mysqli_query($conn,$sql_find_part_id) or die(mysql_error());
$result_find_part_id = mysqli_fetch_assoc($query_find_part_id) ;
$PART_ID = $result_find_part_id['PART_ID'];
$sql_insert_j3_unit_acm = "INSERT INTO `j3_unit_acm` (`UNIT_ACM_ID`, `UNIT_NAME`, `UNIT_ACM_NAME`, `PART_ID`, `SORT`) 
VALUES ('$UNIT_CODE', '$UNIT_NAME', '$UNIT_NAME_AJY', '$PART_ID', '0')";




switch ($UNIT_ACM_CREATE) {
    case 'กรม':
        $result_query_insert_j3_unit_acm = mysqli_query($conn,$sql_insert_j3_unit_acm) or die(mysqli_error($conn) . "<br>$sql_insert_j3_unit_acm");

        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }
    break;

    case 'สำนัก':
        $result_query_insert_j3_unit_acm = mysqli_query($conn,$sql_insert_j3_unit_acm) or die(mysqli_error($conn) . "<br>$sql_insert_j3_unit_acm");

        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }
    break;

    case 'ศูนย์':
        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

       
        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }
    break;

    case 'กองพัน':

        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE  AJY_NUM_ID  LIKE '$AJY_NUM_ID'  ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }
    break;

    case 'กอง':

        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE  AJY_NUM_ID  LIKE '$AJY_NUM_ID'  ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }
    break;

    case 'แผนก':

        $sql = "SELECT * FROM `j3_nrpt_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID'  "; 
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$row["UNIT_CODE"]."', '".$row["NRPT_NAME"]."', '".$row["NRPT_ACM"]."', '".$row["NRPT_NUNIT"]."', '".$row["NRPT_NPAGE"]."', current_timestamp(), '".$row["NRPT_UNIT_PARENT"]."', '".$row["NRPT_USER"]."', '".$row["UNIT_ACM_ID"]."', '1')";
            mysqli_query($conn, $sql_insert_j3_nrpt) or die(mysqli_error());
        }

        $sql = "DELETE FROM `j3_nrpt_transaction` WHERE  AJY_NUM_ID  LIKE '$AJY_NUM_ID'  ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());

        $sql = "SELECT * FROM `j3_rost_transaction` WHERE AJY_NUM_ID  LIKE '$AJY_NUM_ID' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error());
        $c = 0;
        while( $row = mysqli_fetch_assoc($result)) {
            $sql_set = "UPDATE `j3_rost` SET STATUS = 0 WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            $res = mysqli_query($conn, $sql_set) or die(mysqli_error());

            $ROST_UNIT =  $row["ROST_UNIT"];
            $ROST_CPOS = $row["ROST_CPOS"];
            $ROST_POSNAME = $row["ROST_POSNAME"];
            $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];
            $ROST_RANK = $row["ROST_RANK"];
            $ROST_RANKNAME = $row["ROST_RANKNAME"];
            $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
            $ROST_NCPOS12 = $row["ROST_NCPOS12"];
            $ROST_ID = NULL;
            $ROST_PARENT = $row["ROST_PARENT"];
            $ROST_NUNIT = $row["ROST_NUNIT"];
            $ROST_NPARENT = $row["ROST_NPARENT"];
            $STATUS = $row["STATUS"];
            $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
            (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
            VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."',  NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
            mysqli_query($conn, $sql_insert_j3_rost) or die(mysqli_error());

            $sql_del = "DELETE FROM `j3_rost_transaction` WHERE ROST_ID = '".$row["ROST_ID"]."'  ";
            mysqli_query($conn, $sql_del) or die(mysqli_error());
        }

    break;
    
}


// sort
$c = 1;
$sql = "SELECT * FROM `j3_nrpt` WHERE `NRPT_UNIT_PARENT` LIKE '$UNIT_ACM_ID' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900)";
$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
while( $row = mysqli_fetch_assoc($query)) {
    if ($c != $index) {
        $sql_update = "UPDATE `j3_nrpt` SET SORT = '$c' WHERE UNIT_CODE = '".$row["UNIT_CODE"]."'  ";
        $c++;
    } else{
        $c++;
        $sql_update = "UPDATE `j3_nrpt` SET SORT = '$c' WHERE UNIT_CODE = '".$row["UNIT_CODE"]."'  ";
        $c++;
    }
        mysqli_query($conn,$sql_update) or die(mysqli_error($conn));    
}

$sql_update = "UPDATE `j3_nrpt` SET SORT = '$index' WHERE UNIT_CODE = '".$UNIT_CODE."'  ";
mysqli_query($conn,$sql_update) or die(mysqli_error($conn));  
// end sort

$AJY_NUM_ID_1 = $_GET['id1'];



if($AJY_NUM_ID!=''){

    $sql = "UPDATE j3_ajy SET AJY_STS = 'อนุมัติ' WHERE AJY_NUM_ID ='".$AJY_NUM_ID."'";
    
    if($conn->query($sql)== TRUE){
        echo "<script>window.location='read_ajy.php'</script>";
    }else{
        echo "ERROR".$sql."<BR>".$conn-error;
        
    }
}  

if($AJY_NUM_ID_1!=''){

    $sql1 = "UPDATE j3_ajy SET AJY_STS = 'ไม่อนุมัติ' WHERE AJY_NUM_ID ='".$AJY_NUM_ID_1."'";
    
    if($conn->query($sql1)== TRUE){
        echo "<script>window.location='des_ajy.php?id=$AJY_NUM_ID_1'</script>";
    }else{
        echo "ERROR".$sql1."<BR>".$conn-error;
        
    }
}

?>