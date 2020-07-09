<?php
    
    if(isset($_POST["do"]) && $_POST["do"] != "" ){
        $do = $_POST["do"];
        include ('db/connectpdo.php');
        include ('db/connect.php');
        switch($do){
            case 'modal_edit_p_ack':
                $sql3 = "SELECT 
                j3_rost_transaction.*,
                j1_rank.ROST_CDEP,
                j1_rank.RANK_ID,
                j1_rank.ROST_RANK,
                j3_rebirth.*,
                j3_nrpt_transaction.NRPT_NAME,
                j3_nrpt_transaction.NRPT_ACM
                FROM j3_rost_transaction
                LEFT JOIN j1_rank ON(j3_rost_transaction.ROST_RANK = j1_rank.ROST_RANK AND j3_rost_transaction.ROST_RANKNAME = j1_rank.ROST_RANKNAME) 
                LEFT JOIN j3_rebirth ON(j3_rost_transaction.ROST_LAO_MAJ = j3_rebirth.CLAO_NAME_SHORT)
                LEFT JOIN j3_nrpt_transaction ON(j3_nrpt_transaction.UNIT_CODE = j3_rost_transaction.ROST_UNIT)
                WHERE j3_rost_transaction.TRANSACTION_ID = :ID ";
                // echo json_encode($_POST);
                // die();
                $ID = $_POST["TRANSACTION_ID"];
                $stmt3=$db->prepare($sql3);
                $stmt3->bindparam(':ID',$ID);
                $stmt3->execute();
                $row3=$stmt3->fetch(PDO::FETCH_ASSOC);
                $row3['ROST_POSNAME'] = str_replace($_POST["old_unit_name"],$_POST["unit_name"],$row3["ROST_POSNAME"]);
                $row3['ROST_POSNAME_ACM'] = str_replace($_POST["old_unit_name_ack"],$_POST["unit_name_ack"],$row3["ROST_POSNAME_ACM"]);
                $row3['ROST_POSNAME'] = $row3['NRPT_NAME'];
                $row3['ROST_POSNAME_ACM'] = $row3['NRPT_ACM'];
                switch ($_POST["unit_acm_create"]) {
                    case 'กรม':
                        $row3["ROST_PARENT"] = substr($_POST["unit_name2"] , 0, 3).substr($row3["ROST_PARENT"] , 3, 9);   
                        $row3["ROST_NUNIT"] = substr($_POST["unit_name2"] , 0, 3).substr($row3["ROST_NUNIT"] , 3, 9);   
                        $row3["ROST_NPARENT"] = substr($_POST["unit_name2"] , 0, 3).substr($row3["ROST_NPARENT"] , 3, 9);   
                        $row3["ROST_UNIT"] = substr($_POST["unit_name2"] , 0, 3).substr($row3["ROST_UNIT"] , 3, 9);   
                    break;
                    case 'สำนัก':
                        $row3["ROST_PARENT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_PARENT"] , 5, 9);   
                        $row3["ROST_NUNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NUNIT"] , 5, 9);   
                        $row3["ROST_NPARENT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NPARENT"] , 5, 9);   
                        $row3["ROST_UNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_UNIT"] , 5, 9);   
                    break;
                    case 'ศูนย์':
                        $row3["ROST_PARENT"] = substr($_POST["unit_name2"] , 0, 4).substr($row3["ROST_PARENT"] , 4, 9);   
                        $row3["ROST_NUNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NUNIT"] , 5, 9);   
                        $row3["ROST_NPARENT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NPARENT"] , 5, 9);   
                        $row3["ROST_UNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_UNIT"] , 5, 9);   
                    break;
                    case 'กอง':
                        // $row3["ROST_PARENT"] = substr($_POST["unit_name2"] , 0, 4).substr($row3["ROST_PARENT"] , 4, 9);  
                        // $row3["ROST_NUNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NUNIT"] , 5, 9);   
                        $row3["ROST_NPARENT"] = substr($row3["ROST_NPARENT"] , 0, 6).substr( $_POST["unit_name2"], 6, 9);   
                        $row3["ROST_UNIT"] = substr($row3["ROST_UNIT"]  , 0, 6).substr($_POST["unit_name2"], 6, 9);   
                    break;
                    case 'แผนก':
                        // $row3["ROST_PARENT"] = substr($_POST["unit_name2"] , 0, 4).substr($row3["ROST_PARENT"] , 4, 9);  
                        // $row3["ROST_NUNIT"] = substr($_POST["unit_name2"] , 0, 5).substr($row3["ROST_NUNIT"] , 5, 9);   
                        $row3["ROST_NPARENT"] = substr($row3["ROST_NPARENT"] , 0, 7).substr($_POST["unit_name2"], 7,1).'00';
                        $row3["ROST_UNIT"] = substr($row3["ROST_UNIT"]  , 0, 6).substr($_POST["unit_name2"], 6, 9);   
                    break;
                }
                
                echo json_encode($row3);
            break;
            case 'updatedata_p_ack':
                $ACK_ID = $_POST['ACK_ID'];
                $ACK_NUM_ID = $_POST['ACK_NUM_ID'];
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
                $TRANSACTION_ID = $_POST['TRANSACTION_ID'];
                $ROST_UNIT = $_POST['ROST_UNIT'];
                $ROST_POSNAME = $_POST['ROST_POSNAME'];
                $ROST_POSNAME_ACM = $_POST['ROST_POSNAME_ACM'];
                if (isset($_POST['ROST_RANKNAME'])){
                    $ROST_RANKNAME = $_POST['ROST_RANKNAME'];
                }else{
                     $ROST_RANKNAME = $_POST['ROST_RANK'];
                }
                $ROST_RANK = $_POST['ROST_RANK'];
                if (isset($_POST['ROST_LAO_MAJ'])){
                    $ROST_LAO_MAJ = $_POST['ROST_LAO_MAJ'];
                }else{
                     $ROST_LAO_MAJ = $RATE_P_RANK;
                }
                $ROST_NCPOS12 = $_POST['ROST_NCPOS12'];
                $ROST_OLD_ID = $_POST['ROST_ID'];
                $ROST_PARENT = $_POST['ROST_PARENT'];
                $ROST_NUNIT = $_POST['ROST_NUNIT'];
                $ROST_NPARENT = $_POST['ROST_NPARENT'];
                $RATE_P_NUMBER = ($RATE_P_NUMBER == '')? 0:$RATE_P_NUMBER;
                $SALARY_ID = ($SALARY_ID == '')? 0:$SALARY_ID;

               
                $sql = "INSERT INTO j3_ratepersonal(RATE_P_NUM, ROST_CPOS, EXPERT_MIL_ID, RATE_P_REMARK, RATE_P_NUMBER, RATE_P_RANK, LAO_ID, D_ID, RATE_SEQ, SALARY_ID, ACK_ID, ACK_NUM_ID, RATE_P_VERSION, ROST_ID) "
                . "VALUES(NULL, :ROST_CPOS, :EXPERT_MIL_ID, :RATE_P_REMARK, :RATE_P_NUMBER, :RATE_P_RANK, :LAO_ID, :D_ID, :RATE_SEQ, :SALARY_ID, :ACK_ID, :ACK_NUM_ID, :RATE_P_VERSION, :TRANSACTION_ID)";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':ROST_CPOS',$ROST_CPOS);
                $stmt->bindparam(':EXPERT_MIL_ID',$EXPERT_MIL_ID);
                $stmt->bindparam(':RATE_P_REMARK',$RATE_P_REMARK);
                $stmt->bindparam(':RATE_P_NUMBER',$RATE_P_NUMBER);
                $stmt->bindparam(':RATE_P_RANK',$RATE_P_RANK);
                $stmt->bindparam(':LAO_ID',$LAO_ID);
                $stmt->bindparam(':D_ID',$D_ID);
                $stmt->bindparam(':RATE_SEQ',$RATE_SEQ);
                $stmt->bindparam(':SALARY_ID',$SALARY_ID);
                $stmt->bindparam(':ACK_ID',$ACK_ID);
                $stmt->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
                $stmt->bindparam(':RATE_P_VERSION',$RATE_P_VERSION);
                $stmt->bindparam(':TRANSACTION_ID',$TRANSACTION_ID);
                
                if ($stmt->execute()){
                    $RATE_P_NUM = $db->lastInsertId();
                }else{
                    echo json_encode($stmt->errorInfo());
                }
              
                $sql_find_ACK_NUM_ID = "SELECT * FROM `j3_ack` WHERE ACK_ID = '$ACK_ID'";
                $res = mysqli_query($conn, $sql_find_ACK_NUM_ID);
                $result = mysqli_fetch_assoc($res);
                $ACK_NUM_ID = $result["ACK_NUM_ID"];
                $VERSION = $result["ACK_VERSION"];
                // echo json_encode($_POS);
                // die();
                
               
                $sql2 = "INSERT INTO j3_rost_approve(ROST_UNIT, ROST_CPOS, ROST_POSNAME, ROST_POSNAME_ACM, ROST_RANK, ROST_RANKNAME, ROST_LAO_MAJ, ROST_NCPOS12, ROST_ID, ROST_PARENT, ROST_NUNIT, ROST_NPARENT, ACK_NUM_ID, VERSION) "
                . "VALUES(:ROST_UNIT, :ROST_CPOS, :ROST_POSNAME, :ROST_POSNAME_ACM, :RATE_P_RANK, :RATE_P_RANK, :LAO_ID, :ROST_NCPOS12, NULL, :ROST_PARENT, :ROST_NUNIT, :ROST_NPARENT, :ACK_NUM_ID , :VERSION)";
                $stmt2=$db->prepare($sql2);
                $stmt2->bindparam(':ROST_UNIT',$ROST_UNIT);
                $stmt2->bindparam(':ROST_CPOS',$ROST_CPOS);
                $stmt2->bindparam(':ROST_POSNAME',$ROST_POSNAME);
                $stmt2->bindparam(':ROST_POSNAME_ACM',$ROST_POSNAME_ACM);
                $stmt2->bindparam(':RATE_P_RANK',$RATE_P_RANK);
                $stmt2->bindparam(':LAO_ID',$LAO_ID);
                $stmt2->bindparam(':ROST_NCPOS12',$ROST_NCPOS12);
                $stmt2->bindparam(':ROST_PARENT',$ROST_PARENT);
                $stmt2->bindparam(':ROST_NUNIT',$ROST_NUNIT);
                $stmt2->bindparam(':ROST_NPARENT',$ROST_NPARENT);
                $stmt2->bindparam(':ACK_NUM_ID',$ACK_NUM_ID);
                $stmt2->bindparam(':VERSION',$VERSION);
                // $stmt2->bindparam(':ROST_ID',$ROST_ID);
                if ($stmt2->execute()){
                    $ROST_ID = $db->lastInsertId();
                    // echo json_encode($result);
                }else{
                    echo json_encode($stmt2->errorInfo());
                    die();
                }
                $sql_update = "UPDATE `j3_ratepersonal` SET ROST_ID = ? WHERE RATE_P_NUM = ?  ";
                $stmt3=$db->prepare($sql_update);
                if ($stmt3->execute([$ROST_ID , $RATE_P_NUM])){
                    echo json_encode('success');
                }else{
                    echo json_encode($stmt3->errorInfo());
                }
            break;
            case 'viewlast':
                $ROST_PARENT = $_POST['ROST_PARENT'];
                $ROST_NUNIT = $_POST['ROST_NUNIT'];
                $ROST_NPARENT = $_POST['ROST_NPARENT'];
                $ROST_UNIT = $_POST['ROST_UNIT'];
                $ROST_CPOS = $_POST['ROST_CPOS'];
                
                $condition = "";
                if ($ROST_PARENT != "") {
                    $condition .= "AND ROST_PARENT = $ROST_PARENT ";
                }
                if ($ROST_NUNIT != "") {
                    $condition .= "AND ROST_NUNIT = $ROST_NUNIT ";
                }
                if ($ROST_NPARENT != "") {
                    $condition .= "AND ROST_NPARENT = $ROST_NPARENT ";
                }
                if ($ROST_UNIT != "") {
                    $condition .= "AND ROST_UNIT = $ROST_UNIT ";
                }
                
                $sql = "SELECT * ,
                (SELECT ROST_POSNAME FROM j3_rost WHERE j3_rost.ROST_ID = j3_ratepersonal.ROST_OLD_ID) AS ROST_POSTNAME_OLD
                FROM `j3_ratepersonal` 
                LEFT JOIN `j3_rost` 
                ON(j3_rost.ROST_ID = j3_ratepersonal.ROST_ID ) 
                WHERE j3_ratepersonal.`ROST_CPOS` LIKE '".$ROST_CPOS."' $condition 
                ";
                // echo json_encode($sql);
                $stmt=$db->prepare($sql);
                $stmt->execute();
                $row=$stmt->fetchall(PDO::FETCH_ASSOC);
            
                echo json_encode($row);
            
            break;
        }
    }
?>