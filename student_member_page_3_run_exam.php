<style type="text/css">

#outerdiv
{
width:200px;
height:120px;
overflow:hidden;
position:relative;
}

#inneriframe
{
position:absolute;
top:-70px;
left:2px;
width:300px;
height:200px;
}


</style>
<?php
// ถ้าส่งตัวแปร navigate มา ให้โชว์วิธีการทำข้อสอบ
if(isset($_GET["navigate"])){
  $navigate="navigate";
  $begintimer=NULL;
}else{
  $navigate=NULL;
  $begintimer="begintimer";
}

// ถ้าส่งตัวแปร recommend มา ให้โชว์คำแนะนำ
if(isset($_GET["recommend"])){
  $recommend="recommend";
  $begintimer=NULL;
}else{
  $recommend=NULL;
  // $begintimer="begintimer";
}


///Time
$Timeq = $connSystem->prepare("SELECT 
         exam_time.ex_time
         FROM 
         exam_time
          WHERE
          exam_time.type_id = :type_id_param AND exam_time.user_id=:user_id_param ");
         $Timeq->execute(array(':type_id_param'=>$cte,':user_id_param'=>$user_id));
         $rowTime = $Timeq->fetch(PDO::FETCH_ASSOC);
      $ex_time_set=secondsTime($rowTime["ex_time"]);

//หลักสูตร
$stype = $connSystem->prepare("SELECT type_id, type_name,type_date FROM exam_type  WHERE type_id = :type_id_param");
$stype->execute(array(':type_id_param'=>$_GET['cte']));
$rowEXType = $stype->fetch(PDO::FETCH_ASSOC);

///ข้อสอบ
// $cte มาจาก student_member_page_2_exam_main.php


  
     $start = $connSystem->query("SELECT count(question_id) from exam_cach WHERE type_id='".$_GET['cte']."' AND user_id='$user_id' AND   school_id ='$school_id' AND success_ex='1'")->fetchColumn();
     $toppage = isset($_GET['TopicQuestion']) ? $_GET['TopicQuestion'] : $start+1; 
     if(isset($_GET['TopicQuestion'])){
      $a= $_GET['TopicQuestion']-1 ;
      if($a<=0)$a=1;
     }else{
     
         $a=$start;
       

     }
    
     $rows='1';
 

$ques = $connSystem->prepare("SELECT
exam_cach.question_id,
exam_cach.choice_id,
exam_cach.number_exam,
exam_question.question_name,
exam_question.question_sound,
exam_question.reference,
exam_question.random_status,
exam_question.type_choice
FROM
exam_cach ,
exam_question
WHERE
exam_cach.question_id = exam_question.question_id AND
exam_cach.type_id =:type_id_param AND
exam_cach.user_id =:user_id_param
ORDER BY
exam_cach.number_exam ASC
LIMIT $a, $rows
");
$ques->execute(array(':type_id_param'=>$_GET['cte'],':user_id_param'=>$user_id));
$quesEx = $ques->fetch(PDO::FETCH_ASSOC);

///Timeming
if (!isset($_SESSION['timeend'])){ 
	unset($_SESSION['timeend']);
    $endtime = time() + $ex_time_set; 
    $_SESSION['timeend'] = $endtime; 
   
} 
($_SESSION['timeend'] - time()) < 0 ? $EndTime = 0 :  $EndTime = $_SESSION['timeend'] - time();

if($EndTime <= 0) { 
	unset($_SESSION['timeend']);
//session_destroy(); 
} 

$time = gmdate("H:i:s", $EndTime); //แปลงวินาทีเป็น xx:xx:xx
// $tt=strtotime('+4 second')
include ("student_member_page_2_Update_time.php");  
require_once ('student_member_page_4_examCach.php'); //ฟังก์ชันเก็บสถานะการทำข้อสอบ
 
$t1=$sql_process->mf("LVAHN4FNGHS8FV7FGDY",$language_id);
$t2=$sql_process->mf("31IQDVVLSVBRHW6RY4",$language_id);
$t3=$sql_process->mf("AP06QVENBQNPPF6PRMJZ",$language_id);
$t4=$sql_process->mf("SC3E4R8WYTR9K19ROJ2",$language_id);
$t5=$sql_process->mf("PQICKPFY2N7CKGO2F9LU",$language_id);
$t6=$sql_process->mf("MY5UZCFTVKFNMZDB0M",$language_id);
$t7=$sql_process->mf("XMRZESVDQV2WD1CMG3",$language_id);
$t8=$sql_process->mf("XIERSN5SNUNGIWMJNIV6",$language_id);
$t9=$sql_process->mf("EGYQI2C13BXWYF5FWOP",$language_id);

$t10=$sql_process->mf("WWJR9XIDFDY2EXSBRVK",$language_id);
$t11=$sql_process->mf("7LI6P12UN6S28B8SF76X",$language_id);
$t12=$sql_process->mf("RNUJAUVB0XCUUAPSK3AP",$language_id);
$t13=$sql_process->mf("O9PQ9KMDY53USFERIUP",$language_id);
$t14=$sql_process->mf("1DA02ZIBEJICVFP1URTR",$language_id);
$t15=$sql_process->mf("8FYZU489L5HKATBCVHZZ",$language_id);
$t16=$sql_process->mf("LEMI8EIMUXMRIKM2FGPW",$language_id);
// 


?>
<script language="">
var limit="<?=$time;?>";
if (document.images){
var parselimit=limit.split(":")
parselimit=(parselimit[0]*3600)+(parselimit[1]*60)+parselimit[2]*1
//alert(parselimit);
}
function begintimer(){
if (!document.images)
return
if (parselimit==1)
// เหตุการณ์ที่ต้องการให้เกิดขึ้น
window.location='sdc?option=exam-main&cte=<?=$_GET['cte']?>&SendChk'; //////ถ้าต้องการให้กระโดดไปยัง Page อื่น
// frmTest.submit();
else{
parselimit-=1
curhr=parseInt((parselimit%86400)/3600);
curmin=parseInt((parselimit%86400)%3600/60);
cursec=parseInt(((parselimit%86400)%3600)%60);
if (curhr!==0 && curmin!=0)
curtime="<?=$t5?> <font > "+curhr+"</font> <?=$t6?> <font >"+curmin+" </font><?=$t7?> <?=$t8?> <font >"+cursec+" </font><?=$t9?> "
else
if(cursec==0 && curmin==0 && curhr==0)
{
// alert('หมดเวลาแล้วจ้า');
}
else
{
curtime="<?=$t5?> <font > "+curhr+"</font> <?=$t6?> <font >"+curmin+" </font><?=$t7?> <?=$t8?> <font >"+cursec+" </font><?=$t9?> "

}
document.getElementById('dplay').innerHTML = curtime;

setTimeout("begintimer()",1000)
}
}
// window.onload = begintimer;
window.onload = <?=$begintimer?>;
//-->
</script>



<script src="html5Audio/jquery-1.9.1.min.js"></script>
<!-- โจทย์คำถาม -->
<div class="col-md-9">
<div class="box box-default color-palette-box" >
  <div class="box-header with-border">
    <h3 class="box-title"><i class="glyphicon glyphicon-bookmark"></i>
       <?=$t1?> : <?php echo $rowEXType['type_name']; ?>
    </h3>
    <div class="box-tools pull-right">
    <?php echo $toppage; //$exRowsChk มาจากไฟล์ student_member_page_2_exam_main.php ?> / <?=$examstart?> 
    </div>
  </div>

  <div class="box-body" >
<h1>
<?php ////echo strip_tags($quesEx['question_name']);
echo $quesEx['question_name'];
 ?>
</h1>
<form name="frmMain" action="" method="post">
<button type="button" id="button"  class="btn btn-default"   data-toggle="tooltip" title="เสียงคำถาม" <?php if(empty($quesEx['question_sound'])){ echo "disabled";}?>>
      <img id="imgAvatar"  src="image_system/Speaker1.png"  width="30" height="30" >
      </button>
      </form>
      <script>
jQuery(function($){
    var audio = $('#myAudio')[0];
    $('#button').click(function(){
        if(audio.paused == true){
            audio.play();
            document.frmMain.imgAvatar.src="image_system/Speaker1.png";
        }else{
            audio.pause();
            document.frmMain.imgAvatar.src="image_system/Speaker2.png";
        }
    });
});
</script>
<audio id="myAudio">
  <source src="<?php echo $quesEx['question_sound']; ?>" type="audio/ogg">
  <source src="<?php echo $quesEx['question_sound']; ?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>



<hr>
<!-- ตัวเลือก -->
<div class="row">
  <?php
  /////คำสังเรียกโชว์ตัวเลือก


$number_choice='0';
// if($quesEx['random_status']=='1'){
// $chm = $connSystem->prepare("SELECT choice_id, choice_order,choice_name,reference,choice_sound FROM exam_choice WHERE reference = :refer_param AND type_id = :type_id_param  ORDER BY RAND()");
// }else {
// $chm = $connSystem->prepare("SELECT choice_id, choice_order,choice_name,reference,choice_sound FROM exam_choice WHERE reference = :refer_param AND type_id = :type_id_param  ORDER BY choice_order  ASC");
// }
$chm = $connSystem->prepare("SELECT choice_id, choice_order,choice_name,reference,choice_sound FROM exam_choice WHERE reference = :refer_param AND type_id = :type_id_param  ORDER BY choice_order  ASC");
//$stype->execute();
$chm->execute(array(':type_id_param'=>$_GET['cte'],':refer_param'=>$quesEx['reference']));
$resultArray=array();
while($rowChm = $chm->fetch(PDO::FETCH_ASSOC)) {
    array_push($resultArray,$rowChm);
$number_choice++;
  ?>
 <script>

// บันทึก Submit
function myFunction<?=$number_choice?>() {
document.getElementById("exam_chk<?=$number_choice?>").submit();
}
</script>

<div class="col-md-6" >
  <!-- Line chart --> 
  
  <form method="post" name="exam_chk<?=$number_choice?>" id="exam_chk<?=$number_choice?>">


    <input type="hidden" name="type_id" value="<?php echo $_GET['cte'];  ?>" >
    <input type="hidden" name="question_id" value="<?php echo $quesEx['question_id']; ?>" >
    <input type="hidden" name="choice_order"  value="<?php echo $rowChm['choice_order']; ?>">
    <input type="hidden" name="choice_id" value="<?php echo $rowChm['choice_id']; ?>">
    <div class="box box-default"
  <?php
  // if($number_choice=='1'){
  //   echo "style='background-color:#FF8C00'";
  // }elseif($number_choice=='2'){
  //   echo "style='background-color:#32CD32'";
  // }elseif ($number_choice=='3') {
  //   echo "style='background-color:#0099FF'";
  // }elseif ($number_choice=='4') {
  //   echo "style='background-color:#FF69B4'";
  // }
   ?> >
    <div class="box-header with-border" >
      <!-- <div class="radio"> -->
        <div >
            <label>

                <font>
                <?php
            if($number_choice=='1'){
              if($quesEx['type_choice']=='1'){
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>ก.</span>";
                // }else{
                //   echo"ก.";
                // }
                echo $number_choice;
               
                $topic_choice="https://od.lk/s/MzlfOTM0MjExMl8/A.mp3";
                $colorx="https://od.lk/s/MzlfOTM0MjExMV8/A-Orange.mp3";
              }elseif ($quesEx['type_choice']=='2') {
             
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>A</span>";
                // }else{
                //   echo"A";
                // }
                echo $number_choice;

              }

            }elseif ($number_choice=='2') {
              if($quesEx['type_choice']=='1'){
               
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>ข.</span>";
                // }else{
                //   echo"ข.";
                // }
                echo $number_choice;
                $topic_choice="https://od.lk/s/MzlfOTM0MjEwNl8/B.mp3";
                $colorx="https://od.lk/s/MzlfOTM0MjEwN18/B-Green.mp3";
              }elseif ($quesEx['type_choice']=='2') {
                // echo"B";
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>B</span>";
                // }else{
                //   echo"B";
                // }
                echo $number_choice;
              }


            }elseif ($number_choice=='3') {
              if($quesEx['type_choice']=='1'){
              
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>ค.</span>";
                // }else{
                //   echo"ค.";
                // }
                echo $number_choice;
                $topic_choice="https://od.lk/s/MzlfOTM0MjEwOF8/C.mp3";
                $colorx="https://od.lk/s/MzlfMTU1NDQyNjdf/C-Blue.mp3";
              }elseif ($quesEx['type_choice']=='2') {
                // echo"C";
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>C</span>";
                // }else{
                //   echo"C";
                // }
                echo $number_choice;
              }
            }elseif ($number_choice=='4') {
              if($quesEx['type_choice']=='1'){
                
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>ง.</span>";
                // }else{
                //   echo"ง.";
                // }
                echo $number_choice;
                $topic_choice="https://od.lk/s/MzlfOTM0MjExMF8/D.mp3";
                $colorx="https://od.lk/s/MzlfOTM0MjEwOV8/D-Red.mp3";
              }elseif ($quesEx['type_choice']=='2') {
                // if($rowChm['choice_id']==$quesEx['choice_id']){
                //   echo"<span style='font-size:22px' class='badge bg-red'>D</span>";
                // }else{
                //   echo"D";
                // }
                echo $number_choice;
              }
            }
                   ?>
                 </font>
               </label>

      <button type="button" id="buttonA<?=$number_choice?>"  class="btn btn-default" <?php if(empty($rowChm['choice_sound'])){ echo "disabled";}?>  data-toggle="tooltip" title="เสียง">
      <img id="imgAvatar<?=$number_choice?>"  src="image_system/Speaker1.png"  width="30" height="30" >
      </button>
      <!-- ตัวเลือก -->
      <audio id="myAudio<?=$number_choice?>" >
      <source src="<?=$topic_choice?>" type="audio/ogg">
  <source src="<?=$topic_choice?>" type="audio/mpeg">
  <source src="<?=$rowChm['choice_sound']?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<!-- สีตัวเลือก -->
<!-- <audio id="myAudio1<?=$number_choice?>" >
      <source src="<?=$colorx?>" type="audio/ogg">
  <source src="<?=$colorx?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio> -->

<!-- เสียงตัวเลือก -->
 <audio id="myAudio2<?=$number_choice?>" >
      <source src="<?=$rowChm['choice_sound']?>" type="audio/ogg">
  <source src="<?=$rowChm['choice_sound']?>" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<script>
// document.getElementById('myAudio<?=$number_choice?>').addEventListener('ended', function(){
//     this.currentTime = 0;
//     this.pause();
//     document.getElementById('myAudio2<?=$number_choice?>').play();
// }, false);

// document.getElementById('myAudio1<?=$number_choice?>').addEventListener('ended', function(){
//     this.currentTime = 0;
//     this.pause();
//     document.getElementById('myAudio2<?=$number_choice?>').play();
// }, false);

// document.getElementById('myAudio2<?=$number_choice?>').addEventListener('ended', function(){
//     this.currentTime = 0;
//     this.pause();
//     //ปิด loop ซ้ำ
//     // document.getElementById('myAudio<?=$number_choice?>').play();
// }, false);

jQuery(function($){
    // var audio = $('#myAudio<?=$number_choice?>')[0];
    var audio2 = $('#myAudio2<?=$number_choice?>')[0];
    $('#buttonA<?=$number_choice?>').click(function(){
        // if(audio.paused == true){
        //     if(audio2.paused==true){
        //       audio.play();
        //       document.exam_chk<?=$number_choice?>.imgAvatar<?=$number_choice?>.src="image_system/Speaker1.png";
        //     }else{
        //       audio.pause();
        //       audio2.pause();
        //     document.exam_chk<?=$number_choice?>.imgAvatar<?=$number_choice?>.src="image_system/Speaker2.png";
        //     }
                 
        // }else{
        //     audio.pause();
        //     document.exam_chk<?=$number_choice?>.imgAvatar<?=$number_choice?>.src="image_system/Speaker2.png";
        // }
        if(audio2.paused == true){
              audio2.play();
              document.exam_chk<?=$number_choice?>.imgAvatar<?=$number_choice?>.src="image_system/Speaker1.png";
                 
        }else{
          audio2.pause();
            document.exam_chk<?=$number_choice?>.imgAvatar<?=$number_choice?>.src="image_system/Speaker2.png";
        }

    });
});
</script>


        </div>


    </div>

    <div class="box-body"  onclick="myFunction<?=$number_choice?>();"  style="cursor: pointer;">
      <div class="direct-chat-messages"  style="height:100px;">
      <h2><?php ///echo strip_tags($rowChm['choice_name']); 
	  echo $rowChm['choice_name'];?></h2>
      </div>
    </div>
   

    <!-- /.box-body-->
  </div>
  <!-- /.box -->
 
</form>
</div>



<?php } ?>

</div>


<nav aria-label="...">
  <ul class="pager">
    <li class="previous <?php if($toppage <=1){ echo "disabled";} ?>" ><a href="?option=<?=$_GET["option"]?>&cte=<?=$_GET['cte']?>&TopicQuestion=<?=$toppage-1?>"><span aria-hidden="true">&larr;</span> <?=$t2?></a></li>
    <li class="next"><a href="?option=<?=$_GET["option"]?>&cte=<?=$_GET['cte']?>&TopicQuestion=<?=$toppage+1?>"><?=$t3?> <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav>

  </div>
  <!-- /.box-body-->
  </div>
</div>
<!-- /.box -->
<div class="col-md-3">
<center><h4><span id="dplay" ><?php echo $time?></span></h4></center>
</div>
<!-- แสดงจำนวนข้อที่ทำ -->
<div class="col-md-3">
  <div class="box box-default color-palette-box" >
  
    <div class="box-header with-border"> 
    
   

<table style="text-align: left; width: 100%;" >
  <tbody>
    <tr>
      <td colspan="1" rowspan="3">
      <div class="thumbnail">
      <?php  if(empty($userRow["user_img"])){
     echo "<img src='image_system/aaaa.png' style='height:75px; width:70px;' alt='User Image'>";
    }else{

     echo "<img src='images_user/$userRow[user_img]' style='height:75px; width:70px;' alt='User Image'>";
    }
    ?>
  </div>
      </td>
      <td> &nbsp;  <?=$t10?>:  <?php
       echo $userRow["user_firstname"];
       echo"&nbsp;&nbsp;&nbsp;";
         echo $userRow["user_lastname"];?>
      </td>
    </tr>
    <tr>
      <td> &nbsp;  <?=$t11?>: <?php echo $userRow["user_id_card"];?>
         </td>
    </tr>
    <tr>
      <td> &nbsp;  <?=$t12?>: <?=$t13?> </td>
    </tr>
  </tbody>
</table>

<table style="text-align: left; width: 100%;" >
  <tbody>
    <tr>
      <td width="50%"> <a  hrdf="#"  class="btn btn-block btn-default" data-toggle="modal" data-target="#navigate2" style="background-color:#50e569;"><font color="#ffffff"><?=$t14?></font></a> </td>
      <td width="50%"> <a href="sdc?option=exam-main&cte=<?=$_GET['cte']?>&SendChk" class="btn btn-block btn-default" onclick="return confirm('<?=$t16?> ? ')" style="background-color:<?=$theme_color?>;" ><font color="#ffffff"><?=$t15?></font></a> </td>
    </tr>
  </tbody>
</table>


   
   

    


  
    <hr>
<div align="left">
 
    <?php  for($i=1;$i<=$examstart ;$i++) { //วนลูปโชว์จำนวนข้อสอบถึง 50 ข้อ
         $numberqu = $connSystem->prepare("SELECT 
         exam_choice.choice_order,
          exam_cach.number_exam 
         FROM 
         exam_cach ,
          exam_choice
          WHERE
          exam_cach.choice_id = exam_choice.choice_id AND
          exam_cach.type_id = :type_id_param AND exam_cach.user_id=:user_id_param AND exam_cach.number_exam='$i'");
         $numberqu->execute(array(':type_id_param'=>$_GET['cte'],':user_id_param'=>$user_id));
         $rowqu = $numberqu->fetch(PDO::FETCH_ASSOC);
        //  if($rowqu["number_exam"]==$i){}
      ?>



 <div class="col-xs-6" >

 <span  onclick="window.location.href='sdc?option=exam-main&cte=<?=$_GET['cte']?>&TopicQuestion=<?=$i?>'" style="cursor: pointer;" >
<?=$t4?> <?=$i?>
  <font style="color: red;">
  <?php
 echo $rowqu["choice_order"];

//  if($rowqu["choice_order"]=='1'){
//   if($quesEx['type_choice']=='1'){
//     echo"ก.";
//   }elseif ($quesEx['type_choice']=='2') {
//     echo"A";
//   }

// }elseif ($rowqu["choice_order"]=='2') {
//   if($quesEx['type_choice']=='1'){
//     echo"ข.";
//   }elseif ($quesEx['type_choice']=='2') {
//     echo"B";
//   }

// }elseif ($rowqu["choice_order"]=='3') {
//   if($quesEx['type_choice']=='1'){
//     echo"ค.";
//   }elseif ($quesEx['type_choice']=='2') {
//     echo"C";
//   }
// }elseif ($rowqu["choice_order"]=='4') {
//   if($quesEx['type_choice']=='1'){
//     echo"ง.";
//   }elseif ($quesEx['type_choice']=='2') {
//     echo"D";
//   }
// }
  
  ?>
  
  </font>

 </span>

</div>

    <?php } ?>





    </div>



      </div>
  </div>
</div>


<!-- Modal Shows <?=$t14?> school -->
<div class="modal fade" id="<?=$navigate?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$t14?></h4>
      </div>
      <div class="modal-body">
        <div class="row">

                 <div class="col-xs-12">
                

1. <?=$sql_process->mf("4BOVFEDCEYBPF6R8M6Z",$language_id)?> <br>
2. <?=$sql_process->mf("CSDXV0RRYSPNBT9WDUG7",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("4AUJCR54A66DNZ1IEWBE",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("DA2XDGYVP6GXM0389VK",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("MD7PAHRCB115HQE3GD",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("6MGMS1EN97G3RC6NKETC",$language_id)?> <br>
3. <?=$sql_process->mf("KETPRMBJT2WODX9XL8BY",$language_id)?> <br>
4. <?=$sql_process->mf("ZDRUT8PIKQ16Z70WON1G",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("LNEDQCICMM6A4C00LGY",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("C8XET65CQFXVDY5DD9RZ",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("5JN6DJWZE4MDSR3XSCH",$language_id)?> <br>
<?=$sql_process->mf("SV263NF316DKO6PTWT",$language_id)?> <br>
5. <?=$sql_process->mf("OW8EQ86KNK2HP9QEJXP9",$language_id)?> <br>

                </div>
              

            </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button> -->
        <center>  <button type="button" class="btn btn-default"  onclick="window.location.href='sdc?option=exam-main&cte=<?=$_GET['cte']?>'" style="background-color:<?=$theme_color?>;" data-dismiss="modal"><font color="#ffffff"><?=$sql_process->mf("XU9Z8SHC71YBT071TW6",$language_id)?></font></button></center>
      </div>
    </div>

  </div>
</div>

<!-- Modal Shows <?=$t14?>2 school -->
<div class="modal fade" id="navigate2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$t14?></h4>
      </div>
      <div class="modal-body">
        <div class="row">

                 <div class="col-xs-12">
                

<!-- <img src="image_system/navigate.PNG" style='height:100%; width:100%;' /> -->
1. <?=$sql_process->mf("4BOVFEDCEYBPF6R8M6Z",$language_id)?> <br>
2. <?=$sql_process->mf("CSDXV0RRYSPNBT9WDUG7",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("4AUJCR54A66DNZ1IEWBE",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("DA2XDGYVP6GXM0389VK",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("MD7PAHRCB115HQE3GD",$language_id)?> <br>
&nbsp;&nbsp;<?=$sql_process->mf("6MGMS1EN97G3RC6NKETC",$language_id)?> <br>
3. <?=$sql_process->mf("KETPRMBJT2WODX9XL8BY",$language_id)?> <br>
4. <?=$sql_process->mf("ZDRUT8PIKQ16Z70WON1G",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("LNEDQCICMM6A4C00LGY",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("C8XET65CQFXVDY5DD9RZ",$language_id)?> <br>
&nbsp;&nbsp; - <?=$sql_process->mf("5JN6DJWZE4MDSR3XSCH",$language_id)?> <br>
<?=$sql_process->mf("SV263NF316DKO6PTWT",$language_id)?> <br>
5. <?=$sql_process->mf("OW8EQ86KNK2HP9QEJXP9",$language_id)?> <br>
                </div>
                

            </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button> -->
        <center>  <button type="button" class="btn btn-default"   style="background-color:<?=$theme_color?>;" data-dismiss="modal"><font color="#ffffff"><?=$sql_process->mf("XU9Z8SHC71YBT071TW6",$language_id)?></font></button></center>
      </div>
    </div>

  </div>
</div>

<!-- Modal Shows <?=$t14?> school -->

<div class="modal fade" id="<?=$recommend?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$sql_process->mf("GJI02JNWW1II0T8GTZ1",$language_id)?></h4>
      </div>
      <div class="modal-body">
        <div class="row">

                 <div class="col-xs-12">
               <h4> -  <?=$sql_process->mf("GXJWJFHPTE3EP62B3M51",$language_id)?> </h4> <br>

               <h4> - <?=$sql_process->mf("85I184UMLU1A512ICCC",$language_id)?></h4> <br>

                </div>
              

            </div>
      </div>
      <div class="modal-footer"> 
      <!-- btn btn-default btn-block btn-flat -->
      <center>  <button type="button" class="btn btn-default" onclick="window.location.href='sdc?option=exam-main&cte=<?=$_GET['cte']?>&navigate'" style="background-color:<?=$theme_color?>;" data-dismiss="modal"><font color="#ffffff"><?=$sql_process->mf("FFQVZVT85CFCB02ELYN",$language_id)?></font></button></center>
      
      </div>
    </div>

  </div>
</div>

