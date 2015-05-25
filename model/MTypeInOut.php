<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.5.2015.
 * Time: 11:24
 */

class MTypeInOut {
    public $id;
    public $name;

    const TYPE_IN = "in";
    const TYPE_OUT = "out";
    const TYPE_PRICE_CHANGE = "price_change";

    public static function get($id){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM type_inout WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    public static function getByType($name){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM type_inout WHERE name = ?");
        $sql->execute(array($name));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    private static function fillFromDBData($data) {
        $tio = new MTypeInOut();
        $tio->id = $data->id;
        $tio->name = $data->name;
        return $tio;
    }

    public function isIn(){
        return $this->name == self::TYPE_IN;
    }

    public function isOut(){
        return $this->name == self::TYPE_OUT;
    }

    public function isPriceChange(){
        return $this->name == self::TYPE_PRICE_CHANGE;
    }
}