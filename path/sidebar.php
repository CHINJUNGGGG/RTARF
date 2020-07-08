<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="image/rtarf.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">RTARF</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-child-indent nav-compact flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">โครงสร้างการจัดหน่วย</li>
                <?php

                include ('db/connectpdo.php');
                            
                    $sql = "SELECT * FROM j3_part" ;
                    $stmt=$db->prepare($sql);
                    $stmt->execute();
                                       
                    while($row1=$stmt->fetch(PDO::FETCH_ASSOC)){
                        $UNIT =$row1['PART_ID'];
                        echo '<li class="nav-item has-treeview">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>
                                        '. $row1['PART_NAME'] .'
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>';
                                        
                        $sql2 = "SELECT * FROM j3_unit_acm WHERE PART_ID = :UNIT ORDER BY SORT ASC" ;
                        $stmt2=$db->prepare($sql2);
                        $stmt2->bindparam(':UNIT',$UNIT);
                        $stmt2->execute();

                        echo '<ul class="nav nav-treeview">';
                            while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                                if($row2['PART_ID'] == $UNIT){
                                    $UNIT2 = $row2['UNIT_ACM_ID'];
                                    echo '<li class="nav-item has-treeview">
                                            <a href="#" class="nav-link active">
                                                <i class="fas fa-plus-circle nav-icon"></i>
                                                <p>'. $row2['UNIT_ACM_NAME'] .'</p>
                                            </a>';
                                    $sql3 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT2 ORDER BY SORT ASC";
                                    $stmt3=$db->prepare($sql3);
                                    $stmt3->bindparam(':UNIT2',$UNIT2);
                                    //$stmt3->bindparam(':UNIT_CODE',$UNIT_CODE);
                                    $stmt3->execute();
                                    $row3=$stmt3->fetch(PDO::FETCH_ASSOC);
                                    //echo '<ul class="nav nav-treeview">';
                                    if($row3['NRPT_UNIT_PARENT'] == $UNIT2){
                                        echo '<ul class="nav nav-treeview">
                                                <li class="nav-item has-treeview">
                                                    <a href="unit.blade.php?id='.$UNIT2.'" class="nav-link active">
                 
                                                        <p>แสดงทั้งหมด</p>
                                                    </a>
                                                </li>';
                                        $stmt3->execute();
                                        while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
                                            $SUB1 = substr($row3['UNIT_CODE'],6);
                                            if($SUB1 != "0001" && $SUB1 != "0002" && $SUB1 != "0003" && $SUB1 != "9999" && $SUB1 != "9998"  && $SUB1 != "0900"){
                                                if($row3['NRPT_UNIT_PARENT'] == $UNIT2){
                                                    $UNIT3 = $row3['UNIT_CODE'];
                                                    //echo $UNIT3;
                                                    echo '<li class="nav-item">
                                                            <a href="unit.blade.php?id='.$UNIT3.'" class="nav-link active">
                                                                <i class="fas fa-plus-circle nav-icon"></i>
                                                                <p>'. $row3['NRPT_ACM'] .'</p>
                                                            </a>';
                                                    $sql4 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT3" ;
                                                    $stmt4=$db->prepare($sql4);
                                                    $stmt4->bindparam(':UNIT3',$UNIT3);
                                                    $stmt4->execute();
                                                    $row4=$stmt4->fetch(PDO::FETCH_ASSOC);

                                                        //echo '<ul class="nav nav-treeview">';
                                                    if($row4['NRPT_UNIT_PARENT'] == $UNIT3){
                                                        echo '<ul class="nav nav-treeview">
                                                                <li class="nav-item has-treeview">
                                                                    <a href="unit.blade.php?id='.$UNIT3.'" class="nav-link active">
              
                                                                        <p>แสดงทั้งหมด</p>
                                                                    </a>
                                                                </li>';
                                                        $stmt4->execute();
                                                        while($row4=$stmt4->fetch(PDO::FETCH_ASSOC)){
                                                            $SUB2 = substr($row4['UNIT_CODE'],6);
                                                            if($SUB2 != "0001" && $SUB2 != "0002" && $SUB2 != "0003" && $SUB2 != "9999" && $SUB2 != "9998"  && $SUB2 != "0900"){
                                                                if($row4['NRPT_UNIT_PARENT'] == $UNIT3){
                                                                    $UNIT4 = $row4['UNIT_CODE'];
                                                                    echo '<li class="nav-item">
                                                                            <a href="unit.blade.php?id='.$UNIT4.'" class="nav-link active">
                                                                                <i class="fas fa-plus-circle nav-icon"></i>
                                                                                <p>'. $row4['NRPT_ACM'] .'</p>
                                                                            </a>';
                                                                    $sql5 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT4" ;
                                                                    $stmt5=$db->prepare($sql5);
                                                                    $stmt5->bindparam(':UNIT4',$UNIT4);
                                                                    $stmt5->execute();
                                                                    $row5=$stmt5->fetch(PDO::FETCH_ASSOC);

                                                                    //echo '<ul class="nav nav-treeview">';
                                                                    if($row5['NRPT_UNIT_PARENT'] == $UNIT4){
                                                                        echo '<ul class="nav nav-treeview">
                                                                                <li class="nav-item has-treeview">
                                                                                    <a href="unit.blade.php?id='.$UNIT4.'" class="nav-link active">
                            
                                                                                        <p>แสดงทั้งหมด</p>
                                                                                    </a>
                                                                                </li>';
                                                                        $stmt5->execute();
                                                                        while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                                            $SUB3 = substr($row3['UNIT_CODE'],6);
                                                                            if($SUB3 != "0001" && $SUB3 != "0002" && $SUB3 != "0003" && $SUB3 != "9999" && $SUB3 != "9998"  && $SUB3 != "0900"){
                                                                                if($row5['NRPT_UNIT_PARENT'] == $UNIT4){
                                                                                    $UNIT5 = $row5['UNIT_CODE'];
                                                                                    echo '<li class="nav-item">
                                                                                            <a href="unit.blade.php?id='.$UNIT5.'" class="nav-link active">
                                                                                                <i class="fas fa-minus-circle nav-icon"></i>
                                                                                                <p>'. $row5['NRPT_ACM'] .'</p>
                                                                                            </a>';
                                                                                    $sql6 = "SELECT * FROM j3_nrpt WHERE NRPT_UNIT_PARENT = :UNIT5" ;
                                                                                    $stmt6=$db->prepare($sql6);
                                                                                    $stmt6->bindparam(':UNIT5',$UNIT5);
                                                                                    $stmt6->execute();
                                                                                    $row6=$stmt6->fetch(PDO::FETCH_ASSOC);

                                                                                    if($row6['NRPT_UNIT_PARENT'] == $UNIT5){
                                                                                        echo '<ul class="nav nav-treeview">
                                                                                                <li class="nav-item has-treeview">
                                                                                                    <a href="unit.blade.php?id='.$UNIT5.'" class="nav-link active">
                              
                                                                                                        <p>แสดงทั้งหมด</p>
                                                                                                    </a>
                                                                                                </li>';
                                                                                        $stmt6->execute();
                                                                                        while($row6=$stmt6->fetch(PDO::FETCH_ASSOC)){
                                                                                            if($row6['NRPT_UNIT_PARENT'] == $UNIT5){
                                                                                                $UNIT6 = $row6['UNIT_CODE'];
                                                                                                echo '<li class="nav-item">
                                                                                                        <a href="unit.blade.php?id='.$UNIT6.'" class="nav-link active">
                                                                                                            <i class="fas fa-minus-circle nav-icon"></i>
                                                                                                            <p>'. $row6['NRPT_ACM'] .'</p>
                                                                                                        </a>
                                                                                                    </li>';
                                                                                            }
                                                                                        }
                                                                                        echo '</ul>';
                                                                                    }
                                                                                    echo '</li>';
                                                                                }
                                                                            }
                                                                        }
                                                                        echo '</ul>';
                                                                    }
                                                                    echo '</li>';
                                                                }
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    }
                                                    echo '</li>';
                                                }
                                            }
                                        }
                                        echo '</ul>';
                                    }
                                    echo '</li>';
                                }
                            }
                        echo '</ul>
                        </li>';
                    }
                ?>
                <li class="nav-header">การจัดทำข้อมูล</li>
                <li class="nav-item has-treeview active">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>
                            หมายเลข อจย./อฉก.
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="read_ajy.php" class="nav-link active">
                                <i class="fas fa-flag nav-icon"></i>
                                <p>อัตราการจัดยุทโธปกรณ์</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="read_ack.php" class="nav-link active">
                                <i class="fas fa-flag nav-icon"></i>
                                <p>อัตราการจัดเฉพาะกิจ</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
var url = window.location;

$('ul.nav-sidebar a').filter(function() {
    return this.href == url;
}).addClass('active');


$('ul.nav-treeview a').filter(function() {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>
