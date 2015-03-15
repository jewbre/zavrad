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

    public function MOption($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public static function get($optionName) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM options WHERE name = ?");
        $sql->execute(array($optionName));
        if($result = $sql->fetchAll(PDO::FETCH_OBJ)) {
            return new MOption($result->name, $result->option);
        }
        return false;
    }

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

    public static function getAll(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM options");
        if($sql->execute()) {
            return $sql->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }

}