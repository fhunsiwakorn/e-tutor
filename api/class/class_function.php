<?php

///สร้างรหัส
function random_password($max_length = 20)
{
    $text = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $text_length = mb_strlen($text, 'UTF-8');
    $pass = '';
    for ($i = 0; $i < $max_length; $i++) {
        $pass .= @$text[rand(0, $text_length)];
    }
    return $pass;
}



function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function DateThaiTime($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    // $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
//คำนวนอายุ
function getAge($birthday)
{
    // $timestamp = strtotime('16-11-2019'); กรณีจะหาอายุโดยคำนวนจากปีที่ระบุ ให้เปลี่ยน time() เป็น $timestamp 
    $then = strtotime($birthday);
    return (floor((time() - $then) / 31556926));
}

function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
}
function TimeDiff($strTime1, $strTime2)
{
    return (strtotime($strTime2) - strtotime($strTime1)) /  (60 * 60); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1, $strDateTime2)
{
    return (strtotime($strDateTime2) - strtotime($strDateTime1)) /  (60 * 60); // 1 Hour =  60*60
}

//  echo "Date Diff = ".DateDiff("2008-08-01","2008-08-31")."<br>";
//  echo "Time Diff = ".TimeDiff("00:00","19:00")."<br>";
//  echo "Date Time Diff = ".DateTimeDiff("2008-08-01 00:00","2008-08-01 19:00")."<br>";
//    DateTime::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
function DMYtoYMD($sendDate)
{
    ///2018-03-19
    $arrstartx2 = explode("/", $sendDate);
    $stday2 = $arrstartx2[0];
    $stmonth2 = $arrstartx2[1];
    $styear2 = $arrstartx2[2];
    $format_date = "$styear2-$stmonth2-$stday2";

    return $format_date;
}
function YMDtoDatetimelocal($sendDate)
{
    // $date = date_create($sendDate);
    // $format_date = date_format($date, "Y-m-d" . "T" . "H:i:s");

    $cut = explode(" ", $sendDate);

    $arrstartx = explode("-", $cut[0]);
    $styear = $arrstartx[0];
    $stmonth = $arrstartx[1];
    $stday = $arrstartx[2];
    $format_date = "$styear-$stmonth-$stday" . "T" . "$cut[1]";

    return $format_date;
}

function YMDtoDMY($sendDate)
{
    // 10/05/2018

    $arrstartx = explode("-", $sendDate);
    $styear = $arrstartx[0];
    $stmonth = $arrstartx[1];
    $stday = $arrstartx[2];
    $format_date = "$stday/$stmonth/$styear";
    return $format_date;
}

function DMYtoYMDTime($sendDate)
{

    $cut = explode(" ", $sendDate);

    // 10/05/2018
    $arrstartx = explode("/", $cut[0]);
    $stday = $arrstartx[0];
    $stmonth = $arrstartx[1];
    $styear = $arrstartx[2];
    $format_date = "$styear-$stmonth-$stday" . " $cut[1]";
    return $format_date;
}

function DatetoDMYth($sendDate)
{
    // 10/05/2018

    $arrstartx = explode("-", $sendDate);
    $styear = $arrstartx[0] + 543;
    $stmonth = $arrstartx[1];
    $stday = $arrstartx[2];
    $format_date = "$stday/$stmonth/$styear";
    return $format_date;
}
function DatetoDMYTime($sendDate)
{
    // $cut = explode(" ", $sendDate);

    // $arrstartx = explode("-", $cut[0]);
    // $styear = $arrstartx[0] + 543;
    // $stmonth = $arrstartx[1];
    // $stday = $arrstartx[2];
    // $format_date = "$stday/$stmonth/$styear" . " $cut[1]";
    $date = date_create($sendDate);
    $format_date = date_format($date, "d/m/Y H:i:s");
    return $format_date;
}

///ลบไฟล์
function delfile($namefile, $pathfile)
{
    $del_img_file = "$pathfile" . "/" . "$namefile";
    @unlink($del_img_file);
    return true;
}

