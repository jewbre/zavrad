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
            $result->option = ($result->name == "menuItems" || $result->name == "slider" ) ? json_decode($result->option) : $result->option;
            return new MOption($result->name, $result->option);
        }
        return false;
    }

    /**
     * Save or update current option. Model automaticly evaluates what will be done.
     * @return bool success of the operation.
     */
    public function saveOrUpdate(){
        if(empty($this->name)) return false;

        $db = MDBConnection::getConnection();
        $getSql = $db->prepare("SELECT * FROM options WHERE name = ?");
        $getSql->execute(array($this->name));
        if($result = $getSql->fetch(PDO::FETCH_OBJ)) {
            $updateSql = $db->prepare("UPDATE options SET value = ? WHERE name = ?");
            $result = $updateSql->execute(array($this->value, $this->name));
            return $result;
        } else {
            $saveSql = $db->prepare("INSERT INTO options(name,value) VALUES(?,?)");
            $result =  $saveSql->execute(array($this->name, strval($this->value)));
            return $result;
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
                        $data->$name->value = (bool)($result->value);
                        break;
                    case "menuItems":
                        $data->$name->value = json_decode($result->value);
                        break;
                    case "slider":
                        $data->$name->value = json_decode($result->value);
                        break;
                }
            }
            return $data;
        }
        return false;
    }

}