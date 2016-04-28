<?php
namespace app\m;

class MMSQL {

    private static $instance;

    private $mysqli;

    //connection settings


    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new MMSQL();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->mysqli = new \mysqli(HOST, USER, PASSWORD, DBNAME);
        mysqli_query($this->mysqli, "SET NAMES UTF-8");
    }

    /**
     *
     * @param type $query string
     * @return type array of 
     */
    public function select($query) {
        $result = mysqli_query($this->mysqli, $query);

        if (!$result) {
            die(mysqli_error());
        }

        $n = mysqli_num_rows($result);

        $arr = array();

        for ($i = 0; $i < $n; $i++) {
            $row = mysqli_fetch_assoc($result);
            $arr[] = $row;
        }

        return $arr;
    }

    /**
     *
     * @param type $table table to insert/update
     * @param type $object is an array of object to insert
     * @return type id of insertet element
     */
    public function insert($table, $object) {
        $columns = array();
        $values = array();

        foreach ($object as $key => $value) {
            $key = mysqli_escape_string($this->mysqli, string($key . ''));
            $columns[] = $key;

            if ($value === null) {
                $values[] = 'NULL';
            } else {
                $value = mysqli_escape_string($this->mysqli, $value . '');
                $values[] = "'$value'";
            }
        }

        $columnsS = implode(',', $columns);
        $valuesS = implode(',', $values);

        $query = "INSERT INTO $table ($columnsS) VALUES ($valuesS)";

        $result = mysqli_query($this->mysqli, $query);

        if (!$result) {
            die(mysqli_error($this->mysqli));
        }


        return mysqli_insert_id($this->mysqli);
    }

    /**
     *
     * @param type $table
     * @param type $where
     * @return type
     */
    public function delete($table, $where) {
        $query = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->mysqli, $query);
        if (!$result) {
            die(mysqli_error($this->mysqli));
        }
        return mysqli_affected_rows($this->mysqli);
    }

    public function update($table, $object, $where) {
        $sets = array();

        foreach ($object as $key => $value) {
            $key = mysqli_real_escape_string($key . '');
            if ($value === null) {
                $sets[] = "$key=NULL";
            } else {
                $value = mysqli_real_escape_string($value . '');
                $sets[] = "$key='$value'";
            }
        }

        $setS = implode(',', $sets);

        $query = "UPDATE $table SET $setS WHERE $where";

        $result = mysqli_query($this->mysqli, $query);

        if (!$result) {
            die(mysqli_error($this->mysqli));
        }

        return mysqli_affected_rows($this->mysqli);
    }

}
