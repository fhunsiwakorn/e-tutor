<?php
$search = isset($_GET["q"]) ?  $_GET["q"] : NULL;
$page = isset($_GET["page"]) ?  $_GET["page"] : 1;
?>
<style type="text/css">
  #outerdiv {
    width: 200px;
    height: 150px;
    overflow: hidden;
    position: relative;
  }

  #inneriframe {
    position: absolute;
    top: -70px;
    left: 2px;
    width: 300px;
    height: 600px;
  }
</style>
<?php

$reference = random_password(7);
if (isset($_POST['btn_primary'])) {
  try {
    if (empty($_POST['ran'])) {
      $ran = '0';
    } elseif (!empty($_POST['ran'])) {
      $ran = '1';
    }
    $dateC = date("Y-m-d");
    ///โจทย์
    $qus = 'INSERT INTO exam_question(question_name,question_sound,answer,reference,random_status,type_choice,type_id)
       VALUES (:question_name,:question_sound,:answer,:reference,:random_status,:type_choice,:type_id)';
    $extc = $connSystem->prepare($qus);
    $extc->execute(
      array(
        ':question_name' => $_POST['question_name'],
        ':question_sound' => $_POST['question_sound'],
        ':answer' => $_POST['answer'],
        ':reference' => $reference,
        ':random_status' => $ran,
        ':type_choice' =>  $_POST['type_choice'],
        ':type_id' => $_POST['type_id']

      )
    );
    ///ตัวเลือกที่ 1
    $cq1 = 'INSERT INTO exam_choice(choice_order,choice_name,choice_sound,reference,type_id)
       VALUES (:choice_order_1,:choice_name_1,:choice_sound_1,:reference,:type_id)';
    $extc = $connSystem->prepare($cq1);
    $extc->execute(
      array(
        ':choice_order_1' => 1,
        ':choice_name_1' => $_POST['choice_name_1'],
        ':choice_sound_1' => $_POST['choice_sound_1'],
        ':reference' => $reference,
        ':type_id' => $_POST['type_id']

      )
    );
    ///ตัวเลือกที่ 2
    $cq2 = 'INSERT INTO exam_choice(choice_order,choice_name,choice_sound,reference,type_id)
       VALUES (:choice_order_2,:choice_name_2,:choice_sound_2,:reference,:type_id)';
    $extc = $connSystem->prepare($cq2);
    $extc->execute(
      array(
        ':choice_order_2' => 2,
        ':choice_name_2' => $_POST['choice_name_2'],
        ':choice_sound_2' => $_POST['choice_sound_2'],
        ':reference' => $reference,
        ':type_id' => $_POST['type_id']

      )
    );
    ///ตัวเลือกที่ 3
    $cq3 = 'INSERT INTO exam_choice(choice_order,choice_name,choice_sound,reference,type_id)
       VALUES (:choice_order_3,:choice_name_3,:choice_sound_3,:reference,:type_id)';
    $extc = $connSystem->prepare($cq3);
    $extc->execute(
      array(
        ':choice_order_3' => 3,
        ':choice_name_3' => $_POST['choice_name_3'],
        ':choice_sound_3' => $_POST['choice_sound_3'],
        ':reference' => $reference,
        ':type_id' => $_POST['type_id']

      )
    );
    ///ตัวเลือกที่ 4
    $cq4 = 'INSERT INTO exam_choice(choice_order,choice_name,choice_sound,reference,type_id)
       VALUES (:choice_order_4,:choice_name_4,:choice_sound_4,:reference,:type_id)';
    $extc = $connSystem->prepare($cq4);
    $extc->execute(
      array(
        ':choice_order_4' => 4,
        ':choice_name_4' => $_POST['choice_name_4'],
        ':choice_sound_4' => $_POST['choice_sound_4'],
        ':reference' => $reference,
        ':type_id' => $_POST['type_id']

      )
    );
    //Update วันที่หลักสูตร
    $q = "UPDATE exam_type SET type_date=:type_date_edit  WHERE type_id=:type_id_edit";
    $sth = $connSystem->prepare($q);
    $sth->execute(
      array(
        ':type_id_edit' => $_POST['type_id'],
        ':type_date_edit' => $dateC
      )
    );
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  $type_id_edit = $_POST['type_id'];
  $tc = $_POST['type_choice'];
  echo "<script>";
  echo "location.href = 'dashboard_admin?option=exam-data&exce=$type_id_edit&tc=$tc&success'";
  echo "</script>";
}
//Deleate
if (isset($_GET['referenceDE'])) {
  try {
    $qd = "DELETE FROM exam_question  WHERE reference=:reference_d AND type_id=:type_id_d";
    $sth = $connSystem->prepare($qd);
    $sth->execute(
      array(
        ':reference_d' => $_GET['referenceDE'],
        ':type_id_d' => $_GET['exce']
      )
    );
    $cd = "DELETE FROM exam_choice  WHERE reference=:reference_d AND type_id=:type_id_d";
    $cdd = $connSystem->prepare($cd);
    $cdd->execute(
      array(
        ':reference_d' => $_GET['referenceDE'],
        ':type_id_d' => $_GET['exce']
      )
    );
    //  echo "<script>";
    //  echo "location.href = 'dashboard?option=student-data&success-d'";
    //  echo "</script>";

  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
?>

<?php
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param' => $_GET['exce']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

?>
<?php
if (isset($_GET['success'])) {
?>
  <script>
    swal("บันทึกข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
  </script>
<?php } ?>

<div class="nav-tabs-custom">
  <ul class="nav nav-tabs pull-right">
    <li><a href="#tab_1-1" data-toggle="tab">แบบฟอร์มเพิ่มข้อสอบ</a></li>
    <li class="active"><a href="#tab_2-2" data-toggle="tab">ข้อสอบ</a></li>
    <li class="pull-left header"><i class="fa fa-th"></i> ข้อสอบหลักสูตร : <?php echo $rowEXType['type_name']; ?></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane" id="tab_1-1">

      <div class="row">
        <div class="col-xs-12">
          <!-- interactive chart -->
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="glyphicon glyphicon-book"></i>

              <h3 class="box-title">โจทย์ - คำถาม</h3>

            </div>
            <form method="post" name="exam" id="exam">
              <input type="hidden" name="type_id" value="<?php echo $_GET['exce']; ?>">
              <div class="box-body">
                <div class="col-xs-12">
                  <label>เสียงบรรยายโจทย์ (Path URL)</label>
                  <input type="text" class="form-control" name="question_sound" placeholder="ใส่ Path URL เสียงบรรยายโจทย์" value="">
                </div>
                <br>
                <hr><br>
                <div class="col-xs-12">
                  <textarea name="question_name" id="editor" cols="70" rows="5" class="ckeditor" required></textarea>
                </div>
              </div>
              <!-- /.box-body-->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
          <!-- Line chart -->
          <div class="box box-default">
            <div class="box-header with-border">


              <h3 class="box-title">1.</h3>

            </div>

            <div class="box-body">
              <div class="col-xs-12">
                <label>เสียงบรรยายตัวเลือก (Path URL)</label>
                <input type="text" class="form-control" name="choice_sound_1" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="">
              </div>
              <br>
              <hr><br>
              <div class="col-xs-12">
                <textarea name="choice_name_1" id="editor" cols="70" rows="5" class="ckeditor" required></textarea>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->


          <div class="box box-default">
            <div class="box-header with-border">


              <h3 class="box-title">2.</h3>

            </div>
            <div class="box-body">
              <div class="col-xs-12">
                <label>เสียงบรรยายตัวเลือก (Path URL)</label>
                <input type="text" class="form-control" name="choice_sound_2" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="">
              </div>
              <br>
              <hr><br>
              <div class="col-xs-12">
                <textarea name="choice_name_2" id="editor2" cols="70" rows="5" class="ckeditor" required></textarea>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->

        <div class="col-md-6">
          <!-- Bar chart -->
          <div class="box box-default">
            <div class="box-header with-border">


              <h3 class="box-title">3.</h3>

            </div>
            <div class="box-body">
              <div class="col-xs-12">
                <label>เสียงบรรยายตัวเลือก (Path URL)</label>
                <input type="text" class="form-control" name="choice_sound_3" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="">
              </div>
              <br>
              <hr><br>
              <div class="col-xs-12">
                <textarea name="choice_name_3" id="editor3" cols="70" rows="5" class="ckeditor" required></textarea>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->

          <!-- Donut chart -->
          <div class="box box-default">
            <div class="box-header with-border">

              <h3 class="box-title">4.</h3>
            </div>
            <div class="box-body">
              <div class="col-xs-12">
                <label>เสียงบรรยายตัวเลือก (Path URL)</label>
                <input type="text" class="form-control" name="choice_sound_4" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="">
              </div>
              <br>
              <hr><br>
              <div class="col-xs-12">
                <textarea name="choice_name_4" id="editor4" cols="70" rows="5" class="ckeditor" required></textarea>
              </div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <div class="box box-default">
        <div class="box-header with-border">

          <h3 class="box-title">จัดการเฉลย</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label>เลือกประเภทตัวเลือก</label>
            <select class="form-control" name="type_choice" style="width:300px">
              <?php
              if (isset($_GET['tc']) && !empty($_GET['tc'])) {
                if ($_GET['type_choice'] == '1') {
                  echo '<option value="1">ก. ข. ค. ง.</option>';
                } elseif ($_GET['tc'] == '2') {
                  echo '<option value="2">A B C D</option>';
                }
              }
              ?>
              <option value="1">ก. ข. ค. ง.</option>
              <option value="2">A B C D</option>


            </select>
          </div>

          <div class="form-group">
            <label>เลือกเฉลย</label>
            <select class="form-control" name="answer" style="width:300px" required>
              <option value="">-- เลือกเฉลย --</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>

            </select>
          </div>

          <hr>
          <div class="form-group">
            <div class="checkbox">
              <label style="font-size: 1em">
                <input type="checkbox" value="1" name="ran" checked="checked">
                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                สุ่มตัวเลือก (Random Choice)
              </label>

            </div>
          </div>
        </div>

      </div>

      <br>
      <center><input type="submit" style="background-color:<?= $theme_color ?>;" name="btn_primary" class="btn btn-success" value="บันทึกข้อมูล" /></center>
      </form>

    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane active" id="tab_2-2">
      <!-- iframe เสียง -->

      <?php

      ////แบ่งหน้า
      $type_id = $_GET['exce'];

      $total_data = $connSystem->query("SELECT count(*) from exam_question WHERE  question_name LIKE '%$search%' AND type_id='$type_id'")->fetchColumn();


      //echo "$examRows ";

      $rows = '1';
      if ($page <= 0) $page = 1;
      $total_page = ceil($total_data / $rows);
      if ($page >= $total_page) $page = $total_page;
      $start = ($page - 1) * $rows;

      ?>


      <!-- <div class="box box-default"> -->
      <div align="center">
        <div class="box-header with-border">
          <span class="box-title">
            <div class="box-tools">
              <form method="get" name="supage1">
                <nav aria-label="...">
                  <input type="hidden" name="option" value="exam-data">
                  <input type="hidden" name="exce" value="<?php echo $_GET['exce']; ?>">
                  <!-- <input type="hidden" name="page"  value="<?= $page ?>"> -->
                  <ul class="pager">
                    <li <?php if ($page == 1) {
                          echo "class='disabled'";
                        } ?>><a href="dashboard_admin?option=exam-data&exce=<?= $type_id ?>&page=<?= $page - 1 ?>&q=<?= $search ?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                    <li><input type="number" name="page" style="width:60px; height:30px;font-size:20px;text-align: center;" value="<?= $page ?>" onchange="submit();"></li>
                    <li><input type="text" name="totalPage" style="width:50px; height:30px;font-size:20px;text-align: center;" value="<?= $total_data ?>" disabled></li>
                    <li <?php if ($page == $total_page) {
                          echo "class='disabled'";
                        } ?>><a href="dashboard_admin?option=exam-data&exce=<?= $type_id ?>&page=<?= $page + 1 ?>&q=<?= $search ?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                  </ul>
                </nav>
              </form>
              <!-- box-tools -->

            </div>
          </span>
        </div>
        <br><br><br>

        <div class="box-body">
          <div class="box-body table-responsive no-padding">


            <div class="col-xs-4">

              <form action="#" method="get" name="form1" autocomplete="off">
                <input type="hidden" name="option" id="option" value="<?= $_GET["option"] ?>">
                <input type="hidden" name="option" id="option" value="<?= $_GET["option"] ?>">
                <input type="hidden" name="exce" id="exce" value="<?= $_GET["exce"] ?>">
                <div class="input-group">
                  <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหาข้อสอบ..." value="<?= $search ?>">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-flat"><i class="glyphicon glyphicon-search"></i>
                    </button>
                  </span>
                </div>
              </form>

            </div>


            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ข้อที่</th>
                  <th>โจทย์ - คำถาม</th>
                  <th>เสียงบรรยาย</th>
                  <th>จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <?php

                // if($total_data>'1'){
                // $sqex = $connSystem->prepare("SELECT question_id,type_id, question_name,question_sound,answer,reference,type_choice FROM exam_question WHERE question_name LIKE '%$search%'  AND type_id = :type_id_param ORDER BY question_id  DESC limit $start,$rows");
                // }else {
                // $sqex = $connSystem->prepare("SELECT question_id,type_id, question_name,question_sound,answer,reference,type_choice FROM exam_question WHERE type_id = :type_id_param ORDER BY question_id  DESC");
                // }
                $sqex = $connSystem->prepare("SELECT question_id,type_id, question_name,question_sound,answer,reference,type_choice FROM exam_question WHERE question_name LIKE '%$search%'  AND type_id = :type_id_param ORDER BY question_id  DESC limit $start,$rows");
                $sqex->execute(array(':type_id_param' => $_GET['exce']));
                while ($rowEX = $sqex->fetch(PDO::FETCH_ASSOC)) {


                ?>

                  <tr>
                    <td align="center" width="100"><?= $page ?></td>
                    <td>
                      <span style="font-size:22px"><?php echo $rowEX['question_name']; ?></span>
                      <table class="table table-hover">
                        <tbody>
                          <?php
                          $sqch = $connSystem->prepare("SELECT choice_order, choice_name,choice_sound FROM exam_choice WHERE type_id = :type_id_param AND reference=:reference ORDER BY choice_order  ASC");
                          $sqch->execute(array(':type_id_param' => $_GET['exce'], ':reference' => $rowEX["reference"]));
                          $resultArray = array();
                          while ($rowCH = $sqch->fetch(PDO::FETCH_ASSOC)) {
                            array_push($resultArray, $rowCH);

                          ?>
                            <tr>
                              <td style="width: 20px">
                                <span style="font-size:22px">
                                  <?php

                                  //if($rowEX['answer']==$rowCH['choice_order']){
                                  //echo "<font color='#F00001'>";
                                  if ($rowCH['choice_order'] == '1') {
                                    if ($rowEX['answer'] == $rowCH['choice_order']) {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "<font color='#F00001'>ก.</font>";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "<font color='#F00001'>A</font>";
                                      }
                                    } else {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "ก.";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "A";
                                      }
                                    }
                                  } elseif ($rowCH['choice_order'] == '2') {
                                    if ($rowEX['answer'] == $rowCH['choice_order']) {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "<font color='#F00001'>ข.</font>";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "<font color='#F00001'>B</font>";
                                      }
                                    } else {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "ข.";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "B";
                                      }
                                    }
                                  } elseif ($rowCH['choice_order'] == '3') {
                                    if ($rowEX['answer'] == $rowCH['choice_order']) {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "<font color='#F00001'>ค.</font>";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "<font color='#F00001'>C</font>";
                                      }
                                    } else {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "ค.";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "C";
                                      }
                                    }
                                  } elseif ($rowCH['choice_order'] == '4') {
                                    if ($rowEX['answer'] == $rowCH['choice_order']) {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "<font color='#F00001'>ง.</font>";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "<font color='#F00001'>D</font>";
                                      }
                                    } else {
                                      if ($rowEX['type_choice'] == '1') {
                                        echo "ง.";
                                      } elseif ($rowEX['type_choice'] == '2') {
                                        echo "D";
                                      }
                                    }
                                  }

                                  ?>
                                </span>
                              </td>
                              <td>
                                <span style="font-size:22px">
                                  <?php
                                  if ($rowEX['answer'] == $rowCH['choice_order']) {
                                    echo "<font color='#F00001'>";
                                    echo $rowCH['choice_name'];
                                    echo "</font>";
                                  } else {
                                    echo   $rowCH['choice_name'];
                                  }

                                  ?>
                                </span>
                              </td>
                            </tr>
                          <?php } ?>

                        </tbody>
                      </table>
                    </td>

                    <td style="width: 50px">
                      <?php if (!empty($rowEX['question_sound'])) { ?>
                        <div id='outerdiv'>
                          <?php
                          //print_r($resultArray);
                          $qu = $rowEX['question_sound'];
                          $ch1 = $resultArray[0]["choice_sound"];
                          $ch2 = $resultArray[1]["choice_sound"];
                          $ch3 = $resultArray[2]["choice_sound"];
                          $ch4 = $resultArray[3]["choice_sound"];
                          ?>

                          <iframe id='inneriframe' scrolling="no" style="width:150px; height:220px ;  border:thin; background-color:#fff" src="sound_for_dashboard.php?ch1=<?= $ch1 ?>&ch2=<?= $ch2 ?>&ch3=<?= $ch3 ?>&ch4=<?= $ch4 ?>&qu=<?= $qu ?>"></iframe>
                        </div>

                      <?php } else {
                        echo "ไม่มี";
                      }  ?>
                    </td>
                    <td>

                      <div class="btn-group-vertical">
                        <button style="background-color:<?= $theme_color ?>;" type="button" onclick="window.location.href='dashboard_admin?option=exam-data-edit&reference=<?php echo $rowEX["reference"]; ?>&exce=<?php echo $_GET['exce']; ?>&page=<?= $page ?>'" class="btn btn-success">แก้ไข</button>
                        <button style="background-color:<?= $theme_color ?>;" type="button" id='move' Onclick="return move();" class="btn btn-success">ลบ</button>
                      </div>
                      <script>
                        function move() {
                          swal({
                              title: "ต้องการลบข้อมูล?",
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonColor: "#DD6B55",
                              confirmButtonText: "ใช่!",
                              cancelButtonText: "ไม่ใช่!",
                              closeOnConfirm: false,
                              closeOnCancel: false
                            },
                            function(isConfirm) {
                              if (isConfirm) {
                                swal("ลบข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                                location.href = 'dashboard_admin?option=exam-data&referenceDE=<?php echo $rowEX["reference"]; ?>&exce=<?php echo $_GET['exce']; ?>&page=<?= $page ?>';
                              } else {
                                swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                              }
                            });
                        }
                      </script>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>ข้อที่</th>
                  <th>โจทย์ - คำถาม</th>
                  <th>เสียงบรรยาย</th>
                  <th>จัดการ</th>
                </tr>
              </tfoot>
            </table>

          </div>



        </div>
        <!-- /.box-body -->


      </div>
      <!-- /.tab-pane -->
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>