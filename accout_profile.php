<a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <!-- The user image in the navbar-->
             <?php  if(empty($userRow["user_img"])){
     echo "<img src='image_system/aaaa.png' class='user-image' alt='User Image'>";
    }else{

     echo "<img src='images_user/$userRow[user_img]' class='user-image' alt='User Image'>";
    }
      ?>
             <!-- hidden-xs hides the username on small devices so only the image appears. -->
             <span class="hidden-xs"> <?php
       echo $userRow["user_firstname"];
       echo"&nbsp;&nbsp;&nbsp;";
         echo $userRow["user_lastname"];?></span>
           </a>
           <ul class="dropdown-menu">
             <!-- The user image in the menu -->
             <li class="user-header" style="background-color:<?=$theme_color?>;">

       <?php  if(empty($userRow["user_img"])){
     echo "<img src='image_system/aaaa.png' class='img-circle' alt='User Image'>";
    }else{

     echo "<img src='images_user/$userRow[user_img]' class='img-circle' alt='User Image'>";
    }
      ?>
               <p>
                <?php echo $userRow["user_firstname"];
     echo"&nbsp;&nbsp;&nbsp;";
              echo $userRow["user_lastname"];?>
               <small>
               <span  style="font-size:20px;">
                 <?php if($user_status == "1"){
                  //  echo "เจ้าหน้าที่โรงเรียน";
                   echo $sql_process->mf("IYYR02CT2DHX0MQL6",$language_id);
                 }elseif ($user_status == "2") {
                  //  echo "ผู้เข้าสอบ/ติวสอบ";
                   echo $sql_process->mf("QN1C1F6YXXB61H8XBWE",$language_id);
                 }
                 ?>
</span>
               </small>
               </p>
             </li>

             <li class="user-footer">
               <!-- <div class="pull-left">
                 <a href="#" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
               </div> -->

                 <a href="logout.php?logout=true" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-log-out"></i> <?=$sql_process->mf("GEXLN3IO7XHRE53SGG49",$language_id)?></a>
               
             </li>
           </ul>
