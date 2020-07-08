<?php include 'db/connect.php';?>

<form class="moveStructure">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="PART_ID">ส่วนบังคับบัญชา</label>
      <select id="PART_ID" name="PART_ID" class="form-control">
        <option value="">กรุณาเลือก...</option>
        <?php
        include ('db/connect.php');
        $sql = "SELECT * FROM j3_part WHERE 1";
        $res = mysqli_query($conn, $sql);
        while($row= mysqli_fetch_assoc($res)) {
          echo '<option value="'.$row['PART_ID'].'"  >'.$row['PART_NAME'].'</option>';
        }
        ?>
      </select>
    </div>
    <!--<div class="form-group col-md-12">
      <label for="UNIT_ACM_ID">สำนัก</label>
      <select id="UNIT_ACM_ID"  name="UNIT_ACM_ID" class="form-control" required>
        <option value="">กรุณาเลือก...</option>
      </select>
    </div>-->
  </div>
  <div class="form-group col-md-12">
    <label for="UNIT_ACM_ID">ลำดับ</label>
    <input type="text" class="form-control" name="index" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
  </div>
</div>
<input type="hidden" name="UNIT_CODE" value="<?php echo $_POST["unit_code"] ?>">
<button type="submit" class="btn btn-sm btn-primary float-right">ประมวลผลย้ายโครงสร้าง</button>
</form>

<script>
  $('select[name="PART_ID"]').on('change', function () {
   $.ajax({
     type: "POST",
     url: "unit_structure_query.php",
     data: {PART_ID : $(this).val() , do:'get_j3_unit_acm'},
     dataType: "json",
     success: function (response) {
      $('#UNIT_ACM_ID').html($("<option>กรุณาเลือก...</option>"));
      $.each(response, function (indexInArray, valueOfElement) { 
        console.log(valueOfElement)
        $('#UNIT_ACM_ID').append($("<option></option>")
          .attr("value",valueOfElement["UNIT_ACM_ID"])
          .text(valueOfElement["UNIT_ACM_NAME"])); 

      });
    }
  });
 });
  $("form.moveStructure").submit(function (e) { 
    var formdata = $(this).serialize() +"&"+$('form[action="ct_create_ack.php"]').serialize()
    e.preventDefault();
    if (confirm('คุณต้องการประมวลผลย้ายโครงสร้าง ?')) {
      var modalBody  = $(this).parent()
      var spinner = `
      <div class="spinner-border text-secondary" role="status">
      <span class="sr-only">Loading...</span>
      </div>
      `
      modalBody.empty()
      modalBody.html(spinner).addClass('text-center')
      $.ajax({
        type: "POST",
        url: "unit_structure_query.php",
        data: formdata+"&do=process",
        // dataType: "json",
        success: function (response) {
          console.log(response)
          alert('ย้ายโครงสร้างเรียบร้อยแล้ว')
          location.reload();
        //   $.ajax({
        //     type: "POST",
        //     url: "ct_create_ack.php",
        //     data: $('form[action="ct_create_ack.php"]').serialize() ,
        //     // dataType: "dataType",
        //     success: function (response) {
        //      console.log(response)
        //     //  alert('ย้ายโครงสร้างเรียบร้อยแล้ว')
        //     //  location.reload();
        //    }
        //  });
        }
      });

    }
    
  });
</script>