<?php
$col1=$sql_process->mf("VH8CNLFNTIOWWFNUM5N8",$language_id);
$col2=$sql_process->mf("LVAHN4FNGHS8FV7FGDY",$language_id);
$col3=$sql_process->mf("6UXVM2BNMAW34JO1TWD",$language_id);
$col4=$sql_process->mf("B4V12PO8AQZWRM0EU62",$language_id);

$t1=$sql_process->mf("NATDPVWXSL0SFA1EVPZD",$language_id);
?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("T0DZ3N2DFBB3K6FG61D",$language_id)?></h3>

    <!-- <div class="box-tools pull-right"></div> -->
  </div>
  <div class="box-body">
<!-- <div class="box-body table-responsive no-padding"> -->
<div>
<div id="piechart_3d" style="width: 100%; height: 500px;"></div>
  </div>
<hr>
<table id="example1" class="table table-bordered table-striped">
  <thead>
  <tr>
    <th><?=$col1?></th>
    <th><?=$col2?></th>
    <th><?=$col3?></th>
    <th><?=$col4?></th>
  </tr>
  </thead>
  <tbody>
     <?php
$number='0';
$stypesq = $connSystem->prepare("SELECT  exam_status_score.user_id,exam_status_score.type_id,exam_type.type_name FROM exam_status_score,exam_type
 WHERE 
 exam_status_score.type_id=exam_type.type_id AND
 exam_status_score.user_id=:user_id_param
 GROUP BY
 exam_status_score.type_id
 ORDER BY exam_status_score.type_id  ASC");
$stypesq->execute(array(':user_id_param'=>$user_id));
while($rowTypesq = $stypesq->fetch(PDO::FETCH_ASSOC)) {

$number++;

?>
  <tr>
    <td align="center"><?=$number?></td>
    <td><?php echo $rowTypesq['type_name']; ?></td>
    <td  align="center">
    <?php
$sumtestT = $connSystem->query("SELECT count(user_id) from exam_status_score WHERE  user_id='$user_id'  AND type_id='".$rowTypesq['type_id']."' AND school_id='$school_id'")->fetchColumn();
echo "$sumtestT";
    ?>

    </td>
    <td  align="center">
      <a href="sdc?option=chart-history&cte=<?php echo $rowTypesq['type_id']; ?>"  title="<?=$t1?> : <?php echo $rowTypesq['type_name']; ?>"><u><font color="#010080">Click</font></u></a>
    </td>
  </tr>
<?php } ?>
  </tbody>
  <tfoot>
  <tr>
  <th><?=$col1?></th>
    <th><?=$col2?></th>
    <th><?=$col3?></th>
    <th><?=$col4?></th>
  </tr>
  </tfoot>
</table>

  </div>
  <!-- /.box-body -->
</div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load("current", {packages:["corechart"]});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
 <?php
$stypes2 = $connSystem->prepare("SELECT DISTINCT user_id,type_id FROM exam_status_score WHERE user_id=:user_id_param ORDER BY type_id  ASC");
$stypes2->execute(array(':user_id_param'=>$user_id));
while($rowTypes = $stypes2->fetch(PDO::FETCH_ASSOC)) {
  $namet2 = $connSystem->prepare("SELECT type_id,type_name FROM exam_type  WHERE type_id = :type_id_pram2 ");
  $namet2->execute(array(':type_id_pram2'=>$rowTypes['type_id']));
  $rowNr2 = $namet2->fetch(PDO::FETCH_ASSOC);
$type_id = $rowNr2["type_id"];
$type_name = $rowNr2["type_name"];
$sumtest = $connSystem->query("SELECT count(*) from exam_status_score WHERE  user_id='$user_id'  AND type_id='$type_id'")->fetchColumn();
?>

         ['<?=$type_name?>',<?=$sumtest?>],

              <?php } ?>

            ]);

            var options = {
              title: '<?=$sql_process->mf("8TZIVV1CRAKZUIVS8G9W",$language_id)?>',
              is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
          }
        </script>
