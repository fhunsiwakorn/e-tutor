<?php
///UPDATE
if(isset($_POST['btn_primary'])){
       try {

           if(empty($_POST['ran'])){
             $ran='0';
            }elseif (!empty($_POST['ran'])) {
             $ran='1';
           }
     $dateC=date("Y-m-d");
     ///โจทย์
     $que = "UPDATE exam_question SET
         question_name=:question_name_edit,
         question_sound=:question_sound_edit,
         answer=:answer_edit,
         random_status=:random_status_edit,
         type_choice=:type_choice_edit
         WHERE reference=:reference_edit AND type_id=:type_id_edit";
       $extc = $connSystem->prepare($que);
       $extc->execute(
             Array(
                    ':question_name_edit' => $_POST['question_name'],
                    ':question_sound_edit' => $_POST['question_sound'],
                    ':answer_edit' => $_POST['answer'],
                    ':reference_edit' => $_POST['reference'],
                    ':random_status_edit' => $ran,
                    ':type_choice_edit' => $_POST['type_choice'],
                    ':type_id_edit' => $_POST['type_id']

             )
       );
       ///ตัวเลือกที่ 1
       $cq1 = "UPDATE exam_choice SET
           choice_name=:choice_name_edit_1,
           choice_sound=:choice_sound_edit_1
           WHERE choice_order=:choice_order_edit_1 AND reference=:reference_edit AND type_id=:type_id_edit";
       $extc = $connSystem->prepare($cq1);
       $extc->execute(
             Array(
                    ':choice_order_edit_1' =>1,
                    ':choice_name_edit_1' => $_POST['choice_name_1'],
                    ':choice_sound_edit_1' => $_POST['choice_sound_1'],
                    ':reference_edit' => $_POST['reference'],
                    ':type_id_edit' => $_POST['type_id']

             )
       );
       ///ตัวเลือกที่ 2
       $cq2 = "UPDATE exam_choice SET
           choice_name=:choice_name_edit_2,
           choice_sound=:choice_sound_edit_2
           WHERE choice_order=:choice_order_edit_2 AND reference=:reference_edit AND type_id=:type_id_edit";
       $extc = $connSystem->prepare($cq2);
       $extc->execute(
             Array(
                    ':choice_order_edit_2' =>2,
                    ':choice_name_edit_2' => $_POST['choice_name_2'],
                    ':choice_sound_edit_2' => $_POST['choice_sound_2'],
                    ':reference_edit' => $_POST['reference'],
                    ':type_id_edit' => $_POST['type_id']

             )
       );
       ///ตัวเลือกที่ 3
       $cq3 = "UPDATE exam_choice SET
           choice_name=:choice_name_edit_3,
           choice_sound=:choice_sound_edit_3
           WHERE choice_order=:choice_order_edit_3 AND reference=:reference_edit AND type_id=:type_id_edit";
       $extc = $connSystem->prepare($cq3);
       $extc->execute(
             Array(
                    ':choice_order_edit_3' =>3,
                    ':choice_name_edit_3' => $_POST['choice_name_3'],
                    ':choice_sound_edit_3' => $_POST['choice_sound_3'],
                    ':reference_edit' => $_POST['reference'],
                    ':type_id_edit' => $_POST['type_id']

             )
       );
       ///ตัวเลือกที่ 4
       $cq4 = "UPDATE exam_choice SET
           choice_name=:choice_name_edit_4,
           choice_sound=:choice_sound_edit_4
           WHERE choice_order=:choice_order_edit_4 AND reference=:reference_edit AND type_id=:type_id_edit";
       $extc = $connSystem->prepare($cq4);
       $extc->execute(
             Array(
                    ':choice_order_edit_4' =>4,
                    ':choice_name_edit_4' => $_POST['choice_name_4'],
                    ':choice_sound_edit_4' => $_POST['choice_sound_4'],
                    ':reference_edit' => $_POST['reference'],
                    ':type_id_edit' => $_POST['type_id']

             )
       );
//Update วันที่หลักสูตร
       $q = "UPDATE exam_type SET type_date=:type_date_edit  WHERE type_id=:type_id_edit";
       $sth = $connSystem->prepare($q);
       $sth->execute(
             Array(
                    ':type_id_edit' => $_POST['type_id'],
                    ':type_date_edit' => $dateC
             )
       );
           }catch(PDOException $e) {
               echo $e->getMessage();
           }
           $type_id_edit=$_POST['type_id'];
           $reference=$_POST['reference'];
           $page=$_POST['page'];
           echo "<script>";
           echo "location.href = 'dashboard_admin?option=exam-data-edit&reference=$reference&exce=$type_id_edit&page=$page&success'";
           echo "</script>";
      }


 ?>

