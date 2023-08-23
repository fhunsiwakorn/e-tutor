<?php

// require_once('ConfigDB_2.php');

class msystem
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

    public function mf($stlg_code,$language_id)
	{
		$stmt = $this->conn->prepare("SELECT stlg_text FROM tbl_system_language WHERE stlg_code='$stlg_code' AND language_id='$language_id'");
		$stmt->execute();
		$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $dataRow["stlg_text"];
    }


    public function fastQuery($sql)
{
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt;
}


public function lookupfild($Field,$table,$Where,$Value)
{
    $stmt = $this->conn->prepare("SELECT $Field FROM $table WHERE $Where='$Value'");
    $stmt->execute();
    $dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    return $dataRow[$Field];
}


}



	////////////////
	function DateThai($strDate)
	{
	  $strYear = date("Y",strtotime($strDate))+543;
	  $strMonth= date("n",strtotime($strDate));
	  $strDay= date("j",strtotime($strDate));
	  $strHour= date("H",strtotime($strDate));
	  $strMinute= date("i",strtotime($strDate));
	  $strSeconds= date("s",strtotime($strDate));
	  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	  $strMonthThai=$strMonthCut[$strMonth];
	  return "$strDay $strMonthThai $strYear";
    }
    

 //// คำนวนหาระยะห่างวัน
function DateDiff($strDate1,$strDate2)
{
     return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}
function TimeDiff($strTime1,$strTime2)
{
     return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1,$strDateTime2)
{
     return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}



    ////////random ///////////
    function random_password($max_length = 10){
		$text = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$text_length = mb_strlen($text, 'UTF-8');
		$pass = '';
		for($i=0;$i<$max_length;$i++){
		$pass .= @$text[rand(0, $text_length)];
		}
		return $pass;
		}
    
        
        function DatetoDMY($sendDate2){ 
            // 10/05/2018
        $arrstartx=explode("-",$sendDate2);
        $stday=$arrstartx[0];
        $stmonth=$arrstartx[1];
        $styear=$arrstartx[2];
        $udhd_before="$styear/$stmonth/$stday";
        return $udhd_before;
        }

        function DatetoDMYTime($sendDate2){ 

            $cut=explode(" ",$sendDate2);

            // 10/05/2018
        $arrstartx=explode("-",$cut[0]);
        $stday=$arrstartx[0];
        $stmonth=$arrstartx[1];
        $styear=$arrstartx[2];
        $udhd_before="$styear/$stmonth/$stday"." $cut[1]";
        return $udhd_before;
        }
        
function DateThai_2($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}


