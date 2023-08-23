<style>
#container {
	min-width: 320px;
	max-width: 600px;
	margin: 0 auto;
}
</style>
<?php  $year = date("Y");  ?>

<!-- BAR CHART -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><?=$sql_process->mf("QSFIRW0NZ64URT7KAM",$language_id);?></h3>

            <div class="box-tools pull-right">

              <?php
              if(isset($_POST['sty'])){
                $rows_year=$_POST['sty'];
              }else {
                $rows_year=$year;
              }

               ?>
              <form method="post" name="search_year">
              <div class="form-group">
                    <select class="form-control" name="sty" onchange="submit();">

                      <?php
                      echo '<option value="'.$rows_year.'">'.$rows_year.'</option>';
                      for($i=2017;$i<=2050;$i++){
                      $i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
                      echo '<option value="'.$i2.'">'.$i2.'</option>';
                        }
                        ?>
                    </select>
                  </div>
            </form>
            </div>
          </div>
          <div class="box-body">

            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/highcharts-more.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div id="container"></div>
            <button id="plain" class="btn btn-warning" style="background-color:<?=$theme_color?>;">Plain</button>
            <button id="inverted" class="btn btn-warning" style="background-color:<?=$theme_color?>;">Inverted</button>
            <button id="polar" class="btn btn-warning" style="background-color:<?=$theme_color?>;">Polar</button>



          </div>
          <!-- /.box-body -->
        </div>

<?php
$JanuaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '1' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$FebruaryRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '2' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$MarchRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '3' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
$AprilRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '4' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
$MayRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '5' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$JuneRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '6' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
$JulyRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '7' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
$AugustRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '8' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$SeptemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '9' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$OctoberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '10' AND YEAR(user_date_start) = '$rows_year'  AND school_id='$school_id'")->fetchColumn();
$NovemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '11' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
$DecemberRows = $connSystem->query("SELECT count(*) from user_member_group WHERE user_status='2' AND MONTH(user_date_start) = '12' AND YEAR(user_date_start) = '$rows_year' AND school_id='$school_id'")->fetchColumn();
 ?>
<script> 
var chart = Highcharts.chart('container', {

    title: {
        text: '<?=$sql_process->mf("AMMY16NLBO6L1OYCST",$language_id);?>'
    },

    subtitle: {
        text: '<?=$sql_process->mf("CW0YQL665VW0AK8HRP6C",$language_id)?> <?php echo"$rows_year";  ?>'
    },

    xAxis: {
        categories: [
            '<?=$sql_process->mf("ICLVL52IUIK588VT0OA",$language_id);?>',
            '<?=$sql_process->mf("LOGPW48YTF1PJFWRQ",$language_id);?>',
            '<?=$sql_process->mf("VM8MP0UQRX2VBMB361OD",$language_id);?>',
            '<?=$sql_process->mf("9629M8ZEQ5J3QCPECXL",$language_id);?>',
            '<?=$sql_process->mf("M7ZE4T6LH1S9T9JX9HE3",$language_id);?>',
            '<?=$sql_process->mf("O70DTAZCIBDCYCBGDWLQ",$language_id);?>',
            '<?=$sql_process->mf("WTAK8BO4MIRHVHCGC8AF",$language_id);?>',
            '<?=$sql_process->mf("VV1MP1ITV5STHAUO1ZNI",$language_id);?>',
            '<?=$sql_process->mf("IQ7BBVE176ICI2ZBSQ8O",$language_id);?>',
            '<?=$sql_process->mf("HO7SJPZXE2LQOIP1KZ9A",$language_id);?>',
            '<?=$sql_process->mf("A9Y0ASQA10E4YXQ4OVD",$language_id);?>',
            '<?=$sql_process->mf("WVTJ6YHNQNR48RCXAEG",$language_id);?>'
          ]
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
