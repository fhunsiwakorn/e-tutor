<a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <!-- The user image in the navbar-->
             <?php  if(empty($userRow["user_img"])){
     echo "<img src='image_system/default-user.png' class='user-image' alt='User Image'>";
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
     echo "<img src='image_system/default-user.png' class='img-circle' alt='User Image'>";
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
                 <?php
                   echo "Administrator";
                 ?>
</span>
               </small>
               </p>
             </li>

             <li class="user-footer">
               <!-- <div class="pull-left">
                 <a href="#" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
               </div> -->

                 <a href="logout.php?logout=true" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-log-out"></i> ออกจากระบบ</a>

             </li>
           </ul>
