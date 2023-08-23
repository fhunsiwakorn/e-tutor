<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods:POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
header('Access-Control-Max-Age: 86400');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // The request is using the POST method
    header("HTTP/1.1 200 OK");
    return;
}


require_once("../dbl_config.php");
require_once("../class/class_function.php");
require_once("../class/class_query.php");
$sql_process = new function_query();

//Check Key
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    http_response_code(403);
    echo json_encode(array("status" => "Fail", "message" => "Bad API"));
    exit;
}
if (isset($headers['Authorization'])) {
    $api_key = $headers['Authorization'];
    if ($api_key != $seceretKey) {
        //403,'Authorization faild'; your logic
        http_response_code(403);
        echo json_encode(array("status" => "Fail", "message" => "Bad API"));
        exit;
    }
}

// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if (
    isset($data->user_name) &&
    isset($data->user_prefix) &&
    isset($data->user_firstname) &&
    isset($data->user_lastname) &&
    isset($data->user_id_card) &&
    isset($data->user_tel) &&
    isset($data->user_email) &&
    isset($data->school_code)
) {
    $presentday = date("Y-m-d H:i:s");
    // set product property values
    $table = "user_member_group";
    $user_name = $data->user_name;
    $user_prefix = $data->user_prefix;
    $user_firstname = $data->user_firstname;
    $user_lastname = $data->user_lastname;
    $user_id_card = $data->user_id_card;
    $user_tel = $data->user_tel;
    $user_email = $data->user_email;
    $school_code = $data->school_code;


    $user_password = $data->user_id_card;
    $user_status = 2;
    $user_code = random_password(20);
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    ///ChkUser ซ้ำ
    $chkuser = $sql_process->rowsQuery("SELECT  user_name FROM   $table  WHERE user_name ='$user_name'");

    $user_date = 30;

    $school_id = $sql_process->single_fild("school_id", "tbl_school", "school_code", $school_code);
    $compair_course = $sql_process->single_fild("compair_course", "tbl_school", "school_code", $school_code);
    $strNewDate = date("Y-m-d", strtotime("+$user_date day", strtotime($presentday)));

    if ($chkuser > 0) {
        echo json_encode(array("status" => "Fail", "message" => "Invalid user"));
        http_response_code(400);
        exit;
    }

    if (!$school_id) {
        echo json_encode(array("status" => "Fail", "message" => "Invalid school_code"));
        http_response_code(400);
        exit;
    }


    $fields = [
        'user_name' => $user_name,
        'user_password' => $hash_password,
        'user_password_2' => $user_name,
        'user_prefix' => $user_prefix,
        'user_firstname' => $user_firstname,
        'user_lastname' => $user_lastname,
        'user_id_card' => $user_id_card,
        'user_tel' => $user_tel,
        'user_email' => $user_email,
        'user_img' => False,
        'user_date' => $user_date,
        'user_date_start' => $presentday,
        'user_date_end' => $strNewDate,
        'user_testing_date' => $presentday,
        'user_date_status' => 1,
        'school_id' => $school_id,
        'user_status' => $user_status,
        'user_code' => $user_code,
    ];
    try {
        $sql_process->insert($table, $fields);
    } catch (ErrorException $exception) {
        $exception->getMessage();  // Should be handled with a proper error message.

    }
    ///เพิ่มหลักสูตร
    $sql_process->exq("INSERT INTO exam_permission (type_id,user_code,school_id)
    SELECT 
    tbl_permission_course.type_id AS type_id,
    IF(tbl_permission_course.compair_course !='','$user_code','') AS user_code,
    IF(tbl_permission_course.compair_course !='','$school_id','') AS school_id
   FROM
   tbl_permission_course
   WHERE
   tbl_permission_course.compair_course='$compair_course'
    ");

    echo json_encode(array("status" => "Success", "message" => "Added Successfully"));
}

// tell the user data is incomplete
else {
    echo json_encode(array("status" => "Fail", "message" => "Unable to create farm. Data is incomplete."));
    http_response_code(400);
    exit;
}
