<?php  
include ('db/connect.php');
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $sql = "SELECT * FROM j3_cpos WHERE ROST_CPOS_NAME LIKE '%".$_POST["query"]."%'";  
      $result = mysqli_query($conn, $sql);  
      $output = '<ul class="list-unstyled">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '<li class="form-control form-control-inverse form-main"  attr-rost-cpos-acm="'.$row["ROST_CPOS_ACM"].'" attr-rost-cpos="'.$row["ROST_CPOS"].'" >'.$row["ROST_CPOS_NAME"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li>No Data</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
     if(isset($_POST["query_d"]))
     {
          $output = '';
          $sql = "SELECT * FROM j3_division WHERE D_NAME LIKE '%".$_POST["query_d"]."%'";
          $result = mysqli_query($conn, $sql);
          $output = '<ul class="list-unstyled">';
          if(mysqli_num_rows($result) > 0)
          {
               while($row = mysqli_fetch_array($result))
               {
                    $output .= '<li class="form-control form-control-inverse" attr-d_id_2="'.$row["D_ID"].'">'.$row['D_ID'].'&nbsp;'.$row["D_NAME"].'</li>';
               }
          }
          else
          {
               $output .= '<li>No Data</li>';
          }
          $output .= '</ul>';
          echo $output;
     }
     if(isset($_POST["query_a"]))
     {
          $output = '';
          $sql = "SELECT * FROM j3_division WHERE D_NAME LIKE '%".$_POST["query_a"]."%'";
          $result = mysqli_query($conn, $sql);
          $output = '<ul class="list-unstyled">';
          if(mysqli_num_rows($result) > 0)
          {
               while($row = mysqli_fetch_array($result))
               {
                    $output .= '<li class="form-control form-control-inverse" attr-d_id_1="'.$row["D_ID"].'">'.$row['D_ID'].'&nbsp;'.$row["D_NAME"].'</li>';
               }
          }
          else
          {
               $output .= '<li>No Data</li>';
          }
          $output .= '</ul>';
          echo $output;
     }
     if(isset($_POST["do"])){
          $do = $_POST["do"];
          switch ($do) {
               case 'get_NRPT_NAME':
                    $sql_find_NRPT_NAME = "SELECT * FROM `j3_nrpt_approve` WHERE UNIT_CODE = '".$_POST["ROST_NPARENT"]."' ";
                    $res = mysqli_query($conn, $sql_find_NRPT_NAME);
                    $result = mysqli_fetch_assoc($res);
                    // $NRPT_NAME = $result["NRPT_NAME"];
                    echo json_encode($result);
               break;
          }
     }
 ?>  