<?php

include ('db/connectpdo.php');

$date = date_create();
$now = date_create()->format('Y-m-d H:i:s');
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
            <tr class="table">
              <th>เลขประจำยุทโธปกรณ์</th>
              <th>ชื่อยุทโธปกรณ์</th>
              <th>รหัส สป.</th>
              <th>อัตรา</th>
              <th>หน่วยงาน</th>
              <th>จัดการ</th>
          </tr>
      </thead>
      <tbody>
         <?php

         $sql2 = "SELECT * FROM j3_rateitem";
         $stmt2=$db->prepare($sql2);
         $stmt2->execute();
         while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
            $RATE_I_NUM = $row2['RATE_I_NUM'];
            $ACK_ID = $row2['ACK_ID'];
            $RATE_I_NUM_POS = $row2['RATE_I_NUM_POS'];
            $NSN_ID = $row2['NSN_ID'];
            $NSN_NAME = $row2['NSN_NAME'];
            $RATE_I_TOTAL = $row2['RATE_I_TOTAL'];
            $RATE_I_REMARK = $row2['RATE_I_REMARK'];
            $P_ID = $row2['P_ID'];
            $RATE_I_UPD_DATE = $row2['RATE_I_UPD_DATE'];
            $RATE_I_DEPARTMENT = $row2['RATE_I_DEPARTMENT'];


            ?>
            <tr>
              <td style="width: 180px; text-align: center;"><?=$RATE_I_NUM_POS?></td>
              <td><?=$NSN_NAME?></td>
              <td><?=$NSN_ID?></td>
              <td style="width: 40px; text-align: center;"><?=$RATE_I_TOTAL?></td>
              <td><?=$RATE_I_DEPARTMENT?></td>
              <td style="width: 40px; text-align: center;" valign="middle">
                <div class="table-actions">
                  <button type="button" id="link_modal" data-toggle="modal" data-target="#EditModal" data-id="<?=$ROST_ID;?>" class="btn btn-success btn-sm editbtn"><i class="fas fa-pencil-alt"></i></button></a>
                  <a href='delete_data.php?id=<?=$RATE_I_NUM;?>'><button type="button" class="btn btn-danger btn-sm btntrash"><i class="fas fa-trash-alt"></i></button></a>
              </div>
          </td>
      </tr>                                                           
  </tbody>
<?php } ?>  
</table>
</div>

<?php
include ('path/script.php');
?>
</body>
</html>