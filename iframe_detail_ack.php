<?php

include ('db/connectpdo.php');
$UNIT_CODE = $_GET['id'];
$UNIT_CODE_1 = $_GET['name'];
$UNIT_CODE_2 = $_GET['nickname'];
$UNIT_CODE_3 = $_GET['lastname'];

$sql3 = "SELECT COUNT(ROST_POSNAME) as count FROM j3_rost GROUP BY ROST_POSNAME_ACM";
$stmt3=$db->prepare($sql3);
//$stmt3->bindparam(':ID',$ID);
$stmt3->execute();
//$row3=$stmt3->fetch(PDO::FETCH_ASSOC);
while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
  $ROST_COUNT = $row3['count'];
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>    
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead class="bg-primary">                                                        
        <tr>
          <th style="text-align: center;">ลำดับ</th>
          <th>ชื่อตำแหน่ง</th>
          <th>ตำแหน่งย่อ</th>
          <th style="text-align: center;">ยศอัตรา</th>
          <th style="text-align: center;">รหัสเลขที่ตำแหน่ง</th>
          <!-- <th style="text-align: center;">Manage</th> -->
        </tr>
      </thead>
      <tbody>
        <?php

        
        $sql2 = "SELECT * FROM j3_rost 
        WHERE ROST_NPARENT = :UNIT_CODE OR ROST_NUNIT = :UNIT_CODE_1 OR ROST_UNIT = :UNIT_CODE_2 OR ROST_PARENT = :UNIT_CODE_3
        ORDER BY ROST_ID";
        $stmt2=$db->prepare($sql2);
        $stmt2->bindparam(':UNIT_CODE',$UNIT_CODE);
        $stmt2->bindparam(':UNIT_CODE_1',$UNIT_CODE_1);
        $stmt2->bindparam(':UNIT_CODE_2',$UNIT_CODE_2);
        $stmt2->bindparam(':UNIT_CODE_3',$UNIT_CODE_3);
        $stmt2->execute();

        $i = 0;

        while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
          $i++;
          //$COUNT = $row2['COUNT(ROST_ID)'];
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

          $sql4 = "SELECT ROST_RANKNAME FROM j1_rank WHERE ROST_RANK = :ROST_RANK";
          $stmt4=$db->prepare($sql4);
          $stmt4->bindparam(':ROST_RANK',$ROST_RANK);
          $stmt4->execute();
          $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
            $ROST_RANKNAME_REAL = $row4['ROST_RANKNAME'];
                          ?>
                          <tr>
                            <td style="width: 20px; text-align: center;"><?=$i?></td>
                            <td style="width: 400px;"><?=$ROST_POSNAME?></td>
                            <td style="width: 350px;"><?=$ROST_POSNAME_ACM?></td>
                            <td style="width: 100px;"><?=$ROST_RANKNAME_REAL?></td>
                            <td style="width: 150px; text-align: center;"><?=$ROST_NCPOS12?></td>
                            <!-- <td style="width: 50px; text-align: center;">        
                              <div class="table-actions">
                                <button type="button" id="link_modal" data-toggle="modal" data-target="#EditModal" data-id="<?=$ROST_ID;?>" class="btn btn-success btn-sm editbtn"><i class="fas fa-pencil-alt"></i></button></a>
                                <a href='unit_structure_01.php?id=<?=$UNIT_CODE;?>'><button type="button" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-ban"></i></button></a>
                              </div>
                            </td> -->
                      

                          </tr>
                       <?php } ?>                                                              
                      </tbody>
                    </table>
                  </div>

                  <script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
                </body>
                </html>