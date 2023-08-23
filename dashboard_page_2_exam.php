<?php
$col1=$sql_process->mf("0S7T6K01MQJKECAVUIO8",$language_id);
$col2=$sql_process->mf("OOQH1J2R04RTTA0H3N",$language_id);
$col3=$sql_process->mf("MD3ORJ9W014YY8UR5642",$language_id);
$col4=$sql_process->mf("Z62PFHTQFSOIHCNS90H5",$language_id);
$col5=$sql_process->mf("OAIQHY41T24Z06WRYIJJ",$language_id);
$col6=$sql_process->mf("S0NX643WZZO1Z70FUZV",$language_id);
$col7=$sql_process->mf("H21Z30OIFD04XB27LOOJ",$language_id);
$col8=$sql_process->mf("JNO0XHKYDI4GIE8VKMFR",$language_id);
$col9=$sql_process->mf("SLUTQVTDOQJC57M4040I",$language_id);

$t1=$sql_process->mf("H21Z30OIFD04XB27LOOJ",$language_id);
?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("JFTYFTNZBPROM39N9K2A",$language_id);?></h3>

  </div>
  <div class="box-body">

    <div class="box-body table-responsive no-padding">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><?=$col1?></th>
          <th><?=$col2?></th>
          <th><?=$col3?></th>
          <th><?=$col4?></th>
          <th><?=$col5?></th>
          <th><?=$col6?></th>
          <th><?=$col7?></th>
          <th><?=$col8?></th>
          <th><?=$col9?></th>
        </tr>
        </thead>
        <tbody>
<?php
$stype = $connSystem->prepare(
"SELECT
exam_type.type_id,
exam_type.type_name,
exam_type.type_detail,
exam_type.type_pic,
exam_type.type_date,
exam_type.language_id,
exam_type.type_group_id
FROM
tbl_permission_course ,
exam_type ,
tbl_school
WHERE
exam_type.type_id = tbl_permission_course.type_id AND
tbl_permission_course.compair_course = '$compair_course' AND
tbl_school.compair_course = '$compair_course' AND
exam_type.type_status='1'

ORDER BY type_id  DESC");
$stype->execute();
while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {

  $type_id=$rowType['type_id'];
if(!empty($rowType['type_pic'])){
$cimg=$rowType['type_pic'];
}else {
$cimg="image_system/noimage.gif";
}

  $ste = $connSystem->prepare("SELECT language_name FROM tbl_exam_language  WHERE language_id ='".$rowType['language_id']."'");
$ste->execute();
$rowCeedit = $ste->fetch(PDO::FETCH_ASSOC);
$language_name=$rowCeedit["language_name"];

$ste1 = $connSystem->prepare("SELECT type_group_name FROM tbl_vehicle_type  WHERE type_group_id ='".$rowType['type_group_id']."'");
$ste1->execute();
$rowCeedit1 = $ste1->fetch(PDO::FETCH_ASSOC);
$type_group_name=$rowCeedit1["type_group_name"];
?>
        <tr>
          <td align="center"><?php echo  sprintf("%04d", $rowType["type_id"]); ?></td>
          <td  align="center"><img id="myImg"  src="<?=$cimg?>" alt="<?php echo $rowType['type_name']; ?>" width="45" height="45" style="border-radius:100px"></td>
          <td><?php echo $rowType['type_name'];?></td>
          <td><?=$language_name?></td>
          <td><?=$type_group_name?></td>
          <td><?php echo $rowType['type_detail'];?></td>
          <td  align="center">
        <button type="button" class="btn btn-block btn-default" onclick="window.location.href='dashboard?option=exam-data&C=<?php echo $rowType['type_id']; ?>'" data-toggle="tooltip" title="<?=$t1?> <?php echo $rowType['type_name']; ?>">
<img id="myImg"  src="image_system/unnamed.png"  width="35" height="35" >
        </button>

          </td>
          <td  align="center">
        <?php
      $type_id=$rowType['type_id'];
      $examRows = $connSystem->query("SELECT count(*) from exam_question WHERE  type_id='$type_id'")->fetchColumn();
      echo "$examRows ";
        ?>
          </td>
          <td  align="center">
            <?php echo DatetoDMY($rowType['type_date']); ?>
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
          <th><?=$col5?></th>
          <th><?=$col6?></th>
          <th><?=$col7?></th>
          <th><?=$col8?></th>
          <th><?=$col9?></th>
        </tr>
        </tfoot>
      </table>
  </div>


  </div>
  <!-- /.box-body -->
</div>
