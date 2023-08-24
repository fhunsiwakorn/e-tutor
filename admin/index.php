<?php
session_start();
include("ConfigName.php");
require_once("class.user.php");
$login = new USER();
if (isset($_POST['btn-login'])) {
  $uname = strip_tags($_POST['txt_uname_email']);
  $umail = strip_tags($_POST['txt_uname_email']);
  $upass = strip_tags($_POST['txt_password']);

  if ($login->doLogin($uname, $umail, $upass)) {

    $login->redirect('dashboard_admin.php');
  } else {
    $error = "Wrong Details !";
  }
}

require_once('ConfigDB.php');
require_once('chek_student.php');


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= $LOGO ?>" />

  <link rel="stylesheet" href="flat-login-form/css/reset.css">

  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Montserrat:400,700'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

  <link rel="stylesheet" href="flat-login-form/css/style.css">
  <script src="sweetalert_master/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="sweetalert_master/sweetalert.css">
  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }

    h1 {
      font-family: 'Kanit', sans-serif;
    }

    h2 {
      font-family: 'Kanit', sans-serif;
    }

    h3 {
      font-family: 'Kanit', sans-serif;
    }

    h4 {
      font-family: 'Kanit', sans-serif;
    }

    div {
      font-family: 'Kanit', sans-serif;
    }

    label {
      font-family: 'Kanit', sans-serif;
    }
  </style>



</head>

<body>
  <div id="error">
    <?php
    if (isset($error)) {
    ?>
      <script>
        swal("Username และ Password  ไม่ถูกต้อง !", "ปิดหน้าต่างนี้ !", "error");
      </script>
      <!-- <div class="alert alert-danger">
               <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
            </div> -->
    <?php } ?>
  </div>

  <div class="container">
    <div class="info">
      <h1>ระบบจัดการฐานข้อมูล </h1><?= $name_program ?>

    </div>
  </div>
  <div class="form">
    <!-- <div class="thumbnail"> -->
    <!-- <div ><img src="https://od.lk/s/MzlfOTM0OTkwMF8/SDC_resize.png" style="width:150px; height:150px"/></div> -->
    <form class="login-form" method="post">
      <input type="text" name="txt_uname_email" placeholder="username" autocomplete="off" required />
      <input type="password" name="txt_password" placeholder="password" autocomplete="off" required />
      <button name="btn-login" type="submit">login</button>
      <!-- <p class="message">Not registered? <a href="#">Create an account</a></p> -->
    </form>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  <script src="flat-login-form/js/index.js"></script>


  <?php
  // close connection
  $connSystem = null;
  ?>
</body>

</html>