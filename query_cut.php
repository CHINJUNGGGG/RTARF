<?php
    
    if(isset($_POST["do"]) && $_POST["do"] != "" ){
        $do = $_POST["do"];
        include ('db/connectpdo.php');
        include 'db/connect.php';
        switch($do){
            case 'modal_edit_cut':
                $sql3 = "SELECT 
                j3_rost_transaction.*,
                j1_rank.ROST_CDEP,
                j1_rank.RANK_ID,
                j1_rank.ROST_RANK
                FROM j3_rost_transaction
                LEFT JOIN j1_rank ON(j3_rost_transaction.ROST_RANK = j1_rank.ROST_RANK AND j3_rost_transaction.ROST_RANKNAME = j1_rank.ROST_RANKNAME) 
                
                WHERE j3_rost_transaction.TRANSACTION_ID = :ID GROUP BY j3_rost_transaction.ROST_POSNAME_ACM,j3_rost_transaction.ROST_RANK";
                // echo json_encode($_POST);
                // die();
                $ID = $_POST["TRANSACTION_ID"];
                $stmt3=$db->prepare($sql3);
                $stmt3->bindparam(':ID',$ID);
                $stmt3->execute();
                $row3=$stmt3->fetch(PDO::FETCH_ASSOC);

                // $row3['ROST_POSNAME'] = str_replace($_POST["old_unit_name"],$_POST["unit_name"],$row3["ROST_POSNAME"]);
                // $row3['ROST_POSNAME_ACM'] = str_replace($_POST["old_unit_name_ajy"],$_POST["unit_name_ajy"],$row3["ROST_POSNAME_ACM"]);
                // $row3['ROST_POSNAME'] = $row3['ROST_POSNAME'];
                // $row3['ROST_POSNAME_ACM'] = $row3['ROST_POSNAME_ACM'];

                echo json_encode($row3);
                    
                    // $ROST_POSNAME_ACM = $_POST["ROST_POSNAME_ACM"];
                    // $AJY_NUM_ID = $_POST['AJY_NUM_ID'];
                    // $ROST_RANK_CUT = $_POST['ROST_RANK_CUT'];
            
                    // $sql_count = "SELECT j3_rost_transaction.*,COUNT(TRANSACTION_ID) FROM j3_rost_transaction 
                    //     WHERE j3_rost_transaction.AJY_NUM_ID = :AJY_NUM_ID AND j3_rost_transaction.ROST_POSNAME_ACM = :ROST_POSNAME_ACM AND j3_rost_transaction.ROST_RANK = :ROST_RANK_CUT
                    //     GROUP BY j3_rost_transaction.ROST_POSNAME_ACM,j3_rost_transaction.ROST_RANK";
                    //     echo json_encode($_POST);
                    //     //die();
                    // $stmt_count = $db->prepare($sql_count);
                    // $stmt_count->bindparam(':ROST_POSNAME_ACM',$ROST_POSNAME_ACM);
                    // $stmt_count->bindparam(':AJY_NUM_ID',$AJY_NUM_ID);
                    // $stmt_count->bindparam(':ROST_RANK_CUT',$ROST_RANK_CUT);
                    // $stmt_count->execute();
                    // $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
                    // // $COUNT = $row_count['COUNT(TRANSACTION_ID)'];
                    // // while(){

                    // // }
                
                    // echo json_encode($row_count);
                // echo json_encode($ROST_POSNAME_ACM);
                // echo json_encode($ROST_RANK);
            break;
            case 'updatedata_cut':
                $AJY_ID = $_POST['AJY_ID'];
                $AJY_NUM_ID = $_POST['AJY_NUM_ID'];
                $ROST_CPOS = $_POST['ROST_CPOS'];
                $RATE_P_RANK = $_POST['RATE_P_RANK'];
                $SALARY_ID = $_POST['SALARY_ID'];
                $EXPERT_MIL_ID = $_POST['EXPERT_MIL_ID'];
                $RATE_P_NUMBER = $_POST['RATE_P_NUMBER'];
                $RATE_P_REMARK = $_POST['RATE_P_REMARK'];
                $LAO_ID = $_POST['LAO_ID'];
                $D_ID = $_POST['D_ID'];
                $RATE_SEQ = $_POST['RATE_SEQ'];
                $RATE_P_VERSION = 1;
                $ROST_UNIT = $_POST['ROST_UNIT'];
                $ROST_POSNAME = $_POST['ROST_POSNAME'];
                $ROST_POSNAME_ACM = $_POST['ROST_POSNAME_ACM'];
                // if (isset($_POST['ROST_RANKNAME'])){
                //     $ROST_RANKNAME = $_POST['ROST_RANKNAME'];
                // }else{
                //      $ROST_RANKNAME = $_POST['ROST_RANK'];
                // }
                $ROST_RANK = $_POST['ROST_RANK'];

                echo json_encode($_POST);
                //die();
                // if (isset($_POST['ROST_LAO_MAJ'])){
                //     $ROST_LAO_MAJ = $_POST['ROST_LAO_MAJ'];
                // }else{
                //      $ROST_LAO_MAJ = $RATE_P_RANK;
                // }
                // $ROST_NCPOS12 = $_POST['ROST_NCPOS12'];
                // $ROST_OLD_ID = $_POST['ROST_ID'];
                // $ROST_PARENT = $_POST['ROST_PARENT'];
                // $ROST_NUNIT = $_POST['ROST_NUNIT'];
                // $ROST_NPARENT = $_POST['ROST_NPARENT'];
                // $RATE_P_NUMBER = ($RATE_P_NUMBER == '')? 0:$RATE_P_NUMBER;
                // $SALARY_ID = ($SALARY_ID == '')? 0:$SALARY_ID;

               
                // $sql = "INSERT INTO j3_ratepersonal_ajy(RATE_P_NUM, ROST_CPOS, EXPERT_MIL_ID, RATE_P_REMARK, RATE_P_NUMBER, RATE_P_RANK, LAO_ID, D_ID, RATE_SEQ, SALARY_ID, AJY_ID, AJY_NUM_ID, RATE_P_VERSION ) "
                // . "VALUES(NULL, :ROST_CPOS, :EXPERT_MIL_ID, :RATE_P_REMARK, :RATE_P_NUMBER, :RATE_P_RANK, :LAO_ID, :D_ID, :RATE_SEQ, :SALARY_ID, :AJY_ID, :AJY_NUM_ID, :RATE_P_VERSION )";
                // $stmt=$db->prepare($sql);
                // $stmt->bindparam(':ROST_CPOS',$ROST_CPOS);
                // $stmt->bindparam(':EXPERT_MIL_ID',$EXPERT_MIL_ID);
                // $stmt->bindparam(':RATE_P_REMARK',$RATE_P_REMARK);
                // $stmt->bindparam(':RATE_P_NUMBER',$RATE_P_NUMBER);
                // $stmt->bindparam(':RATE_P_RANK',$RATE_P_RANK);
                // $stmt->bindparam(':LAO_ID',$LAO_ID);
                // $stmt->bindparam(':D_ID',$D_ID);
                // $stmt->bindparam(':RATE_SEQ',$RATE_SEQ);
                // $stmt->bindparam(':SALARY_ID',$SALARY_ID);
                // $stmt->bindparam(':AJY_ID',$AJY_ID);
                // $stmt->bindparam(':AJY_NUM_ID',$AJY_NUM_ID);
                // $stmt->bindparam(':RATE_P_VERSION',$RATE_P_VERSION);
                // // $stmt->bindparam(':ROST_OLD_ID',$ROST_OLD_ID);
                
                // if ($stmt->execute()){
                //     $RATE_P_NUM = $db->lastInsertId();
                // }else{
                //     echo json_encode($stmt->errorInfo());
                // }
              
                // $sql_find_AJY_NUM_ID = "SELECT * FROM `j3_ajy` WHERE AJY_ID = '$AJY_ID'";
                // $res = mysqli_query($conn, $sql_find_AJY_NUM_ID);
                // $result = mysqli_fetch_assoc($res);
                // $AJY_NUM_ID = $result["AJY_NUM_ID"];
                // $VERSION = $result["AJY_VERSION"];
                // // echo json_encode($_POS);
                // // die();
                
               
                // $sql2 = "INSERT INTO j3_rost_approve(ROST_UNIT, ROST_CPOS, ROST_POSNAME, ROST_POSNAME_ACM, ROST_RANK, ROST_RANKNAME, ROST_LAO_MAJ, ROST_NCPOS12, ROST_ID, ROST_PARENT, ROST_NUNIT, ROST_NPARENT, AJY_NUM_ID, VERSION) "
                // . "VALUES(:ROST_UNIT, :ROST_CPOS, :ROST_POSNAME, :ROST_POSNAME_ACM, :RATE_P_RANK, :RATE_P_RANK, :LAO_ID, :ROST_NCPOS12, NULL, :ROST_PARENT, :ROST_NUNIT, :ROST_NPARENT, :AJY_NUM_ID , :VERSION)";
                // $stmt2=$db->prepare($sql2);
                // $stmt2->bindparam(':ROST_UNIT',$ROST_UNIT);
                // $stmt2->bindparam(':ROST_CPOS',$ROST_CPOS);
                // $stmt2->bindparam(':ROST_POSNAME',$ROST_POSNAME);
                // $stmt2->bindparam(':ROST_POSNAME_ACM',$ROST_POSNAME_ACM);
                // $stmt2->bindparam(':RATE_P_RANK',$RATE_P_RANK);
                // $stmt2->bindparam(':LAO_ID',$LAO_ID);
                // $stmt2->bindparam(':ROST_NCPOS12',$ROST_NCPOS12);
                // $stmt2->bindparam(':ROST_PARENT',$ROST_PARENT);
                // $stmt2->bindparam(':ROST_NUNIT',$ROST_NUNIT);
                // $stmt2->bindparam(':ROST_NPARENT',$ROST_NPARENT);
                // $stmt2->bindparam(':AJY_NUM_ID',$AJY_NUM_ID);
                // $stmt2->bindparam(':VERSION',$VERSION);
                // // $stmt2->bindparam(':ROST_ID',$ROST_ID);
                // if ($stmt2->execute()){
                //     $ROST_ID = $db->lastInsertId();
                //     // echo json_encode($result);
                // }else{
                //     echo json_encode($stmt2->errorInfo());
                //     die();
                // }
                $sql_update = "UPDATE j3_rost_transaction SET AJY_CUT= '$AJY_CUT' WHERE AJY_NUM_ID = '$AJY_NUM_ID' AND ROST_POSNAME_ACM = '$ROST_POSNAME_ACM' AND ROST_RANK = '$ROST_RANK'";
                $stmt3=$db->prepare($sql_update);
                if ($stmt3->execute([$AJY_CUT , $AJY_NUM_ID, $ROST_POSNAME_ACM, $ROST_RANK])){
                    echo json_encode('success');
                }else{
                    echo json_encode($stmt3->errorInfo());
                }
            break;
        }
    }
?>