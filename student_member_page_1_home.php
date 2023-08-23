<?php 
if($school_fanpage !=NULL && isset($_GET["pop"])){
  include ("popupface1.php");
}
$t1=$sql_process->mf("LVAHN4FNGHS8FV7FGDY",$language_id);
$t2=$sql_process->mf("JNO0XHKYDI4GIE8VKMFR",$language_id);
$t3=$sql_process->mf("QX1WUQKSLNM5PT38VYME",$language_id);
$t4=$sql_process->mf("SLUTQVTDOQJC57M4040I",$language_id);
$t5=$sql_process->mf("4ODPCJY3TGRRXT1TAPT",$language_id);
$t6=$sql_process->mf("SI0V8JJCW3NDPNLYU0Z",$language_id);
?>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("90F882NNTHEPGLBO20U",$language_id);?></h3>
  </div>
  <div class="box-body">

    <?php
    $stype = $connSystem->prepare(
    "SELECT
    exam_type.type_id,
    exam_type.type_name,
    exam_type.type_detail,
    exam_type.type_pic,
    exam_type.type_date
    FROM
    
    exam_permission ,
    exam_type 
    WHERE
    exam_type.type_id = exam_permission.type_id AND
    exam_permission.user_code = '$user_code'  
    ORDER BY type_id  DESC");

    $stype->execute();
    while($rowType = $stype->fetch(PDO::FETCH_ASSOC)) {
if(!empty($rowType['type_pic']))
 {
  $path=$rowType['type_pic'];
 }   else{
   $path="image_system/noimage.gif";
 }
 
 ?>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">

           <img id="myImg"  id="myImg"  src="<?php echo $path; ?>" alt="<?php echo $rowType['type_name']; ?>" style="width:100%; height:100%">
        <div class="caption">
          <h3><?=$t1?> : <?php echo $rowType['type_name'];?> </h3>
          <h4><?=$t2?> :
            <?php
          $type_id=$rowType['type_id'];
          $examRows = $connSystem->query("SELECT count(*) from exam_question WHERE  type_id='$type_id'")->fetchColumn();
          echo "$examRows ";
            ?>
            <?=$t3?>
          </h4>
          <h4><?=$t4?> : <?php  $strDate = $rowType['type_date']; echo DatetoDMY($strDate); ?></h4>
          <hr>
          <p><center><button type="button" <?php if($examRows < $examstart){ echo "disabled";} ?> style="background-color:<?=$theme_color?>;" onclick="window.location.href='sdc?option=exam-main&cte=<?php echo $rowType['type_id']; ?>&recommend'" data-toggle="tooltip" title="<?=$t6?> : <?php echo $rowType['type_name']; ?>" class="btn btn-block btn-success btn-lg"><?=$t5?></button></center></p>

        </div>
      </div>
    </div>
<?php } ?>

  </div>
  <!-- /.box-body -->
</div>