/// Resize รูปภาพ
function resize_img($tarGetFile)
{

    $images = $tarGetFile;
    $new_images = $tarGetFile;
    ///ตรวจสอบไฟล์
    $arraypic = explode(".", $tarGetFile);
    $filetype = end($arraypic); //นามสกุลไฟล์  
    $width = 200; //*** Fix Width & Heigh (Autu caculate) ***//
    $size = GetimageSize($images);
    $height = round($width * $size[1] / $size[0]);
    // $images_orig = ImageCreateFromJPEG($images);
    switch (strtolower($filetype)) {
        case 'png':
            $images_orig = imagecreatefrompng($images);
            break;
        case 'gif':
            $images_orig = imagecreatefromgif($images);
            break;
        case 'jpeg':
            $images_orig = imagecreatefromjpeg($images);
            break;
        case 'jpg':
            $images_orig = imagecreatefromjpeg($images);
            break;
        default:
            $images_orig =  imagecreatefromjpeg($images);
    }



    $photoX = ImagesX($images_orig);
    $photoY = ImagesY($images_orig);
    $images_fin = ImageCreateTrueColor($width, $height);
    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
    // ImageJPEG($images_fin,$new_images);
    switch (strtolower($filetype)) {
        case 'png':
            imagepng($images_fin, $new_images);
            break;
        case 'gif':
            imagegif($images_fin, $new_images);
            break;
        case 'jpeg':
            imagejpeg($images_fin, $new_images);
            break;
        case 'jpg':
            imagejpeg($images_fin, $new_images);
            break;
        default:
            imagejpeg($images_fin, $new_images);
    }

    ImageDestroy($images_orig);
    ImageDestroy($images_fin);
}

function add_file($tmp_name, $name, $pathimg)
{
    $name = $name;
    $tem = $tmp_name;
    $arrayfile = explode(".", $name);
    $filetype =  end($arrayfile); //นามสกุลไฟล์
    if (
        strtolower($filetype) == "pdf" ||  strtolower($filetype) == "doc" || strtolower($filetype) == "xls" || strtolower($filetype) == "ppt" || strtolower($filetype) == "docx" || strtolower($filetype) == "xlsx" || strtolower($filetype) == "pptx" ||
        strtolower($filetype) == "jpg" || strtolower($filetype) == "png"  || strtolower($filetype) == "jpeg" || strtolower($filetype) == "gif"
    ) {
        $file_name = mt_rand() . "." . $filetype;  ////Randomชื่อรูปภาพ
        copy($tem, "$pathimg" . $file_name); //อัพโหลดไปยัง folder
        return  $file_name;
    } else {
        return false;
    }
}


// วันที่ ไป ยัง Timestamp
function dateToTimeStamp($datetime)
{
    $exp = explode(" ", $datetime);
    $t = explode(":", $exp[1]);
    $d = explode("-", $exp[0]);
    $timestamp = mktime($t[0], $t[1], $t[2], $d[1], $d[2], $d[0]);
    return $timestamp;
}

// Timestame ไปยังวันที่
function timeStampToDate($timestamp)
{
    //    $timestamp= date("Y-m-d H:i:s", $timestamp);
    $timestamp = date("Y-m-d", $timestamp);
    return $timestamp;
}

//LiNE Notify 
function send_line_notify($message, $token)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=$message");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token",);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
// $message = 'โอตะ 2019';
// $token = 'NOv7KYg5kMWkcTqPrWIBWYNNag20FH0bybTHO3fIXN9';

//    echo send_line_notify($message, $token);


// png=รูป ,css=ไฟล์css, javascript=ไฟล์ js

function base64_encode_image($filename)
{
    if ($filename) {
        $exp = explode(".", $filename);
        $filetype = $exp[1];
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . "png" . ';base64,' . base64_encode($imgbinary);
    }
}

function base64_encode_css($filename)
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:text/' . "css" . ';base64,' . base64_encode($imgbinary);
    }
}
function base64_encode_jspath($filename)
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:text/' . "javascript" . ';base64,' . base64_encode($imgbinary);
    }
}
// เปลี่ยนค่าติดลบ เป็น 0 
function positive_number($value)
{
    return ($value = (float) $value) < 0 ? 0 : $value;
}

