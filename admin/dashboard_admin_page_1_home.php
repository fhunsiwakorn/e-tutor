<style>
#container {
	min-width: 320px;
	max-width: 600px;
	margin: 0 auto;
}
</style>
<?php  $year = date("Y");
if(isset($_POST['sty'])){
  $rows_year=$_POST['sty'];
}else {
  $rows_year=$year;
}

 ?>

<div class="col-md-9">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">รายงานเบื้องต้น</h3>
          </div>
          <div class="box-body">

            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/highcharts-more.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div id="container"></div>
            <button id="plain" class="btn btn-warning"  style="background-color:<?=$theme_color?>;">Plain</button>
            <button id="inverted" class="btn btn-warning"  style="background-color:<?=$theme_color?>;">Inverted</button>
            <button id="polar" class="btn btn-warning"  style="background-color:<?=$theme_color?>;">Polar</button>



          </div>
          <!-- /.box-body -->
        </div>
  </div>

  <div class="col-md-3">
    <div class="box box-default color-palette-box" >
      <div class="box-header with-border">

                      <form method="post" name="search_year">
                        <select class="form-control select2"  name="school"  style="width:100%">
                          <?php

                          $rcp_get = $connSystem->prepare("SELECT school_id, school_name FROM tbl_school  WHERE school_id = :school_id");
                          $rcp_get->execute(array(':school_id'=>$_POST['school']));
                          $rowGet = $rcp_get->fetch(PDO::FETCH_ASSOC);
                          $school_id_get=  $rowGet['school_id'];
                          $school_name_get=$rowGet['school_name'];
                          if(!empty($_POST['school'])) {
                          echo "<option value='$school_id_get'  selected='selected'>$school_name_get</option>" ;
                           }
                             echo "<option value=''  '>--เลือกรายงานเฉพาะโรงเรียน--</option>" ;
                          $rcp = $connSystem->prepare("SELECT school_id, school_name FROM tbl_school  ORDER By school_id DESC");
                          $rcp->execute();
                          while($rowRCP = $rcp->fetch(PDO::FETCH_ASSOC)) {
                          $school_id_search=  $rowRCP['school_id'];
                          $school_name=$rowRCP['school_name'];

                          echo "<option value='$school_id_search'>$school_name</option>" ;
                        }
                        ?>
                        </select>
                      <div class="form-group">
                            <select class="form-control" name="sty" >

                              <?php
                              echo '<option value="'.$rows_year.'">'.$rows_year.'</option>';
                              for($i=2017;$i<=2050;$i++){
                              $i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
                              echo '<option value="'.$i2.'">'.$i2.'</option>';
                                }
                                ?>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-block btn-success btn-sm"  style="background-color:<?=$theme_color?>;">ค้นหา</button>
                          </div>
                    </form>
        </div>
    </div>
  </div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<?php
if(isset($_POST['school']) && !empty($_POST['school'])){
$school_id_st=$_POST['school'];
$stuRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id_st'")->fetchColumn();
}else {
$stuRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND YEAR(user_date_start) = '$rows_year'")->fetchColumn();
}
	 ?>
          <div class="info-box" >
            <span class="info-box-icon">
          
            <i class="ion ion-ios-people-outline"></i> 
            </span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนนักเรียน</span>
              <span class="info-box-number"><?=$stuRows?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
			if(isset($_POST['school']) && !empty($_POST['school'])){
			$school_id_st=$_POST['school'];
			$auRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='1'  AND school_id='$school_id_st'")->fetchColumn();
			}else {
			$auRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='1'  ")->fetchColumn();
			}
				 ?>
			          <div class="info-box">
			            <span class="info-box-icon"><i class="glyphicon glyphicon-user"></i></span>

			            <div class="info-box-content">
			              <span class="info-box-text">จำนวนเจ้าหน้าที่</span>
			              <span class="info-box-number"><?=$auRows?></span>
			            </div>
			            <!-- /.info-box-content -->
			          </div>
			          <!-- /.info-box -->
			        </div>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<?php
						if(isset($_POST['school']) && !empty($_POST['school'])){
						$school_id_st=$_POST['school'];
						$teRows = $connSystem->query("SELECT count(*) from exam_status_score WHERE YEAR(score_date) = '$rows_year'  AND school_id='$school_id_st'")->fetchColumn();
						}else {
						$teRows = $connSystem->query("SELECT count(*) from exam_status_score WHERE YEAR(score_date) = '$rows_year' ")->fetchColumn();
						}
							 ?>
						          <div class="info-box">
						            <span class="info-box-icon"><i class="glyphicon glyphicon-blackboard"></i></span>

						            <div class="info-box-content">
						              <span class="info-box-text">จำนวนการทำข้อสอบ</span>
						              <span class="info-box-number"><?=$teRows?></span>
						            </div>
						            <!-- /.info-box-content -->
						          </div>
						          <!-- /.info-box -->
						        </div>

<?php
if(isset($_POST['school']) && !empty($_POST['school'])){
  $school_id=$_POST['school'];

  $JanuaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '1' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $FebruaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '2' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $MarchRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '3' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
  $AprilRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '4' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
  $MayRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '5' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $JuneRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '6' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
  $JulyRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '7' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
  $AugustRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND  MONTH(user_date_start) = '8' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $SeptemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '9' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $OctoberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '10' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
  $NovemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '11' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
  $DecemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '12' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
}else {
  $JanuaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '1' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
  $FebruaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '2' AND YEAR(user_date_start) = '$rows_year'  ")->fetchColumn();
  $MarchRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '3' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
  $AprilRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '4' AND YEAR(user_date_start) = '$rows_year'")->fetchColumn();
  $MayRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '5' AND YEAR(user_date_start) = '$rows_year'  ")->fetchColumn();
  $JuneRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '6' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
  $JulyRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '7' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
  $AugustRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '8' AND YEAR(user_date_start) = '$rows_year'  ")->fetchColumn();
  $SeptemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '9' AND YEAR(user_date_start) = '$rows_year'")->fetchColumn();
  $OctoberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '10' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
  $NovemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '11' AND YEAR(user_date_start) = '$rows_year'")->fetchColumn();
  $DecemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '12' AND YEAR(user_date_start) = '$rows_year' ")->fetchColumn();
}


if(!$school_name_get){
  $shows="ท้้งหมด";
}else {
  $shows="<br>".$school_name_get;
}
 ?>
<script>
var chart = Highcharts.chart('container', {

    title: {
        text: 'กราฟแสดงจำนวนนักเรียนต่อเดือนในแต่ละช่วงปี<?=$shows?>'
    },

    subtitle: {
        text: 'ปี <?php echo"$rows_year";  ?>'
    },

    xAxis: {
        categories: [
          'มกราคม',
          'กุมภาพันธ์',
          'มีนาคม',
          'เมษายน',
          'พฤษภาคม',
          'มิถุนายน',
          'กรกฎาคม',
          'สิงหาคม',
          'กันยายน',
          'ตุลาคม',
          'พฤศจิกายน',
          'ธันวาคม']
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: [<?=$JanuaryRows?>,<?=$FebruaryRows?>, <?=$MarchRows?>, <?=$AprilRows?>, <?=$MayRows?>, <?=$JuneRows?>,<?=$JulyRows?>, <?=$AugustRows?>, <?=$SeptemberRows?>, <?=$OctoberRows?>, <?=$NovemberRows?>, <?=$DecemberRows?>],
        showInLegend: false
    }]

});


$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});

</script>