<?php

////Edit Shows
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['exce']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);
//
$quedit = $connSystem->prepare("SELECT question_name,question_sound,answer,random_status,type_choice FROM exam_question  WHERE reference=:reference_param AND type_id = :type_id_param");
$quedit->execute(array(':reference_param'=>$_GET['reference'],':type_id_param'=>$_GET['exce']));
$rowEXedit = $quedit->fetch(PDO::FETCH_ASSOC);
//c1
$c1 = $connSystem->prepare("SELECT choice_order,choice_name,choice_sound FROM exam_choice  WHERE reference=:reference_param AND type_id = :type_id_param AND choice_order = :choice_order_1");
$c1->execute(array(':reference_param'=>$_GET['reference'],':type_id_param'=>$_GET['exce'],':choice_order_1'=>1));
$rowc1 = $c1->fetch(PDO::FETCH_ASSOC);
//c2
$c2 = $connSystem->prepare("SELECT choice_order,choice_name,choice_sound FROM exam_choice  WHERE reference=:reference_param AND type_id = :type_id_param AND choice_order = :choice_order_2");
$c2->execute(array(':reference_param'=>$_GET['reference'],':type_id_param'=>$_GET['exce'],':choice_order_2'=>2));
$rowc2 = $c2->fetch(PDO::FETCH_ASSOC);
//c3
$c3 = $connSystem->prepare("SELECT choice_order,choice_name,choice_sound FROM exam_choice  WHERE reference=:reference_param AND type_id = :type_id_param AND choice_order = :choice_order_3");
$c3->execute(array(':reference_param'=>$_GET['reference'],':type_id_param'=>$_GET['exce'],':choice_order_3'=>3));
$rowc3 = $c3->fetch(PDO::FETCH_ASSOC);
//c4
$c4 = $connSystem->prepare("SELECT choice_order,choice_name,choice_sound FROM exam_choice  WHERE reference=:reference_param AND type_id = :type_id_param AND choice_order = :choice_order_4");
$c4->execute(array(':reference_param'=>$_GET['reference'],':type_id_param'=>$_GET['exce'],':choice_order_4'=>4));
$rowc4 = $c4->fetch(PDO::FETCH_ASSOC);
 ?>
 <?php
 if(isset($_GET['success'])){
  ?>
  <script>
 	swal("บันทึกข้อมูลสำเร็จ !", "ปิดหน้าต่างนี้ !", "success");
  </script>
 <?php } ?>
              <div class="row">
                <div class="col-xs-12">
                  <!-- interactive chart -->
                  <div class="box box-default">
                    <div class="box-header with-border">


                      <h3 class="box-title">หลักสูตร : <?php echo $rowEXType["type_name"];?></h3>
                      <div class="box-tools pull-right">
                        <div class="btn-group">
                        <button  type="button" onclick="window.location.href='dashboard_admin?option=exam-data&exce=<?php echo $_GET["exce"];?>&page=<?php echo $_GET["page"];?>'"  class="btn btn-default" data-toggle="tooltip"  title="ย้อนกลับ">
                        <img id="myImg"  src="image_system/back.png"  width="30" height="30" >
                        </button>
                        </div>
                      </div>
                    </div>
                    <div class="box-header with-border">
                      <i class="glyphicon glyphicon-book"></i>

                      <h3 class="box-title">โจทย์ - คำถาม</h3>

                    </div>
                      <form method="post" name="exam"  id="exam">
                        <input type="hidden" name="type_id" value="<?php echo $_GET['exce'];?>">
                        <input type="hidden" name="reference" value="<?php echo $_GET['reference'];?>">
                        <input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
                    <div class="box-body">
                      <div class="col-xs-12">
                       <label>เสียงบรรยายโจทย์ (Path URL)</label>
                       <input type="text" class="form-control" name="question_sound" placeholder="ใส่ Path URL เสียงบรรยายโจทย์" value="<?php echo $rowEXedit["question_sound"];?>">
                      </div>
                      <br><hr><br>
                      <div class="col-xs-12">
                       <textarea name="question_name" id="editor" cols="70" rows="5" class="ckeditor" required><?php echo $rowEXedit["question_name"];?></textarea>
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
                       <input type="text" class="form-control" name="choice_sound_1" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="<?php echo $rowc1["choice_sound"];?>">
                      </div>
                      <br><hr><br>
                      <div class="col-xs-12">
                           <textarea name="choice_name_1" id="editor" cols="70" rows="5" class="ckeditor" required><?php echo $rowc1["choice_name"];?></textarea>
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
                       <input type="text" class="form-control" name="choice_sound_2" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="<?php echo $rowc2["choice_sound"];?>">
                      </div>
                      <br><hr><br>
                      <div class="col-xs-12">
                        <textarea name="choice_name_2" id="editor2" cols="70" rows="5" class="ckeditor" required><?php echo $rowc2["choice_name"];?></textarea>
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
                       <input type="text" class="form-control" name="choice_sound_3" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="<?php echo $rowc3["choice_sound"];?>">
                      </div>
                      <br><hr><br>
                    <div class="col-xs-12">
                         <textarea name="choice_name_3" id="editor3" cols="70" rows="5" class="ckeditor" required><?php echo $rowc3["choice_name"];?></textarea>
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
                       <input type="text" class="form-control" name="choice_sound_4" placeholder="ใส่ Path URL เสียงบรรยายตัวเลือก" value="<?php echo $rowc4["choice_sound"];?>">
                      </div>
                      <br><hr><br>
                      <div class="col-xs-12">
                     <textarea name="choice_name_4" id="editor4" cols="70" rows="5" class="ckeditor" required><?php echo $rowc4["choice_name"];?></textarea>
                    </div>
                  </div>
                    <!-- /.box-body-->
                  </div>
                  <!-- /.box -->
                </div>
                    </div>

                    <div class="box box-default">
                    	<div class="box-header with-border">

                    		<h3 class="box-title">เลือกเฉลย</h3>
                    	</div>
                    		<div class="box-body">
                          <div class="form-group" >
                                      <label>เลือกประเภทตัวเลือก</label>
                                      <select class="form-control" name="type_choice" style="width:300px" >