////ลบไฟล์มั้งหมดใน folder
function remove_dir($dir)
{
    if (is_dir($dir)) {
        $dir = (substr($dir, -1) != "/") ? $dir . "/" : $dir;
        $openDir = opendir($dir);
        while ($file = readdir($openDir)) {
            if (!in_array($file, array(".", ".."))) {
                if (!is_dir($dir . $file)) {
                    @unlink($dir . $file);
                } else {
                    remove_dir($dir . $file);
                }
            }
        }
        closedir($openDir);
        ///ลบ folder
        // @rmdir($dir);
    }
}
///Send Data object
function post_action($redirect, $table, $type, $token)
{
    //type=> insert= บันทึกข้อมูลปกติ ,update =แก้ไขข้อมูลปกติ,updatemulti=แก้ไขข้อมูลหลายเรคคอร์ด ,del = ลบข้อมูลปกติ ,
    //  delcon = ลบข้อมูลแต่ยังคงเก้บข้อมูลไว้  ,del_get= ลบข้อมูลแต่ยังคงเก้บข้อมูลไว้(แบบ get)
    $redirect_1 = base64_encode($redirect);
    $table_1 = base64_encode($table);

    $action = "object/?" . "line=queryGeneral&" . "re_link=$redirect_1&" . "table=$table_1&" . "type=$type&" . "token=$token";
    return    $action;
}
function get_action($redirect, $table, $type, $token, $condition)
{
    //type=> insert= บันทึกข้อมูลปกติ ,update =แก้ไขข้อมูลปกติ,updatemulti=แก้ไขข้อมูลหลายเรคคอร์ด ,del = ลบข้อมูลปกติ ,
    //  delcon = ลบข้อมูลแต่ยังคงเก้บข้อมูลไว้ ,del_get= ลบข้อมูลแต่ยังคงเก้บข้อมูลไว้(แบบ get)
    $redirect_1 = base64_encode($redirect);
    $table_1 = base64_encode($table);

    $action = "object/?" . "line=queryGeneral&" . "re_link=$redirect_1&" . "table=$table_1&" . "type=$type&" . "token=$token&" . "condition=$condition";
    return    $action;
}

function redirect_js($link)
{
    $script = "<script>";
    $script .= "location.href = '$link'";
    $script .= "</script>";
    return $script;
}

function cross($value)
{

    $result = $value == NULL || $value == FALSE ? "-" : $value;
    return    $result;
}


/**
 * Date range
 *
 * @param $first
 * @param $last
 * @param string $step
 * @param string $format
 * @return array
 */
