<?php

require_once __DIR__.'/db/connect.php';

date_default_timezone_set("Asia/Bangkok");

$ROST_12 = $_POST['ROST_12'];
$ID = $_POST['id'];   
$ACK_NUM_ID = $_POST['ACK_NUM_ID'];
$AJY_NUM_ID = $_POST['AJY_NUM_ID'];

// echo json_encode($_POST); 
// die();

if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
        case 'ncpos_12':

            $sql_update_j3_rost_approve = "UPDATE `j3_rost_transaction` SET 
            ROST_NCPOS12 = Replace(ROST_NCPOS12 , Substring(ROST_NCPOS12, 1, 5), ".substr($ROST_12 , 0 , 5)." ) 
            WHERE SUBSTRING(ROST_NUNIT, 1, 5) LIKE '".substr($_POST["id"] , 0, 5)."' AND ACK_NUM_ID = '".$_POST['ACK_NUM_ID']."' AJY_NUM_ID = '".$_POST['AJY_NUM_ID']."'
            ";

            // echo($sql_update_j3_rost_approve);
            // die();

        mysqli_query($conn, $sql_update_j3_rost_approve) or die(mysqli_error());

        break;    
    }
}

?>