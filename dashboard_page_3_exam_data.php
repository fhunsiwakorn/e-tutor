<style type="text/css">

#outerdiv
{
width:200px;
height:150px;
overflow:hidden;
position:relative;
}

#inneriframe
{
position:absolute;
top:-70px;
left:2px;
width:300px;
height:600px;
}


</style>
<?php
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['C']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

////แบ่งหน้า
$type_id=$_GET['C'];
$total_data = $connSystem->query("SELECT count(*) from exam_question WHERE  type_id='$type_id'")->fetchColumn();
//echo "$examRows ";
if(isset($_GET['page'])){
  $page=$_GET['page'];
}else {
  $page=null;
}
$rows='1';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;

 ?>

<?php
$col1=$sql_process->mf("SC3E4R8WYTR9K19ROJ2",$language_id);
$col2=$sql_process->mf("517WKIH7ZUS2PKFN39HR",$language_id);
$col3=$sql_process->mf("4E6LVY4QQV1CBR7EB2NE",$language_id);
// $col4=$sql_process->mf("Z62PFHTQFSOIHCNS90H5",$language_id);


$t1=$sql_process->mf("CJGNTE4UPKLODTWJ6DGZ",$language_id);
?>

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$t1?> <?php echo $rowEXType['type_name'];?></h3>

    <div class="box-tools">
                <!-- <ul class="pagination pagination-sm no-margin pull-right">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>>
                    <a href="dashboard?option=exam-data&C=<?=$type_id?>&page=<?=$page-1?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <?php for($i=1;$i<=$total_page ;$i++) {?>
                  <li <?php  if($page==$i){echo"class='active'";} ?>><a href="dashboard?option=exam-data&C=<?=$type_id?>&page=<?=$i?>"><?=$i?></a></li>

                  <?php } ?>
                  <li <?php  if($page==$total_page){echo"class='disabled'";} ?>>
                    <a href="dashboard?option=exam-data&C=<?=$type_id?>&page=<?=$page+1?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul> -->
                <form method="get" name="supage1">
                <nav aria-label="...">
                <input type="hidden" name="option"  value="exam-data">
                <input type="hidden" name="C"  value="<?php echo $_GET['C']; ?>">
                <!-- <input type="hidden" name="page"  value="<?=$page?>"> -->
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="dashboard?option=exam-data&C=<?=$type_id?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number" name="page" style="width:60px; height:30px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:50px; height:30px;font-size:20px;text-align: center;" value="<?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="dashboard?option=exam-data&C=<?=$type_id?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                </ul>
                </nav>
              </form>
              </div>

  </div>
  <div class="box-body">
    <div class="box-body table-responsive no-padding">
      <table  class="table table-hover">
                    <thead>
                    <tr>
                      <th><?=$col1?></th>
                      <th><?=$col2?></th>
                      <th><?=$col3?></th>
                    </tr>
                    </thead>
                    <tbody>
<?php

