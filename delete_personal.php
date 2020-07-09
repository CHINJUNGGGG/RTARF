<?php

include ('db/connect.php');

$RATE_P_NUM = $_GET['id'];
$ACK_NUM_ID_1 = $_GET['id1'];
$TRANSACTION_ID = $_GET['id3'];
$ACK_NUM_ID = $_GET['id4'];
$ROST_POSNAME_ACM = $_GET['id5'];
$AJY_NUM_ID = $_GET['ajy'];

if($RATE_P_NUM!=''){

    $sql = "DELETE FROM j3_ratepersonal WHERE RATE_P_NUM ='".$RATE_P_NUM."'";
    
    if($conn->query($sql)== TRUE){
        echo "<script>window.location='des_ack.php?id=$ACK_NUM_ID_1'</script>";
    }else{
        echo "ERROR".$sql."<BR>".$conn-error;
        
    }
}  

if($TRANSACTION_ID!=''){
    
    $sql = "DELETE FROM j3_rost_transaction WHERE TRANSACTION_ID = '".$TRANSACTION_ID."'";
    
    if($ACK_NUM_ID != ''){
        if($conn->query($sql)== TRUE){
            echo "<script>window.location='des_ack.php?id=$ACK_NUM_ID'</script>";
        }else{
            echo "ERROR".$sql."<BR>".$conn-error;
            
        }
    }elseif($AJY_NUM_ID != ''){
        if($conn->query($sql)== TRUE){
        echo "<script>window.location='des_ajy.php?id=$AJY_NUM_ID'</script>";
        }else{
            echo "ERROR".$sql."<BR>".$conn-error;
            
        }
    }
    
} 


?>