<?php

if($rowEXedit["type_choice"]=='1'){
echo '<option value="1">ก. ข. ค. ง.</option>';
  }elseif($rowEXedit["type_choice"]=='2'){
echo '<option value="2">A B C D</option>';
  }

?>
                                        <option value="1">ก. ข. ค. ง.</option>
                                        <option value="2">A B C D</option>


                                      </select>
                                    </div>
                    			<div class="form-group" >
                    									<!-- <label>เลือกเฉลย</label> -->
                    									<select class="form-control" name="answer" style="width:300px" >
                    										<option value="<?php echo $rowEXedit["answer"];?>">
                                          <?php
                                          if($rowEXedit["answer"]=='1'){
                                            echo "1";
                                          }elseif ($rowEXedit["answer"]=='2') {
                                            echo "2";
                                          }elseif ($rowEXedit["answer"]=='3') {
                                            echo "3";
                                          }elseif ($rowEXedit["answer"]=='4') {
                                            echo "4";
                                          }

                                           ?>
                                        </option>
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
                    		 <input type="checkbox" value="1" name="ran" <?php if($rowEXedit["random_status"]=='1'){echo 'checked="checked"';} ?> >
                    		 <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    		 สุ่มตัวเลือก (Random Choice)
                    		 </label>

                    				 </div>
                    		 </div>
                    		</div>

                    </div>

                    <br>
                    <center><input type="submit" name="btn_primary" class="btn btn-success" style="background-color:<?=$theme_color?>;"  value="บันทึกข้อมูล"/></center>
</form>