////Loop date
function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
{
    $dates = [];
    $current = strtotime($first);
    $last = strtotime($last);

    while ($current <= $last) {

        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}

//////ฟังก์ชันหาเดือน โดยจาก m
function ConvertmontThai($date)
{


    switch ($date) {
        case "1":
            $month_receive = "มกราคม";
            break;
        case "2":
            $month_receive = "กุมภาพันธ์";
            break;
        case "3":
            $month_receive = "มีนาคม";
            break;
        case "4":
            $month_receive = "เมษายน";
            break;
        case "5":
            $month_receive = "พฤษภาคม";
            break;
        case "6":
            $month_receive = "มิถุนายน";
            break;
        case "7":
            $month_receive = "กรกฎาคม";
            break;
        case "8":
            $month_receive = "สิงหาคม";
            break;
        case "9":
            $month_receive = "กันยายน";
            break;
        case "10":
            $month_receive = "ตุลาคม";
            break;
        case "11":
            $month_receive = "พฤศจิกายน";
            break;
        case "12":
            $month_receive = "ธันวาคม";
            break;
    }

    return $month_receive;
}

//////ฟังก์ชันหาเดือน โดยจาก Y-m-d 
function ConvertmontThaiyear($date)
{
    $arrardate = explode("-", $date);
    $years = $arrardate[0] + 543;
    $months = $arrardate[1];

    switch ($months) {
        case "1":
            $month_receive = "มกราคม";
            break;
        case "2":
            $month_receive = "กุมภาพันธ์";
            break;
        case "3":
            $month_receive = "มีนาคม";
            break;
        case "4":
            $month_receive = "เมษายน";
            break;
        case "5":
            $month_receive = "พฤษภาคม";
            break;
        case "6":
            $month_receive = "มิถุนายน";
            break;
        case "7":
            $month_receive = "กรกฎาคม";
            break;
        case "8":
            $month_receive = "สิงหาคม";
            break;
        case "9":
            $month_receive = "กันยายน";
            break;
        case "10":
            $month_receive = "ตุลาคม";
            break;
        case "11":
            $month_receive = "พฤศจิกายน";
            break;
        case "12":
            $month_receive = "ธันวาคม";
            break;
    }

    return $month_receive . " " . $years;
}

//////เปลี่ยสีตามเดือน โดยจาก Y-m-d 
function monthcolor($date)
{
    $arrardate = explode("-", $date);
    $years = $arrardate[0] + 543;
    $months = $arrardate[1];

    switch ($months) {
        case "1":
            $color = "#AB0E08";
            break;
        case "2":
            $color = "#BD4CFE";
            break;
        case "3":
            $color = "#A9E0E8";
            break;
        case "4":
            $color = "#4E4E4F";
            break;
        case "5":
            $color = "#114313";
            break;
        case "6":
            $color = "#C97DC4";
            break;
        case "7":
            $color = "#C97DC4";
            break;
        case "8":
            $color = "#97DF62";
            break;
        case "9":
            $color = "#000769";
            break;
        case "10":
            $color = "#FE01BD";
            break;
        case "11":
            $color = "#FFCB00";
            break;
        case "12":
            $color = "#5373FE";
            break;
    }

    return $color;
}

///แบ่งหน้า
function paginationCtrls($page_rows, $total_data, $pagenum, $page_link)
{


    $last = ceil($total_data / $page_rows);
    if ($last < 1) {
        $last = 1;
    }

    if ($pagenum < 1) {
        $pagenum = 1;
    } else if ($pagenum > $last) {
        $pagenum = $last;
    }
    $limit = ' LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;
    $paginationCtrls = '';
    $paginationCtrls .= "<div class=\"btn-group\">";
    if ($last != 1) {
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $paginationCtrls .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='$page_link&page=$previous'\">" . "Previous </button>";
            // $paginationCtrls .= '<a href="?option=' . $option . '&page=' . $previous . '" class="btn btn-info">Previous</a> &nbsp; &nbsp; ';
            for ($i = $pagenum - 4; $i < $pagenum; $i++) {
                if ($i > 0) {
                    // $paginationCtrls .= '<a href="?option=' . $option . '&page=' . $i . '" class="btn btn-primary">' . $i . '</a> &nbsp; ';
                    $paginationCtrls .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='$page_link&page=$i'\">" . "$i" . "</button>";
                }
            }
        }
        // $paginationCtrls .= '' . $pagenum . ' &nbsp; '; ///หน้าปัจจุบัน
        $paginationCtrls .= "<button type=\"button\" class=\"btn btn-default\" disabled>" . "$pagenum" . "</button>";
        for ($i = $pagenum + 1; $i <= $last; $i++) {
            // $paginationCtrls .= '<a href="?option=' . $option . '&page=' . $i . '" class="btn btn-primary">' . $i . '</a> &nbsp; ';
            $paginationCtrls .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='$page_link&page=$i'\">" . "$i" . "</button>";
            if ($i >= $pagenum + 4) {
                break;
            }
        }
        if ($pagenum != $last) {
            $next = $pagenum + 1;
            // $paginationCtrls .= ' &nbsp; &nbsp; <a href="?option=' . $option . '&page=' . $next . '" class="btn btn-info">Next</a> ';
            $paginationCtrls .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location.href='$page_link&page=$next'\">" . "Next </button>";
        }
    }
    $paginationCtrls .= "</div>";
    ////////////END   //////////PAGING
    //// 0= $limit , 1 = $pagination
    return array($limit, $paginationCtrls);
}

///PHP base64 to image
function base64ToImage($base64_string, $output_file)
{
    $file = fopen($output_file, "wb");

    $data = explode(',', $base64_string);

    fwrite($file, base64_decode($data[1]));
    fclose($file);

    return $output_file;
}

//  YYYY-MM-DD
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function convertRelay($relay_param)
{
    switch ($relay_param) {
        case "relay1":
            $val = "V0";
            break;
        case "relay2":
            $val = "V1";
            break;
        case "relay3":
            $val = "V2";
            break;
        case "relay4":
            $val = "V3";
            break;
        case "relay5":
            $val = "V4";
            break;
        case "relay6":
            $val = "V5";
            break;
        case "relay7":
            $val = "V6";
            break;
        case "relay8":
            $val = "V7";
            break;
        case "relay9":
            $val = "V8";
            break;
        case "relay10":
            $val = "V9";
            break;
        default:
            $val = -1;
            break;
    }
    return  (string)$val;
}

function objectToArray($d)
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}
