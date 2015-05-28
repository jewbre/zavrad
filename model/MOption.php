<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:26
 */

class MOption {

    public $name;
    public $value;

    /**
     * Constructor of the model.
     * @param $name
     * @param $value
     */
    public function MOption($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get single option by its name.
     * @param $optionName
     * @return bool|MOption
     */
    public static function get($optionName) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM options WHERE name = ?");
        $sql->execute(array($optionName));
        if($result = $sql->fetchAll(PDO::FETCH_OBJ)) {
            return new MOption($result->name, $result->option);
        }
        return false;
    }

    /**
     * Save or update current option. Model automaticly evaluates what will be done.
     * @return bool success of the operation.
     */
    public function saveOrUpdate(){
        if(empty($this->name) || empty($this->value)) return false;

        $db = MDBConnection::getConnection();
        $getSql = $db->prepare("SELECT * FROM options WHERE name = ?");
        $getSql->execute(array($this->name));
        if($result = $getSql->fetch(PDO::FETCH_OBJ)) {
            $updateSql = $db->prepare("UPDATE options SET value = ? WHERE name = ?");
            return $updateSql->execute(array($this->value, $this->name));
        } else {
            $saveSql = $db->prepare("INSERT INTO options VALUES(?,?)");
            return $saveSql->execute(array($this->name, $this->value));
        }
    }

    /**
     * Retrieve all options. Returns false if fails.
     * @return array|bool
     */
    public static function getAll(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM options");
        if($sql->execute()) {
            $results = $sql->fetchAll(PDO::FETCH_OBJ);
            $data = new stdClass();
            foreach($results as $result){
                $name = $result->name;
                $data->$name = new stdClass();
                $data->$name->value = $result->value;

                switch($name){
                    case "allowBuying":
                        $data->$name->value = boolval($result->value);
                        break;
                }
            }
            return $data;
        }
        return false;
    }

}