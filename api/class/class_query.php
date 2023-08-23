<?php
class function_query
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

    public function insert($table, array $data)
    {

        /*
     * Check for input errors.
     */
        if (empty($data)) {
            throw new InvalidArgumentException('Cannot insert an empty array.');
        }
        if (!is_string($table)) {
            throw new InvalidArgumentException('Table name must be a string.');
        }

        $fields = implode(",", array_keys($data));
        $placeholders = ':' . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$table} ($fields) VALUES ({$placeholders})";

        // ///แสดง sql
        // echo "<center>";
        // var_dump($sql);
        // echo "</center>";

        // Prepare new statement
        $stmt = $this->conn->prepare($sql);

        /*
     * Bind parameters into the query.
     *
     * We need to pass the value by reference as the PDO::bindParam method uses
     * that same reference.
     */
        foreach ($data as $placeholder => &$value) {

            // Prefix the placeholder with the identifier
            $placeholder = ':' . $placeholder;

            // Bind the parameter.
            $stmt->bindparam($placeholder, $value);
        }

        /*
     * Check if the query was executed. This does not check if any data was actually
     * inserted as MySQL can be set to discard errors silently.
     */

        if (!$stmt->execute()) {
            throw new ErrorException('Could not execute query');
        }

        /*
     * Check if any rows was actually inserted.
     */
        if ($stmt->rowCount() == 0) {

            var_dump($this->pdo->errorCode());

            throw new ErrorException('Could not insert data into users table.');
        }

        return true;
    }


    public function update($table, array $data, array $Where)
    {

        /*
     * Check for input errors.
     */
        if (empty($data)) {
            throw new InvalidArgumentException('Cannot insert an empty array.');
        }
        if (!is_string($table)) {
            throw new InvalidArgumentException('Table name must be a string.');
        }

        ///fields update
        $fields = implode("', '", array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $fields5 = array_keys($data);
        ///fields where
        $fields2 = "'" . implode("', '", array_keys($Where)) . "'";
        $placeholders2 = ':' . implode(', :', array_keys($Where));

        $sql = "UPDATE  {$table} SET ";
        ///fields update
        $keys = array_keys($data);
        for ($i = 0; $i < count($data); $i++) {

            $sql .= $keys[$i] . "=:" . $keys[$i];


            // Parse to add commas
            if ($i != count($data) - 1) {
                $sql .= ',';
            }
        }
        $sql .= " WHERE ";
        ///fields Where
        $keys2 = array_keys($Where);
        for ($i = 0; $i < count($Where); $i++) {
            // if(is_string($data[$keys[$i]])){
            // 	$sql .= $keys2[$i]."='".$Where[$keys2[$i]]."'" ;
            // }else{
            // 	$sql .= $keys2[$i]."=".$Where[$keys2[$i]] ;
            // }

            $sql .= $keys2[$i] . "=:" . $keys2[$i];

            // Parse to add commas
            if ($i != count($Where) - 1) {
                $sql .= ' AND ';
            }
        }
        ///แสดง sql
        // echo "<center>";
        // var_dump($sql);
        // echo "</center>";
        // Prepare new statement
        $stmt = $this->conn->prepare($sql);

        /*
     * Bind parameters into the query.
     *
     * We need to pass the value by reference as the PDO::bindParam method uses
     * that same reference.
     */
        foreach ($data as $placeholder => &$value) {

            // Prefix the placeholder with the identifier
            $placeholder = ':' . $placeholder;

            // Bind the parameter.
            $stmt->bindparam($placeholder, $value);
        }

        foreach ($Where as $placeholder2 => &$value2) {

            // Prefix the placeholder with the identifier
            $placeholder2 = ':' . $placeholder2;

            // Bind the parameter.
            $stmt->bindparam($placeholder2, $value2);
        }
        /*
     * Check if the query was executed. This does not check if any data was actually
     * inserted as MySQL can be set to discard errors silently.
     */

        if (!$stmt->execute()) {
            throw new ErrorException('Could not execute query');
        }

        /*
     * Check if any rows was actually inserted.
     */
        if ($stmt->rowCount() == 0) {

            // var_dump($this->pdo->errorCode());

            throw new ErrorException('Could not insert data into users table.');
        }

        return true;
    }


    public function delete($table, array $where)
    {

        $keys = array_keys($where);
        $counts = count($where);
        for ($i = 0; $i < $counts; $i++) {
            if ($i <= 1) {
                $sql = " WHERE ";
            }

            if (is_string($where[$keys[$i]])) {
                $sql .= $keys[$i] . "='" . $where[$keys[$i]] . "'";
            } else {
                $sql .= $keys[$i] . "=" . $where[$keys[$i]];
            }

            // Parse to add commas
            if ($i != count($where) - 1) {
                $sql .= ' AND ';
            }
        }

        try {
            // $stmt = $this->conn->prepare("DELETE FROM $table $sql");
            if ($counts > 0) {
                $stmt = $this->conn->prepare("DELETE FROM $table $sql ");
            } else {
                $stmt = $this->conn->prepare("DELETE FROM $table");
            }

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ///จัดการข้อมูลในคำสั่งเดียว
    public function exq($sql)
    {
        $stmt = $this->conn->query($sql);
        // $stmt->execute();
        return $stmt;
    }
    ///นับแถว
    public function rowsQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $total_data = $stmt->rowCount();
        return $total_data;
    }

    //คิวรี่แบบมีเงื่อนไข โดยมีฟังก์ชัน $command= Sum,Max,Min,Avg,Count
    public function qcondition($table, $fields, $command, $where)
    {
        // $command= SUM,AVG,MAX,MIN
        $stmt = $this->conn->prepare("SELECT $command($fields) AS resultFields FROM $table WHERE $where");
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dataRow) {
            return false;
        } else {
            return $dataRow["resultFields"];
        }
    }

    //แสดงรายการที่ต้องการโดยมีเงื่อนไขเดียว
    public function single_fild($Field, $table, $Where, $Value)
    {
        $stmt = $this->conn->prepare("SELECT $Field FROM $table WHERE $Where=:val");
        // $stmt->execute();
        $stmt->execute(array(":val" => $Value));
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dataRow) {
            return false;
        } else {
            return $dataRow[$Field];
        }
    }
    //แสดงรายการที่ต้องการโดยมีเงื่อนไขเดียว
    public function fetch_num_fild($table, $Where, $Value)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE $Where=:val");
        // $stmt->execute();
        $stmt->execute(array(":val" => $Value));
        $dataRow = $stmt->fetch(PDO::FETCH_NUM);

        if (!$dataRow) {
            return false;
        } else {
            return $dataRow;
        }
    }
    //แสดงรายการที่ต้องการโดยมีหลายเงื่อนไข
    public function singlefild_condition($Field, $table, $Condition)
    {
        $stmt = $this->conn->prepare("SELECT $Field FROM $table WHERE $Condition");
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dataRow) {
            return false;
        } else {
            return $dataRow[$Field];
        }
    }

    ////หาฟิวล่าสุดหรือเก่าสุด
    public function lookuporder($Field, $table, $Orderindex, $Orderby)
    {
        $stmt = $this->conn->prepare("SELECT $Field FROM $table  ORDER BY $Orderindex $Orderby");
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dataRow) {
            return false;
        } else {
            return $dataRow[$Field];
        }
    }

    //เฟทข้อมูลในตาราง
    public function fechdata($table, $Condition)
    {
        $req = $this->conn->prepare("SELECT * FROM $table  $Condition");
        $req->execute();
        $data_fech = $req->fetchAll();

        if (!$data_fech) {
            return false;
        } else {
            return   $data_fech;
        }
    }

    //เฟทเฉพาะข้อมูลบางส่วน
    public function fechdata2($fields, $table, $Condition)
    {
        $req = $this->conn->prepare("SELECT $fields FROM $table  $Condition");
        $req->execute();
        $data_fech = $req->fetchAll();
        if (!$data_fech) {
            return false;
        } else {
            return   $data_fech;
        }
    }
    //เฟทข้อมูลในตารางโดยผ่านคำสั่ง sql ทั้งหมด เฉพาะ Value ตัวแปรเฉพาะ
    public function fechdata3($sql)
    {
        $req = $this->conn->prepare($sql);
        $req->execute();
        $data_fech = $req->fetchAll();
        if (!$data_fech) {
            return false;
        } else {
            return   $data_fech;
        }
    }

    //ไปยังหน้าที่ set ไว้
    public function redirect($url)
    {
        header("Location: $url");
    }

    //สร้าง Token
    public function get_token()
    {

        if (isset($_SESSION['token_form'])) {
            $token = $_SESSION['token_form'];
            return $token;
        } else {
            $_SESSION['token_form'] = time() . mt_rand();
            $token = $_SESSION['token_form'];
            return $token;
        }
    }

    public function close_token($cons)
    {
        if ($cons == "true") {
            unset($_SESSION['token_form']);
            return true;
        } else {
            return false;
        }
    }

    public function log($log_name, $user_id)
    {
        //SQL : SET GLOBAL time_zone = 'Asia/Bangkok';

        $log_ip = $_SERVER['REMOTE_ADDR']; //Get user IP 
        $log_user_agent = $_SERVER['HTTP_USER_AGENT'];

        $req = $this->conn->prepare("INSERT INTO tbl_log (log_name,log_ip,log_user_agent,user_id) VALUES('$log_name','$log_ip','$log_user_agent','$user_id')");
        $req->execute();
        return   true;
    }
}
