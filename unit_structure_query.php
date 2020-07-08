<?php
    if(isset($_POST["do"]) && $_POST["do"] != "" ){
        $do = $_POST["do"];
        
        switch($do){
            case 'get_j3_unit_acm':
            include ('connectpdo.php');
                $PART_ID = $_POST['PART_ID'];
                $sql = "SELECT * FROM j3_unit_acm WHERE PART_ID = :PART_ID";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':PART_ID',$PART_ID);
                $stmt->execute();
                $row=$stmt->fetchall(PDO::FETCH_ASSOC);
                echo json_encode($row);
            break;
            case 'process2':
            include 'connect.php';
                $sql = "TRUNCATE `rtarf`.`j3_unit_acm_transaction`";
                $res = mysqli_query($conn, $sql);
                $sql = "TRUNCATE `rtarf`.`j3_nrpt_transaction`";
                $res = mysqli_query($conn, $sql);
                $sql = "TRUNCATE `rtarf`.`j3_rost_transaction`";
                $res = mysqli_query($conn, $sql);
                $digit = sprintf("%04d" , substr($_POST["UNIT_ACM_ID"] , 0, 2)."09");
                $index = $digit+$_POST["index"];
                $sql1 = "insert into j3_unit_acm_transaction 
                select * from j3_unit_acm WHERE SUBSTRING(UNIT_ACM_ID, 1, 4)  LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."'   ";
                $res = mysqli_query($conn, $sql1);
                // $sql2 = "insert into j3_rost_transaction 
                // select * from j3_rost WHERE SUBSTRING(ROST_UNIT, 1, 4)  LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."'   ";
                // $res = mysqli_query($conn, $sql2);
                $sql2 = "insert into j3_rost_transaction 
                select * from j3_rost WHERE ROST_NUNIT  LIKE  '".$_POST["UNIT_CODE"]."'   ";
                $res = mysqli_query($conn, $sql2);
                
                $sql3 = "insert into j3_nrpt_transaction 
                select * from j3_nrpt WHERE SUBSTRING(UNIT_CODE, 1, 4)  LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."'   ";
                $res = mysqli_query($conn, $sql3);
                $sql_main = "UPDATE  `j3_unit_acm_transaction` SET  
                UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), $index) ,
                PART_ID = '".$_POST["PART_ID"]."'
                WHERE Substring(UNIT_ACM_ID, 1, 2) != '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."' ";
                $res2 = mysqli_query($conn, $sql_main);
                $sql_main2 = "UPDATE  `j3_rost_transaction` SET  
                ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 4), $index) ,
                ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), $index) ,
                ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 4), $index) ,
                ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 4), $index) 
                WHERE Substring(ROST_UNIT, 1, 2) != '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."' ";
                $res2 = mysqli_query($conn, $sql_main2);
                
                // move to rateposernal
                $EXPERT_MIL_ID = '';
                $RATE_P_REMARK = '';
                $RATE_P_NUMBER = '1';
                $RATE_P_RANK = '';
                $SALARY_ID = '';
                $ACK_ID = $_POST["ACK_ID"];
                $j3_rost = "select * from j3_rost_transaction WHERE 1";
                $query = mysqli_query($conn, $j3_rost);
                while($row = mysqli_fetch_assoc($query)) {
                    $j3_ratepersonal_sql = "INSERT INTO `j3_ratepersonal` (`RATE_P_NUM`, `ROST_CPOS`, 
                    `EXPERT_MIL_ID`, `RATE_P_REMARK`, `RATE_P_NUMBER`, 
                    `RATE_P_RANK`, `SALARY_ID`, `ACK_ID`, `RATE_P_VERSION`,
                     `ROST_ID`, `ROST_OLD_ID`) VALUES (NULL, '".$row["ROST_CPOS"]."',
                      '".$EXPERT_MIL_ID."', '".$RATE_P_REMARK."', '".$RATE_P_NUMBER."', 
                      '".$RATE_P_RANK."', '".$SALARY_ID."', '".$ACK_ID."', '1',
                       '".$row["ROST_ID"]."', '".$row["ROST_ID"]."')";
                        $resss = mysqli_query($conn, $j3_ratepersonal_sql);
                }
                $sql_main3 = "UPDATE  `j3_nrpt_transaction` SET  
                UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), $index) ,
                NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), $index) ,
                NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 4), $index) ,
                UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), $index) 
                WHERE Substring(UNIT_CODE, 1, 2) != '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."' ";
                $res3 = mysqli_query($conn, $sql_main3);
                $sql3 = "insert into j3_rost_transaction 
                select * from j3_rost WHERE SUBSTRING(ROST_UNIT, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'   ";
                $res3 = mysqli_query($conn, $sql3);
               
                $sql4 = "insert into j3_nrpt_transaction 
                select * from j3_nrpt WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'   ";
                $res4 = mysqli_query($conn, $sql4);
                $index++;
                $sql = "select * from j3_unit_acm WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'   ";
                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)) {
                    if (substr($row["UNIT_ACM_ID"] , 0 , 4) >  $index){
                        $unit_acm = $index.substr($row["UNIT_ACM_ID"] , 4 , 7);
                        $sql_query = "INSERT INTO `j3_unit_acm_transaction` (`UNIT_ACM_ID`, `UNIT_NAME`, `UNIT_ACM_NAME`, `PART_ID`, `STATUS`)
                        VALUES ('$unit_acm', '".$row["UNIT_NAME"]."', '".$row["UNIT_ACM_NAME"]."', '".$row["PART_ID"]."', '1')";
                        $index++;
                        $res2= mysqli_query($conn, $sql_query);
                    }else{
                        
                            $chk = "SELECT * FROM j3_unit_acm_transaction WHERE UNIT_ACM_ID = '".$row["UNIT_ACM_ID"]."'  ";
                            $chk_res = mysqli_query($conn, $chk);
                            
                            if (mysqli_num_rows($chk_res) > 0){
                                $unit_acm = $index.substr($row["UNIT_ACM_ID"] , 4 , 7);
                                $index++;
                            }else{
                                $unit_acm = $row["UNIT_ACM_ID"];
                            }
                            $sql_query = "INSERT INTO `j3_unit_acm_transaction` (`UNIT_ACM_ID`, `UNIT_NAME`, `UNIT_ACM_NAME`, `PART_ID`, `STATUS`)
                            VALUES ('$unit_acm', '".$row["UNIT_NAME"]."', '".$row["UNIT_ACM_NAME"]."', '".$row["PART_ID"]."', '1')";
                            $res2= mysqli_query($conn, $sql_query);
                        
                        
                        
                    }
                    
                    $unit_acm_four_digit = substr( $unit_acm , 0 , 4);
                    $sql_query_j3_rost = "UPDATE j3_rost_transaction SET 
                    ROST_UNIT = Replace(ROST_UNIT , Substring(ROST_UNIT, 1, 4), $unit_acm_four_digit ) , 
                    ROST_PARENT = Replace(ROST_PARENT , Substring(ROST_PARENT, 1, 4), $unit_acm_four_digit ) , 
                    ROST_NUNIT = Replace(ROST_NUNIT , Substring(ROST_NUNIT, 1, 4), $unit_acm_four_digit ) , 
                    ROST_NPARENT = Replace(ROST_NPARENT , Substring(ROST_NPARENT, 1, 4), $unit_acm_four_digit )  
                      WHERE SUBSTRING(ROST_UNIT, 1, 4) = '".substr($row["UNIT_ACM_ID"] , 0, 4)."'  ";
                    $res_j3_rost = mysqli_query($conn, $sql_query_j3_rost);
                    
                    // echo json_encode($unit_acm);
                    // echo json_encode($sql_query_j3_rost);
                    // $sql_query_j3_nrpt = "UPDATE j3_nrpt_transaction SET 
                    // UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 4), $unit_acm_four_digit ) , 
                    // NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 4), $unit_acm_four_digit ) , 
                    // NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 4), $unit_acm_four_digit ) , 
                    // UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 4), $unit_acm_four_digit )  
                    //   WHERE SUBSTRING(UNIT_CODE, 1, 4) = '".substr($row["UNIT_ACM_ID"] , 0, 4)."'  ";
                    // $res_j3_nrpt = mysqli_query($conn, $sql_query_j3_nrpt);
                    
                }
                
                $sql = "UPDATE j3_rost SET STATUS = 0 WHERE SUBSTRING(ROST_UNIT, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'  ";
                $res = mysqli_query($conn, $sql);
                $sql = "UPDATE j3_unit_acm SET STATUS = 0 WHERE SUBSTRING(UNIT_ACM_ID, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'  ";
                $res = mysqli_query($conn, $sql);
                $sql = "UPDATE j3_nrpt SET STATUS = 0 WHERE SUBSTRING(UNIT_CODE, 1, 2) LIKE  '".substr($_POST["UNIT_ACM_ID"] , 0, 2)."'  ";
                $res = mysqli_query($conn, $sql);
                // not apdate default value
                // $sql1 = "UPDATE  j3_unit_acm SET STATUS = 0 WHERE SUBSTRING(UNIT_ACM_ID, 1, 4)  LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."'   ";
                // $res = mysqli_query($conn, $sql1);
                $sql2 = "UPDATE  j3_rost SET STATUS = 0  WHERE ROST_NUNIT  LIKE  '".$_POST["UNIT_CODE"]."'   ";
                $res = mysqli_query($conn, $sql2);
                $sql3 = "UPDATE  j3_nrpt SET STATUS = 0 WHERE SUBSTRING(UNIT_CODE, 1, 4)  LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."'   ";
                $res = mysqli_query($conn, $sql3);
                $sql = "DELETE FROM j3_rost WHERE j3_rost.STATUS = 0 ";
                $res = mysqli_query($conn, $sql);
                $sql = "DELETE FROM j3_unit_acm WHERE j3_unit_acm.STATUS = 0 ";
                $res = mysqli_query($conn, $sql);
                $sql = "DELETE FROM j3_nrpt WHERE j3_nrpt.STATUS = 0  ";
                $res = mysqli_query($conn, $sql);
                $sql1 = "insert into j3_unit_acm
                select * from j3_unit_acm_transaction WHERE 1  ";
                $res = mysqli_query($conn, $sql1);
                $sql1 = "insert into j3_nrpt
                select * from j3_nrpt_transaction WHERE 1  ";
                $res = mysqli_query($conn, $sql1);
                $sql1 = "insert into j3_rost
                select * from j3_rost_transaction WHERE 1  ";
                $res = mysqli_query($conn, $sql1);
                // echo json_encode($sql);
            break;
            case 'process':
                include 'connect.php';
                // echo json_encode($_POST);
                // die();

                $sql_find_NRPT_NAME = "SELECT * FROM `j3_nrpt` WHERE UNIT_CODE LIKE '".substr($_POST["UNIT_CODE"] , 0, 4)."000000'  ";
                $res = mysqli_query($conn, $sql_find_NRPT_NAME);
                $result = mysqli_fetch_assoc($res);
                $NRPT_NAME_OLD = $result["NRPT_NAME"];
                $NRPT_ACM_OLD = $result["NRPT_ACM"];
                $arr_NRPT_ACM_OLD = explode(".", $NRPT_ACM_OLD );

                
                
                $index = $_POST["index"];
                
                $sql_j3_unit_acm_old = "SELECT * FROM `j3_unit_acm` WHERE SUBSTRING(UNIT_ACM_ID, 1, 4) LIKE  '".substr($_POST["UNIT_CODE"] , 0, 4)."' ";
                $res = mysqli_query($conn, $sql_j3_unit_acm_old);
                $j3_unit_acm_old = mysqli_fetch_assoc($res);
                $sql_find_max_unit_acm_id = "SELECT MAX( SUBSTRING(UNIT_ACM_ID, 1, 3)) AS max_unit_acm_id   FROM `j3_unit_acm` WHERE PART_ID = '".$_POST["PART_ID"]."' ";
                $res = mysqli_query($conn, $sql_find_max_unit_acm_id);
                $result = mysqli_fetch_assoc($res);
                $max_unit_acm_id = $result["max_unit_acm_id"];
                $new_unit_acm_id = ($max_unit_acm_id+1).'00'.substr($_POST["UNIT_CODE"] , 5 , 10) ;
                $sql_insert_j3_unit_acm = "INSERT INTO `j3_unit_acm` (UNIT_ACM_ID, UNIT_NAME, UNIT_ACM_NAME, PART_ID) 
                VALUES($new_unit_acm_id, '".$_POST["UNIT_NAME"]."', '".$_POST["UNIT_NAME_ACK"]."', '".$_POST["PART_ID"]."'  ) ";
                $res = mysqli_query($conn, $sql_insert_j3_unit_acm);
                $sql = "SELECT * FROM `j3_unit_acm` WHERE PART_ID = '".$_POST["PART_ID"]."' AND UNIT_ACM_ID != $new_unit_acm_id  ";
                $res = mysqli_query($conn , $sql);
                $c = 0;
                while ($result = mysqli_fetch_assoc($res)) {
                    $c+=1;
                    if ($c == $index){
                        $c+=1;
                    }
                    $sql_update = "UPDATE `j3_unit_acm` SET SORT = $c WHERE  UNIT_ACM_ID LIKE  '".$result["UNIT_ACM_ID"]."'   ";
                    $re = mysqli_query($conn , $sql_update);
                }
                $sql_update = "UPDATE `j3_unit_acm` SET SORT = $index WHERE  UNIT_ACM_ID LIKE  '".$new_unit_acm_id."'   ";
                $re = mysqli_query($conn , $sql_update);
                $sql_j3_rost = "SELECT * FROM `j3_rost` WHERE ROST_NUNIT LIKE '".$_POST["UNIT_CODE"]."' ";
                $res = mysqli_query($conn, $sql_j3_rost);
                while($row = mysqli_fetch_assoc($res)) {
                    $ROST_UNIT = substr( $new_unit_acm_id , 0 , 5).substr( $row["ROST_UNIT"] , 5 , 10);
                    $ROST_CPOS = $row["ROST_CPOS"];

                    $ROST_POSNAME =  str_replace($_POST["UNIT_NAME_OLD"],$_POST["UNIT_NAME"] , $row["ROST_POSNAME"]);
                    $ROST_POSNAME =  str_replace($NRPT_NAME_OLD, "", $ROST_POSNAME);

                    // $ROST_POSNAME_ACM = $row["ROST_POSNAME_ACM"];

                    $ROST_POSNAME_ACM =  str_replace($_POST["UNIT_NAME_ACK_OLD"],$_POST["UNIT_NAME_ACK"] , $row["ROST_POSNAME_ACM"]);
                    $ROST_POSNAME_ACM =  str_replace(".".$arr_NRPT_ACM_OLD[0], "", $ROST_POSNAME_ACM);

                    $ROST_RANK = $row["ROST_RANK"];
                    $ROST_RANKNAME = $row["ROST_RANKNAME"];
                    $ROST_LAO_MAJ = $row["ROST_LAO_MAJ"];
                    $ROST_NCPOS12 = $row["ROST_NCPOS12"];
                    $ROST_ID = NULL;
                    $ROST_PARENT = substr( $new_unit_acm_id , 0 , 5).substr( $row["ROST_PARENT"] , 5 , 10);
                    $ROST_NUNIT = substr( $new_unit_acm_id , 0 , 5).substr( $row["ROST_NUNIT"] , 5 , 10);
                    $ROST_NPARENT = substr( $new_unit_acm_id , 0 , 5).substr( $row["ROST_NPARENT"] , 5 , 10);
                    $STATUS = $row["STATUS"];
                    $sql_insert_j3_rost = "INSERT INTO `j3_rost` 
                    (`ROST_UNIT`, `ROST_CPOS`, `ROST_POSNAME`, `ROST_POSNAME_ACM`, `ROST_RANK`, `ROST_RANKNAME`, `ROST_LAO_MAJ`, `ROST_NCPOS12`, `ROST_ID`, `ROST_PARENT`, `ROST_NUNIT`, `ROST_NPARENT`, `STATUS`) 
                    VALUES ('".$ROST_UNIT."', '".$ROST_CPOS."', '".$ROST_POSNAME."', '".$ROST_POSNAME_ACM."', '".$ROST_RANK."', '".$ROST_RANKNAME."', '".$ROST_LAO_MAJ."', '".$ROST_NCPOS12."', NULL, '".$ROST_PARENT."', '".$ROST_NUNIT."', '".$ROST_NPARENT."', '".$STATUS."')";
                    $result = mysqli_query($conn, $sql_insert_j3_rost);
                }
                // $sql_insert_j3_nrpt = "INSERT INTO `j3_nrpt` (`UNIT_CODE`, `NRPT_NAME`, `NRPT_ACM`, `NRPT_NUNIT`, `NRPT_NPAGE`, `NRPT_DMYUPD`, `NRPT_UNIT_PARENT`, `NRPT_USER`, `UNIT_ACM_ID`, `STATUS`) VALUES ('".$new_unit_acm_id."', '".$_POST["UNIT_NAME"]."', '".$_POST["UNIT_NAME_ACK"]."', '".$new_unit_acm_id."', '', current_timestamp(), '', '', '".$new_unit_acm_id."', '1')";
                // $res = mysqli_query($conn, $sql_insert_j3_nrpt);
                $sql_find_part_number = "SELECT PART_NUMBER  FROM `j3_part` WHERE PART_ID = '".$_POST["PART_ID"]."' ";
                $res = mysqli_query($conn, $sql_find_part_number);
                $result = mysqli_fetch_assoc($res);
                $PART_NUMBER = $result["PART_NUMBER"];
                $sql_update_main_j3_nrpt = "UPDATE `j3_nrpt` SET 
                 NRPT_NAME = '".$_POST["UNIT_NAME"]."'  ,
                 NRPT_ACM = '".$_POST["UNIT_NAME_ACK"]."'  ,
                 UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) ,
                NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) ,
                NRPT_UNIT_PARENT = '".$PART_NUMBER."' ,
                UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) 
                 WHERE UNIT_CODE LIKE '".$_POST["UNIT_CODE"]."'
                 ";
                //  echo json_encode($sql_update_main_j3_nrpt);
                $res = mysqli_query($conn, $sql_update_main_j3_nrpt);
                $sql_update_j3_nrpt = "UPDATE `j3_nrpt` SET
                NRPT_NAME = Replace(NRPT_NAME , '".$_POST["UNIT_NAME_OLD"]."', '".$_POST["UNIT_NAME"]."' ) ,
                NRPT_ACM = Replace(NRPT_ACM , '".$_POST["UNIT_NAME_ACK_OLD"]."', '".$_POST["UNIT_NAME_ACK"]."' ) ,
                UNIT_CODE = Replace(UNIT_CODE , Substring(UNIT_CODE, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) ,
                NRPT_NUNIT = Replace(NRPT_NUNIT , Substring(NRPT_NUNIT, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) ,
                NRPT_UNIT_PARENT = Replace(NRPT_UNIT_PARENT , Substring(NRPT_UNIT_PARENT, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) ,
                UNIT_ACM_ID = Replace(UNIT_ACM_ID , Substring(UNIT_ACM_ID, 1, 5), ".substr( $new_unit_acm_id , 0 , 5)." ) 
                WHERE SUBSTRING(NRPT_UNIT_PARENT, 1, 5) LIKE '".substr($_POST["UNIT_CODE"] , 0, 5)."'
                 ";
                 $res = mysqli_query($conn, $sql_update_j3_nrpt);

                 $sql_update_j3_nrpt = "UPDATE `j3_nrpt` SET
                NRPT_NAME = Replace(NRPT_NAME , '".$NRPT_NAME_OLD."', '' ) ,
                NRPT_ACM = Replace(NRPT_ACM , '.".$arr_NRPT_ACM_OLD[0]."', '' ) 
                WHERE SUBSTRING(UNIT_CODE, 1, 5) LIKE '".substr( $new_unit_acm_id , 0 , 5)."'
                 ";
                 $res = mysqli_query($conn, $sql_update_j3_nrpt);

                 
                
                $sql_insert_j3_ack = "INSERT INTO `j3_ack` (`ACK_NUM_ID`, `ACK_ID`, `ACK_MISSION`, 
                
                `ACK_DISTRIBUTION`, `ACK_ESSENCE`, `ACK_SCOPE`, `ACK_DIVISION`, `ACK_EXPLANATION`, 
                
                `ACK_SUMMARY`, `ACK_USER`, `ACK_NAME`, `UNIT_CODE`, `UNIT_NAME`, `UNIT_NAME_ACK`, 
                
                `UNIT_CODE_PARENT`, `ACK_TIMESTAMP`, `ACK_VERSION`, `UNIT_ACM_ID`, `UNIT_ACM_CREATE`) VALUES (NULL, '".$_POST
                
                ["ACK_ID"]."', '".$_POST["ACK_MISSION"]."', '".$_POST["ACK_DISTRIBUTION"]."', '".$_POST
                
                ["ACK_ESSENCE"]."', '".$_POST["ACK_SCOPE"]."', '".$_POST["ACK_DIVISION"]."', '".$_POST
                
                ["ACK_EXPLANATION"]."', '".$_POST["ACK_SUMMARY"]."', '', '".$_POST["ACK_NAME"]."',
                
                '".$new_unit_acm_id."', '".$_POST["UNIT_NAME"]."',
                
                '".$_POST["UNIT_NAME_ACK"]."', '".$new_unit_acm_id."',  current_timestamp(), '', '".$PART_NUMBER."', '".$_POST["UNIT_ACM_CREATE"]."' ) ";
                $res = mysqli_query($conn, $sql_insert_j3_ack);

                
                $sql_find_new_j3_ratepersonal =  "SELECT * FROM `j3_rost` WHERE ROST_NUNIT LIKE '".$new_unit_acm_id."' ";
                $res = mysqli_query($conn, $sql_find_new_j3_ratepersonal);
                while($row = mysqli_fetch_assoc($res)) {
                    $sql_insert_j3_ratepersonal = "INSERT INTO `j3_ratepersonal` (`RATE_P_NUM`, `ROST_CPOS`, `EXPERT_MIL_ID`, `RATE_P_REMARK` , `RATE_P_RANK`, `SALARY_ID`, `ACK_ID`, `RATE_P_VERSION`, `ROST_ID` , `RATE_P_NUMBER`) VALUES (NULL, '".$row["ROST_CPOS"]."', '', '', '".$row["ROST_RANK"]."', '', '".$_POST["ACK_ID"]."', '1', '".$row["ROST_ID"]."' , 1)";
                    $result = mysqli_query($conn, $sql_insert_j3_ratepersonal);
                    // echo json_encode($result);
                }

                echo json_encode('success');
                
                
            break;
        }
    }
?>