if($total_data>'1'){
$sqex = $connSystem->prepare("SELECT question_id,type_id, question_name,question_sound,answer,reference,type_choice FROM exam_question WHERE type_id = :type_id_param ORDER BY question_id  DESC limit $start,$rows");
}else {
$sqex = $connSystem->prepare("SELECT question_id,type_id, question_name,question_sound,answer,reference,type_choice FROM exam_question WHERE type_id = :type_id_param ORDER BY question_id  DESC");
}
$sqex->execute(array(':type_id_param'=>$_GET['C']));
while($rowEX = $sqex->fetch(PDO::FETCH_ASSOC)) {
  ?>

                    <tr>
                      <td align="center" width="100"><?=$page?></td>
                      <td >
    <span style="font-size:22px"><?php echo $rowEX['question_name']; ?></span>
                         <table   class="table table-hover">
      <tbody>
      <?php
      $sqch = $connSystem->prepare("SELECT choice_order, choice_name,choice_sound FROM exam_choice WHERE type_id = :type_id_param AND reference='".$rowEX["reference"]."' ORDER BY choice_order  ASC");
      $sqch->execute(array(':type_id_param'=>$_GET['C']));
      $resultArray=array();
      while($rowCH = $sqch->fetch(PDO::FETCH_ASSOC)) {
          array_push($resultArray,$rowCH);

      ?>
        <tr>
          <td style="width: 20px">
    <span style="font-size:22px">
    				<?php

    			//if($rowEX['answer']==$rowCH['choice_order']){
    				//echo "<font color='#F00001'>";
            if($rowCH['choice_order']=='1'){
              if($rowEX['answer']==$rowCH['choice_order']){
                if($rowEX['type_choice']=='1'){
                  echo "<font color='#F00001'>ก.</font>";
                }elseif($rowEX['type_choice']=='2'){
                  echo "<font color='#F00001'>A</font>";
                }

              }else{
                  if($rowEX['type_choice']=='1'){
                  echo "ก.";
                  }elseif($rowEX['type_choice']=='2'){
                  echo "A";
                  }
              }
            }elseif ($rowCH['choice_order']=='2') {
              if($rowEX['answer']==$rowCH['choice_order']){
                if($rowEX['type_choice']=='1'){
                  echo "<font color='#F00001'>ข.</font>";
                }elseif($rowEX['type_choice']=='2'){
                  echo "<font color='#F00001'>B</font>";
                }
              }else {
                if($rowEX['type_choice']=='1'){
                echo "ข.";
                }elseif($rowEX['type_choice']=='2'){
                echo "B";
                }
              }
            }elseif ($rowCH['choice_order']=='3') {
              if($rowEX['answer']==$rowCH['choice_order']){
                if($rowEX['type_choice']=='1'){
                  echo "<font color='#F00001'>ค.</font>";
                }elseif($rowEX['type_choice']=='2'){
                  echo "<font color='#F00001'>C</font>";
                }
              }else {
                if($rowEX['type_choice']=='1'){
                echo "ค.";
                }elseif($rowEX['type_choice']=='2'){
                echo "C";
                }
              }
            }elseif ($rowCH['choice_order']=='4') {
              if($rowEX['answer']==$rowCH['choice_order']){
                if($rowEX['type_choice']=='1'){
                  echo "<font color='#F00001'>ง.</font>";
                }elseif($rowEX['type_choice']=='2'){
                  echo "<font color='#F00001'>D</font>";
                }
              }else {
                if($rowEX['type_choice']=='1'){
                echo "ง.";
                }elseif($rowEX['type_choice']=='2'){
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
    			if($rowEX['answer']==$rowCH['choice_order']){
    				echo "<font color='#F00001'>";
    				echo $rowCH['choice_name'];
    				echo "</font>";
    			}else {
    				echo 	$rowCH['choice_name'] ;
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

              <?php if(!empty($rowEX['question_sound'])){ ?>
                <div id='outerdiv'>
                  <?php
                  //print_r($resultArray);
                  $qu=$rowEX['question_sound'];
                  $ch1= $resultArray[0]["choice_sound"];
                  $ch2= $resultArray[1]["choice_sound"];
                  $ch3= $resultArray[2]["choice_sound"];
                  $ch4= $resultArray[3]["choice_sound"];
                  ?>

                <iframe  id='inneriframe' scrolling="no"  style="width:150px; height:220px ;  border:thin; background-color:#fff" src="sound_for_dashboard.php?ch1=<?=$ch1?>&ch2=<?=$ch2?>&ch3=<?=$ch3?>&ch4=<?=$ch4?>&qu=<?=$qu?>"  ></iframe>
              </div>

              <?php }else{ echo "ไม่มี";}  ?>
   </td>

                    </tr>
         <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                    <th><?=$col1?></th>
                      <th><?=$col2?></th>
                      <th><?=$col3?></th>
                    </tr>
                    </tfoot>
                  </table>

  </div>



  </div>
  <!-- /.box-body -->
</div>
