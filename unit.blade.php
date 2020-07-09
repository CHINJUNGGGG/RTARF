<?php
session_start();
include ('db/connectpdo.php');

$UNIT_CODE = $_GET['id'];

$sql = "SELECT * FROM j3_nrpt WHERE UNIT_CODE = :UNIT_CODE";
$stmt=$db->prepare($sql);
$stmt->bindparam(':UNIT_CODE',$UNIT_CODE);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
  $NRPT_NAME = $row['NRPT_NAME'];
  $NRPT_ACM = $row['NRPT_ACM'];
  $NRPT_UNIT_PARENT = $row['NRPT_UNIT_PARENT'];


$sql2 = "SELECT * FROM j3_nrpt WHERE UNIT_CODE = :NRPT_UNIT_PARENT";
$stmt2=$db->prepare($sql2);
$stmt2->bindparam(':NRPT_UNIT_PARENT',$NRPT_UNIT_PARENT);
$stmt2->execute();
$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
  $NRPT_NAME_2 = $row2['NRPT_NAME'];
  $NRPT_ACM = $row2['NRPT_ACM'];
  $NRPT_UNIT_PARENT_2 = $row2['NRPT_UNIT_PARENT'];

?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once __DIR__.'/path/head.php'; ?></head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper"><?php require_once __DIR__.'/path/navbar.php'; ?>
        <?php require_once __DIR__.'/path/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <!-- <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div>
                </div> -->
            </div>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">( <?=$NRPT_ACM?> ) - <?=$NRPT_NAME?> </h3>
                    </div>
                    <div class="card-body">
                        <table id="example3" class="table table-bordered table-striped">
                            <thead class="bg-secondary">
                                <tr>
                                    <th style="text-align: center;">หมายเลขหน่วย</th>
                                    <th style="text-align: center;">หมายเลขหน่วยหลัก</th>
                                    <th>นามหน่วย</th>
                                    <th>นามหน่วยย่อ</th>
                                    <th style="text-align: center;">จัดทำข้อมูล</th>
                                    <th><i class="fas fa-cogs nav-icon"></i></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $sql3 = "SELECT * FROM j3_nrpt WHERE UNIT_CODE = :UNIT_CODE OR NRPT_UNIT_PARENT = :UNIT_CODE AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900)";
                                //SUBSTRING(UNIT_CODE, 1, 4) LIKE '".substr($UNIT_CODE, 0, 4)."' AND SUBSTRING(UNIT_CODE, 7, 10) NOT IN (0001, 0002, 0003, 9999, 9998, 0900) AND SUBSTRING(NRPT_NUNIT, 1, 5) LIKE '".substr($UNIT_CODE, 0, 5)."' AND SUBSTRING(NRPT_UNIT_PARENT, 1, 1) LIKE '".substr($UNIT_CODE, 0, 1)."'";
                                $stmt3=$db->prepare($sql3);
                                $stmt3->bindparam(':UNIT_CODE',$UNIT_CODE);
                                $stmt3->execute();
                                while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
                                    $UNIT_CODE = $row3['UNIT_CODE'];
                                    $NRPT_NAME = $row3['NRPT_NAME'];
                                    $NRPT_ACM = $row3['NRPT_ACM'];
                                    $NRPT_NUNIT = $row3['NRPT_NUNIT'];
                                    $NRPT_NPAGE = $row3['NRPT_NPAGE'];
                                    $NRPT_DMYUPD = $row3['NRPT_DMYUPD'];
                                    $NRPT_UNIT_PARENT = $row3['NRPT_UNIT_PARENT'];
                                    $NRPT_USER = $row3['NRPT_USER'];
                                    $UNIT_ACM_ID = $rrow3ow['UNIT_ACM_ID'];

                            ?>

                                <tr>
                                    <td style="width: 160px; text-align: center;"><?=$UNIT_CODE?></td>
                                    <td style="width: 170px; text-align: center;"><?=$NRPT_UNIT_PARENT?></td>
                                    <td style="width: 500px;"><?=$NRPT_NAME?></td>
                                    <td style="width: 180px;"><?=$NRPT_ACM?></td>
                                    <td style="width: 130px; text-align: center;"> 
                                    <a class="btn btn-success btn-sm" href="create_ajy.php?id=<?=$UNIT_CODE;?>">
                                        อจย.
                                    </a>
                                    <a class="btn btn-warning btn-sm" href="create_ack.php?id=<?=$UNIT_CODE;?>">
                                        อฉก.
                                    </a>
                                    </td>
                                    <td style="width: 220px; text-align: center;">
                                    <a class="btn btn-primary btn-sm" href="unit.php?id=<?=$UNIT_CODE?>">
                                        <i class="fas fa-list"></i> UNIT
                                    </a>
                                    <a class="btn btn-info btn-sm" href="detail_ack.php?id=<?=$UNIT_CODE;?>&name=<?=$UNIT_CODE;?>&nickname=<?=$UNIT_CODE;?>&lastname=<?=$UNIT_CODE?>">
                                        <i class="fas fa-pencil-alt"></i> DETAIL
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="delete_data.php?UNIT_CODE=<?=$UNIT_CODE;?>&name=<?=$NRPT_UNIT_PARENT?>" onclick="return confirm('คุณต้องการลบรายการนี้ ใช่หรือไม่ ?')">
                                        <i class="fas fa-trash"></i> DELETE
                                    </a>
                                    </td>
                                </tr>
                            <?php } ?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once __DIR__.'/path/footer.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <?php require_once __DIR__.'/path/script.php'; ?>
</body>

</html>