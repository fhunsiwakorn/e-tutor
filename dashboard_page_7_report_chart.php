<?php
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['C']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

$stu = $connSystem->prepare("SELECT user_firstname,user_lastname,user_id_card,user_testing_date FROM user_member_group  WHERE user_id = :user_id_param AND school_id=:school_id");
$stu->execute(array(':user_id_param'=>$_GET['us'],':school_id'=>$school_id));
$rowStu = $stu->fetch(PDO::FETCH_ASSOC);

$col1=$sql_process->mf("HOFIMB0NL6RTAGEDB",$language_id);
$col2=$sql_process->mf("ZN9L6W1HNT6F4TUOR",$language_id);
$col3=$sql_process->mf("UEIS8UVVI4W0386PA96P",$language_id);
$col4=$sql_process->mf("JUGFRKCCCS0VTRAZ5OW",$language_id);
$col5=$sql_process->mf("96A8QNABPFI9IU6D09G",$language_id);
$t1=$sql_process->mf("NATDPVWXSL0SFA1EVPZD",$language_id);
$t2=$sql_process->mf("V17F1184H78AZW5BS9JR",$language_id);
 ?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$t1?> : <?php echo $rowEXType['type_name'];?> | <?=$t2?> : <?php echo $rowStu['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowStu['user_lastname'];?></h3>
  </div>
  <div class="box-body">
<!-- Chart -->
    <div class="box-body chart-responsive">
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div" ></div>
    </div>

<!-- ประวัติการสอบ -->
<table id="example5" class="table table-bordered table-striped">
  <thead>
  <tr >
		<th><?=$col1?></th>
		<th><?=$col2?></th>
		<th><?=$col3?> (100%)</th>
		<th><?=$col4?> (100%)</th>
		<th><?=$col5?> (50)</th>
  </tr>
  </thead>
  <tbody>
     <?php

     $hist = $connSystem->prepare("SELECT score_total,score_date FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param  ORDER BY score_id DESC");
     $hist->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
     $rec = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id = '".$_GET['us']."' AND type_id= '".$_GET['C']."'")->fetchColumn();
     $a='0';
     $number=$rec+1;
     while($rowHis = $hist->fetch(PDO::FETCH_ASSOC))
    {
$a++;

$percen=($rowHis['score_total']/$examstart)*100;
?>
  <tr>
    <td><center><?php echo  $number-$a;	?></center></td>
    <td><?php $strDate = $rowHis['score_date']; echo DatetoDMYTime($strDate);?></td>
		<td>
			<div class="progress progress-xs progress-striped active">
			<div class="progress-bar progress-bar-success" style="width: <?=$percen?>%"></div>
			</div>

		</td>
		<td align="center"><?=$percen?> %</td>
	  <td  align="center">
  <?php echo $rowHis['score_total']; ?>
    </td>

  </tr>
<?php } ?>
  </tbody>
  <tfoot>
  <tr>
  <th><?=$col1?></th>
		<th><?=$col2?></th>
		<th><?=$col3?> (100%)</th>
		<th><?=$col4?> (100%)</th>
		<th><?=$col5?> (50)</th>
  </tr>
  </tfoot>
</table>


  </div>
  <!-- /.box-body -->
</div>



<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("QNUFHXBMYHJU8302MDG9",$language_id);?></h3>
  </div>
  <div class="box-body">


<table class="table table-bordered">

  <tr >
	<td><?=$sql_process->mf("9R2ZT4IT93SKL7R48HP",$language_id);?>
 <font color="red"> <?php echo $total_test = $connSystem->query("SELECT count(user_id) from exam_status_score WHERE  type_id= '".$_GET['C']."'  AND user_id='".$_GET['us']."' ")->fetchColumn(); ?> </font>
 <?=$sql_process->mf("LT99XD34CUFL306PHDUU",$language_id);?>
   </td>
  <td>
  <?=$sql_process->mf("4OIQ8M8KTOTO6MN5RW",$language_id);?> 
  <font color="red">
  <?php
$stype2 = $connSystem->prepare("SELECT SUM(score_total) AS score_total FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param ");
$stype2->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
$rowEXType2 = $stype2->fetch(PDO::FETCH_ASSOC);
$average_test=$rowEXType2['score_total']/$total_test;
echo number_format($average_test,2);
  ?>
   </font>
   <?=$sql_process->mf("4N1BGXDIXXP0M8OP4L",$language_id);?> 
  </td>
  </tr>


  <tr>
    <td>   <?=$sql_process->mf("4AUTJ2RKA9A8SM9EQV1P",$language_id);?> 
    <font color="red">
    <?php
    $user_testing_date=$sql_process->lookupfild("user_testing_date","user_member_group","user_id",$_GET['us']);
    $present_date=date("Y-m-d");
     $CoutDate = DateDiff($present_date,$user_testing_date);
     if($CoutDate <=0){
       echo "0";
     }else{
      echo  $CoutDate;
     }
     
      ?> 
         </font>
         <?=$sql_process->mf("J0Y1I8DDD0C28JP3K95",$language_id);?>    <?=$sql_process->mf("APDRT7R5Y4BRM1A0DMS",$language_id);?>
  
    </td> 

    <td>
<?=$sql_process->mf("YGMTYITQPEMB668IXAQ",$language_id);?>  
    <font color="red"> 
    <?php 
    if($user_testing_date =="0000-00-00" || $user_testing_date==NULL){
      echo "-";
    }else{
       echo DatetoDMY($user_testing_date);
     
    }
   
    
    ?></font></td>
	

  </tr>



  
</table>


  </div>
  <!-- /.box-body -->
</div>







<script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', '<?=$sql_process->mf("4N1BGXDIXXP0M8OP4L",$language_id);?>');

      data.addRows([
        <?php
$charts_num='0';
$chart = $connSystem->prepare("SELECT score_total FROM exam_status_score WHERE type_id=:type_id_param AND user_id=:user_id_param  ORDER BY score_id  ASC");
$chart->execute(array(':type_id_param'=>$_GET['C'],':user_id_param'=>$_GET['us']));
while($rowCha = $chart->fetch(PDO::FETCH_ASSOC)) {
$charts_num++;
?>
        [<?php echo round($charts_num) ?>,<?php echo $rowCha['score_total']; ?>],
<?php } ?>

      ]);

      var options = {
        hAxis: {
          title: '<?=$sql_process->mf("HOFIMB0NL6RTAGEDB",$language_id);?>'
        },
        vAxis: {
          title: '<?=$sql_process->mf("LVAHN4FNGHS8FV7FGDY",$language_id);?> <?php echo $rowEXType['type_name'];?>'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }


  </script>
