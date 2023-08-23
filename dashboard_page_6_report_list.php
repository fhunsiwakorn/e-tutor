<?php
$stype = $connSystem->prepare("SELECT type_id, type_name FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['C']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);
 ?>
<script>
function showResult2(str) {
  if (str.length==0) { 
    document.getElementById("livesearch2").innerHTML="";
    document.getElementById("livesearch2").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch2").innerHTML=this.responseText;
      document.getElementById("livesearch2").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","dashboard_page_6_report_list_search.php?school_id=<?=$school_id?>&type_id=<?=$_GET['C']?>&q="+str,true);
  xmlhttp.send();
}

</script>
<?php
$col1=$sql_process->mf("RJV9FWIFNTT3MJ1VJASY",$language_id);
$col2=$sql_process->mf("CAMS06GZB67SNWV2HT64",$language_id);
$col3=$sql_process->mf("T0DZ3N2DFBB3K6FG61D",$language_id);
$col4=$sql_process->mf("TUV3X50URHAT5GNAWKRE",$language_id);

$t1=$sql_process->mf("17IEGFB60MGWO9Q4ZEDH",$language_id);
?>

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$sql_process->mf("NATDPVWXSL0SFA1EVPZD",$language_id)?> : <?php echo $rowEXType['type_name'];?></h3>
  </div>
  <div class="box-body">
  
  <div class="col-xs-4">
    <form action="#" method="get"name="form1"  autocomplete="off">
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="<?=$t1?>..."   onkeyup="showResult2(this.value);" >
          <span class="input-group-btn">
          <button type="button" name="search" id="search-btn" onclick="window.location.href='dashboard?option=report&C=<?=$_GET['C']?>'" class="btn btn-flat"><i class="glyphicon glyphicon-refresh"></i>
                </button>
              </span>
        </div>
      </form>
        </div>


    <div class="col-xs-12">
    <br>
    <div id="livesearch2">
      <table id="example6" class="table table-bordered table-striped">
        <thead>
        <tr>
          <!-- <th>ลำดับ</th> -->
          <th><?=$col1?></th>
          <th><?=$col2?></th>
          <th><?=$col3?></th>
          <th><?=$col4?></th>
        </tr>
        </thead>
        <tbody>
<?php
$list_stu='0';
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$total_data = $connSystem->query("SELECT  
exam_status_score.user_id
FROM exam_status_score,user_member_group 
WHERE 
 exam_status_score.user_id = user_member_group.user_id AND 
 exam_status_score.type_id='".$_GET['C']."'  AND 
 exam_status_score.school_id='$school_id'
 GROUP BY
exam_status_score.user_id
 
 ")->fetchColumn();
$rows='30';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;

$strli= $connSystem->prepare("SELECT
exam_status_score.score_id,
exam_status_score.score_total,
exam_status_score.user_id,
exam_status_score.score_date,
exam_status_score.type_id,
exam_status_score.school_id,
user_member_group.user_prefix,
user_member_group.user_firstname,
user_member_group.user_lastname
FROM
exam_status_score ,
user_member_group
WHERE
exam_status_score.user_id = user_member_group.user_id AND
exam_status_score.type_id=:type_id_param AND
exam_status_score.school_id=:school_id
GROUP BY
exam_status_score.user_id
ORDER BY
exam_status_score.score_id DESC
LIMIT 0, 30
");
$strli->execute(array(':type_id_param'=>$_GET['C'],':school_id'=>$school_id));
while($rowList = $strli->fetch(PDO::FETCH_ASSOC)) {
$list_stu++;
?>
        <tr>
          <!-- <td align="center"><?=$list_stu?></td> -->
          <td><?php echo $rowList['user_prefix'];?><?php echo $rowList['user_firstname'];?>&nbsp;&nbsp;<?php echo $rowList['user_lastname'];?></td>
          <td  align="center">
            <?php
          $numexRows = $connSystem->query("SELECT count(*) from exam_status_score WHERE user_id='".$rowList['user_id']."'and type_id='".$rowList['type_id']."'")->fetchColumn();
          echo "$numexRows ";
            ?>
          </td>
          <td  align="center">
            <button type="button"  class="btn btn-default" onclick="window.location.href='dashboard?option=report-chart&us=<?php echo $rowList['user_id']; ?>&C=<?php echo $_GET['C'];?>'" data-toggle="tooltip" title="<?=$col3?> <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/diagram_32-512.png"  width="25" height="25" >
            </button>
          </td>
          <td  align="center">
            <div class="btn-group">
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-excel?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $_GET['C'];?>'" data-toggle="tooltip" title="<?=$col4?> <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/Microsoft-Excel-2013-Logo.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.location.href='report-word?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $_GET['C'];?>'" data-toggle="tooltip" title="<?=$col4?> <?php echo $rowList['user_firstname'];?> <?php echo $rowList['user_lastname'];?>">
            <img id="myImg"  src="image_system/logo_word.png"  width="25" height="25" >
            </button>
            <button type="button"  class="btn btn-default" onclick="window.open('report-print?us=<?php echo $rowList['user_id']; ?>&C=<?php echo $_GET['C'];?>', '_blank');" />
       <img id="myImg"  src="image_system/Printer-icon.png"  width="25" height="25" >
         </button>
       </div>
          </td>

        </tr>
<?php } ?>
        </tbody>
        <tfoot>
        <tr>
          <!-- <th>ลำดับ</th> -->
          <th><?=$col1?></th>
          <th><?=$col2?></th>
          <th><?=$col3?></th>
          <th><?=$col4?></th>
        </tr>
        </tfoot>
      </table>
      </div>

      <form method="get" name="supage1">
                <nav aria-label="...">
                <input type="hidden" name="option"  value="report">
                <input type="hidden" name="C"  value="<?=$_GET['C']?>">
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="?option=report&C=<?=$_GET['C']?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="?option=report&C=<?=$_GET['C']?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                </ul>
                </nav>
              </form>  

  </div>
  <!-- /.box-body -->
</div>
