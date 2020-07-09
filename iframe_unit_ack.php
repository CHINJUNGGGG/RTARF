<?php

include ('db/connectpdo.php');
$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];
$ACK_VERSION = $_GET['id5']


?>


<!DOCTYPE html>
<html>
<head>
    <?php
    include ('path/head.php');
    ?>
</head>
<body>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead class="bg-primary">                                                        
                <tr>
                    <th style="text-align: center;">รหัสตำแหน่ง</th>
                    <th style="text-align: center;">ชื่อตำแหน่ง</th>
                    <th style="text-align: center;">เลขกรมบัญชีกลาง</th>
                    <th style="text-align: center;">อัตรา</th>
                    <th style="text-align: center; width: 80px;">เหล่า</th>
                    <th style="text-align: center;">สายวิทยาการ</th>
                    <th style="text-align: center;">กลุ่มงาน</th>
                    <!-- <th style="text-align: center;">หมายเหตุ</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
              

                $sql2 = "SELECT *,COUNT(ROST_ID) FROM j3_rost 
                WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE OR ROST_UNIT = :UNIT_CODE OR ROST_PARENT = :UNIT_CODE
                GROUP BY ROST_RANK ORDER BY ROST_ID";
                $stmt2=$db->prepare($sql2);
                $stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
                // $stmt2->bindparam(':UNIT_CODE_1',$UNIT_CODE_1);
                // $stmt2->bindparam(':UNIT_CODE_2',$UNIT_CODE_2);
                // $stmt2->bindparam(':UNIT_CODE_3',$UNIT_CODE_3);
                $stmt2->execute();

                $i = 0;

                while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                    $i++;
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

                    $ROST_POSNAME = explode(' ', $row2['ROST_POSNAME']);
                    $ROST_POSNAME = $ROST_POSNAME[0];

                    $SUB = substr($ROST_CPOS,0,5);

                    // $sql4 = "SELECT LAO_NAME FROM j3_lao WHERE ID = :LAO_ID";
                    // $stmt4=$db->prepare($sql4);
                    // $stmt4->bindparam(':LAO_ID',$LAO_ID);
                    // $stmt4->execute();
                    // $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
                    // $LAO_NAME = $row4['LAO_NAME'];  

                    // $sql5 = "SELECT D_NAME FROM j3_division WHERE D_ID = :D_ID";
                    // $stmt5=$db->prepare($sql5);
                    // $stmt5->bindparam(':D_ID',$D_ID);
                    // $stmt5->execute();
                    // $row5=$stmt5->fetch(PDO::FETCH_ASSOC);
                    // $D_NAME = $row5['D_NAME'];      


                    ?>
                    <tr>
                        <td style="width: 20px; text-align: center;"><?=$SUB;?></td>
                        <td style="width: 250px;"><?=$ROST_POSNAME;?></td>
                        <td style="width: 120px; text-align: center;"><?=$ROST_NCPOS12;?></td>
                        <td style="width: 15px; text-align: center;"><?=$COUNT;?></td>
                        <td style="width: 50px; text-align: center;"><?=$ROST_LAO_MAJ;?></td>
                        <td style="width: 150px; text-align: center;"><?=$LAO_NAME;?></td>
                        <td style="width: 150px; text-align: center;"><?=$D_NAME;?></td>
                        <!-- <td style="width: 20px; text-align: center;">
                            <div class="table-actions">
                                <a href='delete_rate_p.php?id=<?=$RATE_P_NUM;?>&id1=<?=$UNIT_CODE_1?>' onclick="return confirm('คุณต้องการลบรายการนี้ ใช่หรือไม่ ?')"><button type="button" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-ban"></i></button></a>
                            </div>
                        </td> -->
                    </tr>
                <?php }?>                                                         
            </tbody>
        </table>
    </div>
</tbody>
</table>
</div>
<?php
include ('path/script.php');
?>
</body>
</html>